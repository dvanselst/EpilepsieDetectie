#include "DHT.h"
#include <SPI.h>
#include <Ethernet.h>
#define DHTPIN 2     
#define DHTTYPE DHT11   
DHT dht(DHTPIN, DHTTYPE);
byte mac[] = { 0xA8, 0x61, 0x0A, 0xAE, 0x96, 0x5E };  
byte ip[] = { 10, 10, 10, 21 };  
byte serv[] = {10, 10, 10, 20} ;
EthernetClient cliente;


void setup() {
  Serial.begin(9600);
  Ethernet.begin(mac, ip);
  Serial.println(F("DHTxx test!"));
  dht.begin();
  EthernetClient cliente;
}

void loop() {
int aanval = 0;
float hum = dht.readHumidity(); 
float temp = dht.readTemperature(); 
float fah = dht.readTemperature(true); 
float heat_index = dht.computeHeatIndex(fah, hum); 
float heat_indexC = dht.convertFtoC(heat_index); 
if (cliente.connect(serv, 8080)) { 
Serial.println("connected");
cliente.print("GET /ethernet/arduinoconnect.php?"); 
cliente.print("temperature=");
cliente.print(temp);
cliente.print("&humidity=");
cliente.print(hum);
cliente.print("&heat_index=");
cliente.print(heat_indexC);
cliente.print("&aanval=");
cliente.println(aanval);
Serial.print("Temperature= ");
Serial.println(temp);
Serial.print("Humidity= ");
Serial.println(hum);
Serial.print("Heat Index= ");
Serial.println(heat_indexC);
Serial.print("aanval= ");
Serial.println(aanval);
cliente.stop(); 
}
else {
Serial.println("connection failed");
}
delay(2000);
}
