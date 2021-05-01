void setup() {
  // initialize serial communication:
  Serial.begin(9600);
  pinMode(2, OUTPUT);
}

void loop() {

  // read the sensor:
  if (Serial.available() > 0) {

    int inByte = Serial.read();
	//set the byte to what you want to be sent
     if (inByte == 'testtest'){

        digitalWrite(2, HIGH);
        delay(500);
        digitalWrite(2, LOW);
     }
     else
      digitalWrite(2,LOW);

  }
}
