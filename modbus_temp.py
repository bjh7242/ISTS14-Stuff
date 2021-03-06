#!/usr/bin/env python

from pymodbus.server.async import StartTcpServer
from pymodbus.device import ModbusDeviceIdentification
from pymodbus.datastore import ModbusSequentialDataBlock
from pymodbus.datastore import ModbusSlaveContext, ModbusServerContext
from pymodbus.transaction import ModbusRtuFramer, ModbusAsciiFramer
from twisted.internet.task import LoopingCall
from threading import Thread
from time import sleep
import os
import argparse
import random

temperature = 0

class Temp(Thread):
    def __init__(self, fileName=''):
        Thread.__init__(self)
        self.fileName = fileName
        self.currentTemp = -999
        self.correctionFactor = 1;
        self.enabled = True

    def run(self):
        while True:
            temp = self.getCurrentTemp()
            self.currentTemp = temp
            print "Current: " + str(self.currentTemp) + " " + str(self.fileName)
            sleep(5)

    #returns the current temp for the probe
    def getCurrentTemp(self):
        #return random.randrange(65,75)
        return random.randrange(65,85)

    #setter to enable this probe
    def setEnabled(self, enabled):
        self.enabled = enabled
    #getter
    def isEnabled(self):
        return self.enabled

def updating_writer(a):
    context  = a[0]
    register = 3
    slave_id = 0x00
    address  = 0x00
    values = [int(pi.getCurrentTemp())]
    context[slave_id].setValues(register,address,values)

def main():
    # initialize the four register types
    store = ModbusSlaveContext(
        di = ModbusSequentialDataBlock(0, [0]*100),
        co = ModbusSequentialDataBlock(0, [0]*100),
        hr = ModbusSequentialDataBlock(0, [0]*100),
        ir = ModbusSequentialDataBlock(0, [0]*100))
    context = ModbusServerContext(slaves=store, single=True)
    
    identity = ModbusDeviceIdentification()
    identity.VendorName  = 'SPARSA'
    identity.ProductCode = 'SP'
    identity.VendorUrl   = 'http://gentoocloud.com/bitchimabus'
    identity.ProductName = 'SPARSA Temperature Sensor'
    identity.ModelName   = 'SP_1337'
    identity.MajorMinorRevision = '1.0'
    pi.start()
    time = 5 # 5 seconds delaytime = 5 # 5 seconds delay
    loop = LoopingCall(f=updating_writer, a=(context,))
    loop.start(time, now=False) # initially delay by time
    StartTcpServer(context, identity=identity, address=(args.address, 502))

if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Listens on a specified interface for modbus connections')
    parser.add_argument('-a', dest='address', help='The IP address to bind to', required=True)

    # read arguments (the name of the file to copy)
    args = parser.parse_args()
    pi = Temp()
    main()
