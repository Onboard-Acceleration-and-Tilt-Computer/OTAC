import smbus
import math
import time
import smoothing
import paho.mqtt.client as client
import datetime
import RPi.GPIO as GPIO
import os

GPIO.setmode(GPIO.BCM)
GPIO.setup(26, GPIO.IN)

MQTT_SERVER = "wiedenfeld.selfhost.eu"	# MQTT Broker Adresse
MQTT_PATH = "OTAC"	# MQTT Topic

sleep_dur = .08		# (.08) ~ 10 Durchlaufe die Sekunde
setback = 0
setclock = 0
# Register
power_mgmt_1 = 0x6b		# Hex-Adressen der Schnittstellen um diese ansprechen zu koennen
power_mgmt_2 = 0x6c
###################################################################### Funktionen zum Ansprechen des Gyroskops #############################
def read_byte(reg):
    return bus.read_byte_data(address, reg)
 
def read_word(reg):
    h = bus.read_byte_data(address, reg)
    l = bus.read_byte_data(address, reg+1)
    value = (h << 8) + l
    return value
 
def read_word_2c(reg):
    val = read_word(reg)
    if (val >= 0x8000):
        return -((65535 - val) + 1)
    else:
        return val
 
def dist(a,b):
    return math.sqrt((a*a)+(b*b))
 
def get_y_rotation(x,y,z):
    radians = math.atan2(x, dist(y,z))
    return -math.degrees(radians)
 
def get_x_rotation(x,y,z):
    radians = math.atan2(y, dist(x,z))
    return math.degrees(radians)
 
bus = smbus.SMBus(1) # bus = smbus.SMBus(0) fuer Revision 1
address = 0x68       # via i2cdetect
 
# Aktivieren, um das Modul ansprechen zu koennen
bus.write_byte_data(address, power_mgmt_1, 0)
 
sender = client.Client("OTACC")		#Klasse erstellen
sender.connect(MQTT_SERVER,1883)	#Verbindung zum Broker herstellen
print("ACC\t|\tY\t|\tX")
while(True):
	gyroskop_xout = read_word_2c(0x43)
	gyroskop_yout = read_word_2c(0x45)
	gyroskop_zout = read_word_2c(0x47)

	beschleunigung_xout = read_word_2c(0x3b)
	beschleunigung_yout = read_word_2c(0x3d)
	beschleunigung_zout = read_word_2c(0x3f)
 
	beschleunigung_xout_skaliert = beschleunigung_xout / 16384.0
	beschleunigung_yout_skaliert = beschleunigung_yout / 16384.0
	beschleunigung_zout_skaliert = beschleunigung_zout / 16384.0
	
	SACC = int(smoothing.acc_smooth(beschleunigung_yout)-setback)
	XROT = int(get_x_rotation(beschleunigung_xout_skaliert, beschleunigung_yout_skaliert, beschleunigung_zout_skaliert)+1)
	YROT = int(get_y_rotation(beschleunigung_xout_skaliert, beschleunigung_yout_skaliert, beschleunigung_zout_skaliert))

	print(str(SACC) + "\t|\t"+ str(YROT) + "\t|\t" + str(XROT) + "\t|\t" + str(datetime.datetime.now().time()))

	sender.publish(MQTT_PATH, str(SACC) + " " + str(YROT) + " " + str(XROT) + " " + str(datetime.datetime.now().time()))		# Daten senden

	if(gyroskop_xout == 0):		# Wenn das Modul keine Daten mehr liefert wird es neu aufgesetzt
		print("FAIL")
		time.sleep(sleep_dur)
		bus.write_byte_data(address, power_mgmt_1, 0)
	time.sleep(sleep_dur)	# (.08) ~ 10 Durchlaufe die Sekunde
	setclock = setclock + 1
	if setclock is 30:
		setback = SACC
	if GPIO.input(26) == 0:					# Wenn die Zuendung aus ist faehrt der Pi selbstaendig herunter
		os.system("sudo shutdown now")