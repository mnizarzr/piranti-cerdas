#define BUZZER 22

void setup(){
    pinMode(BUZZER, OUTPUT);
}

void loop(){
    tone(BUZZER, 256, 500);
    tone(BUZZER, 512, 500);
    delay(1000);
    analogWrite(BUZZER, 128);
    delay(1000);
    analogWrite(BUZZER, 0);
    delay(1000);
}
