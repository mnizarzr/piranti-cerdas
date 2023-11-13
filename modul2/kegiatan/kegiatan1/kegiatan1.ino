// #define LED 22
#define LDR 13

void setup()
{
    Serial.begin(9600);
}

void loop()
{
    Serial.println(analogRead(LDR));
    delay(10);
}
