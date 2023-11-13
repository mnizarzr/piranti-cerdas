#define LDR_PIN 23

void setup(){
    Serial.begin(9600);
}

void loop(){
    int analogValue = analogRead(LDR_PIN);
    Serial.print("Analog Value = ");
    Serial.print(analogValue);
    Serial.println("");
}
