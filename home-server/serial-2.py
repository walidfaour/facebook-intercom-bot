import sys
import serial

ser = serial.Serial()
ser.baudrate = 9600
ser.port = 'COM6'

ser.open()
ser.write(b'testtest')
ser.close()
sys.exit(1)