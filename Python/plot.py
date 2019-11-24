import paho.mqtt.client as mqtt

i = -1
if i is -1:
    acc = []
    time = []

MQTT_SERVER = "wiedenfeld.selfhost.eu" #Broker Adress (Mosquitto Server)
MQTT_PATH = "OTAC"  #Topic


def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))
    
    client.subscribe(MQTT_PATH)
 

def on_message(client, userdata, msg):
    mess = str(msg.payload).strip('b \'')
    msgsplit = mess.split()
    i = 0
    for x in msgsplit:
        if i is 0:
            acc.append(x)
            print(x)
        elif i is 3:
            time.append(x)
            print(x)
        i = i + 1



client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect(MQTT_SERVER, 1883, 60)
 
try:
    while True:
        client.loop_forever()
except KeyboardInterrupt:
    pass


import matplotlib.pyplot as plt
plt.plot(time, acc)
plt.ylabel('Beschleunigung')
plt.xlabel('Zeit')
plt.show()