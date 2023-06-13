/*
  MQUnifiedsensor Library - reading an MQ6

  Demonstrates the use a MQ6 sensor.
  Library originally added 01 may 2019
  by Miguel A Califa, Yersson Carrillo, Ghiordy Contreras, Mario Rodriguez
 
  Added example
  modified 23 May 2019
  by Miguel Califa 

  Updated library usage
  modified 26 March 2020
  by Miguel Califa 

  Wiring:
  https://github.com/miguel5612/MQSensorsLib_Docs/blob/master/static/img/MQ_Arduino.PNG
  Please make sure arduino A0 pin represents the analog input configured on #define pin

 This example code is in the public domain.

*/

//Include the library
#include <WiFi.h>
#include <MQUnifiedsensor.h>

const char * host = "10.150.149.66";
const int Port = 80;

const char* ssid = "bssm_free";
const char* password = "bssm_free";

WiFiClient client;

//Definitions
#define placa "Arduino UNO"
#define Voltage_Resolution 3.3  //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
#define pin A0 //Analog input 0 of your arduino
#define type "MQ-6" //MQ6
#define ADC_Bit_Resolution 12 //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
#define RatioMQ6CleanAir 10   //RS / R0 = 10 ppm 
//#define calibration_button 13 //Pin to calibrate your sensor

//Declare Sensor
MQUnifiedsensor MQ6(placa, Voltage_Resolution, ADC_Bit_Resolution, pin, type);

void setup() {
  //Init the serial port communication - to debug the library
  Serial.begin(115200); //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

  //Set math model to calculate the PPM concentration and the value of constants
  MQ6.setRegressionMethod(1); //_PPM =  a*ratio^b
  MQ6.setA(2127.2); MQ6.setB(-2.526); // Configure the equation to to calculate CH4 concentration
  /*
    Exponential regression:
  GAS     | a      | b
  H2      | 88158  | -3.597
  LPG     | 1009.2 | -2.35
  CH4     | 2127.2 | -2.526
  CO      | 1000000000000000 | -13.5
  Alcohol | 50000000 | -6.017
  */
  
  /*****************************  MQ Init ********************************************/ 
  //Remarks: Configure the pin of arduino as input.
  /************************************************************************************/ 
  MQ6.init();   
  /* 
    //If the RL value is different from 10K please assign your RL value with the following method:
    MQ6.setRL(10);
  */
  /*****************************  MQ CAlibration ********************************************/ 
  // Explanation: 
   // In this routine the sensor will measure the resistance of the sensor supposedly before being pre-heated
  // and on clean air (Calibration conditions), setting up R0 value.
  // We recomend executing this routine only on setup in laboratory conditions.
  // This routine does not need to be executed on each restart, you can load your R0 value from eeprom.
  // Acknowledgements: https://jayconsystems.com/blog/understanding-a-gas-sensor
  Serial.print("Calibrating please wait.");
  float calcR0 = 0;
  for(int i = 1; i<=10; i ++)
  {
    MQ6.update(); // Update data, the arduino will read the voltage from the analog pin
    calcR0 += MQ6.calibrate(RatioMQ6CleanAir);
    Serial.print(".");
  }
  MQ6.setR0(calcR0/10);
  Serial.println("  done!.");
  
  if(isinf(calcR0)) {Serial.println("Warning: Conection issue, R0 is infinite (Open circuit detected) please check your wiring and supply"); while(1);}
  if(calcR0 == 0){Serial.println("Warning: Conection issue found, R0 is zero (Analog pin shorts to ground) please check your wiring and supply"); while(1);}
  /*****************************  MQ CAlibration ********************************************/ 

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  
}

void loop() {
  if (!client.connect(host, Port)) {
    Serial.println("connection failed");
    return;
  }
  Serial.println("서버와 연결되었습니다!");
  //2.클라이언트가 서버에 request를 전송한다

  MQ6.update(); //호출
  float data1 = MQ6.readSensor(); //실수데이터
  int data2 = analogRead(39);
  
  String url = "/bssm2_4/gas.php?gas="+String(data1)+"&cds=" + String(data2);
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: "+ host +"\r\n" +
               "Connection: close\r\n\r\n");
  //3.서버가 클라이언트에게 response를 전송한다
  unsigned long t = millis(); //생존시간
  while(1){
    if(client.available()) break;
    if(millis() - t > 10000) break;
  }
  //응답이 왔거나 시간안에 응답이 안왔다!
  Serial.println("응답이 도착했습니다");
  while(client.available()){
    
    Serial.write(client.read());
  }
  //4.둘사이의 연결이 끊어진다!
  Serial.println("연결이 해제되었습니다!");
  delay(1000); //Sampling frequency
}
