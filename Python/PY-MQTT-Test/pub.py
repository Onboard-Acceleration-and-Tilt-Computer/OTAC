import paho.mqtt.client as client
import time
import datetime
import random
MQTT_SERVER = "localhost"
MQTT_PATH = "OTAC"

sender = client.Client("OTACC")
sender.connect(MQTT_SERVER,1883)
while(True):
    for x in range(10):
        SACC = str(random.randint(-25000, 25000))
        YROT = str(random.randint(-99,99))
        XROT = str(random.randint(-99,99))
        sender.publish(MQTT_PATH, str(SACC) + " " + str(YROT) + " " + str(XROT) + " " + str(datetime.datetime.now().time()))		# Daten senden mit QoS = 0
        print(str(SACC) + " " + str(YROT) + " " + str(XROT) + " " + str(datetime.datetime.now().time()))
        time.sleep(.1)