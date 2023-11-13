#include <Arduino.h>
#include <HTTPClient.h>
#include <WiFi.h>

#define SENSORPIN 34
#define LEDPIN 25

String ssid = "aezakmi";
String password = "33448877";
String server = "http://192.168.1.100:8070";

void setup()
{
  Serial.begin(9600);
  pinMode(LEDPIN, OUTPUT);
  delay(1000);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(1000);
    Serial.println("Connecting to WiFI...");
  }

  String wifiName = WiFi.SSID();
  String localWifiIp = WiFi.localIP().toString();
  Serial.println();
  Serial.println("Connected to: " + wifiName);
  Serial.println("Local IP WIFI: " + localWifiIp);
}

void loop()
{
  int ldr_value = analogRead(SENSORPIN);

  if (ldr_value > 100)
  {
    Serial.println("=== Cahaya Terang ===");
    digitalWrite(LEDPIN, LOW);
    Serial.print("Intensitas Cahaya: ");
    Serial.print(ldr_value);
    Serial.println();
  }
  else
  {
    Serial.println("=== Cahaya Gelap ===");
    digitalWrite(LEDPIN, HIGH);
    Serial.print("Intensitas Cahaya: ");
    Serial.print(ldr_value);
    Serial.println();
  }

  delay(1000);

  String url = server;
  url += "?ldr_value=";
  url += String(ldr_value);

  HTTPClient http;
  http.begin(url);
  int httpResponseCode = http.GET();

  if (httpResponseCode == 200)
  {
    Serial.println("Date send successfully!");
  }
  else
  {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }

  http.end();
  delay(10000);
}
