#!/usr/bin/env python
# modified from: http://pymodbus.readthedocs.org/en/latest/examples/synchronous-client.html

from pymodbus.client.sync import ModbusTcpClient as ModbusClient
import logging
import argparse
import subprocess
import time
import sys
import random
import threading
import time

temperature_dir = '/var/www/html/ISTS14-Stuff/SCADASite/'

class myThread(threading.Thread):
    def __init__(self, threadID, name, filename, addr, temp):
        threading.Thread.__init__(self)
        threadLock.acquire()
        self.threadID = threadID
        self.name = name
        self.filename = filename
        self.addr = addr
        #self.temp = temp 
        self.temp = self.get_temp(self.name, self.addr)
        time.sleep(5)
        threadLock.release()

    #def run(self):
        #print "Starting " + self.name
        # Get lock to synchronize threads
        #self.temp = self.get_temp(self.name, self.addr)
        # Free lock to release next thread

    def get_temp(self, threadName, addr):
        try:
            client = ModbusClient(addr, port=502)
            client.connect()
            rr = client.read_holding_registers(0x00,1,unit=1)
            temp = rr.registers[0]
            print "TEMP FOR " + str(self.name) + " IS: " + str(temp)
            return temp
        except:
            #print "UNABLE TO CONNECT TO: " + addr
            # LOG A MISSED CHECK TO THE POWEROFF LOG HERE
            return None

def poweroff_team(team):
    # check poweroff log to see when last poweroff was, if within the last hour don't power off
    print "POWERING OFF TEAM " + str(team)
    # write out to log file
    # call poweroff script

def check_missed_check(team):
    """ 
    Check to see when the poweroff log says the last missed check was
    """
    print "TEAM " + str(team) + " missed last check at time X"

def main():
    # connect to modbus slave
    #sensor_addrs = ['10.3.0.253','10.3.1.253','10.3.2.253','10.3.3.253','10.3.4.253']
    #sensor_addrs = ['10.3.0.253']
    #sensor_addrs = ['10.0.0.200','192.168.1.152','127.0.0.1']
    #team_sensors = { 't1-temp.txt': '10.0.0.200', 't2-temp.txt': '127.0.0.1', 't3-temp.txt': '192.168.1.152' }
    team_sensors = { 't1-temp.txt': '10.0.0.200', 't2-temp.txt': '127.0.0.1' }
    threads = []

    while True:
        count = 0
        for filename in team_sensors:
            # Create new threads
            # sensor_addrs[filename] == address to connect to
            new_thread = myThread(1, "Thread-" + str(count), filename, team_sensors[filename], 0)
            #print "new_thread TEMP IS: " + str(new_thread.temp)

            # Start new Threads
            new_thread.start()
            
            # Add threads to thread list
            threads.append(new_thread)

            count += 1
            
        # Wait for all threads to complete
        # log temperature to a file here?
        for t in threads:
            #print "TEMP IS: " + str(t.temp) + " for " + str(t.addr)
            with open(temperature_dir + t.filename,'w') as f:
                if (t.temp != None and t.temp < 80):
                    print "SETTING TEAM NUMBER: " + str(t.filename[:2]) + " TO " + str(t.temp)
                    f.write(str(t.temp))
                elif (t.temp != None and t.temp > 80):
                    # write out "OFF" to team's file if the team is above 80 degrees
                    print "SETTING TEAM NUMBER: " + str(t.filename[:2]) + " TO OFF"
                    f.write("OFF")
                    poweroff_team(substr(t.filename[:2]))
                else:
                    # write out "NULL" to team's file if unable to connect
                    print "SETTING TEAM NUMBER: " + str(t.filename[:2]) + " TO NULL"
                    f.write("NULL")
                f.close()
            t.join()
    print "Exiting Main Thread"

    
#    client = ModbusClient(args.slave_addr, port=502)
#    client.connect()
#
#    try:
#        while True:
#            # get value of holding registers (first has the temperature value)
#            rr = client.read_holding_registers(0x00,1,unit=1)
#            temp = rr.registers[0]
#            print temp
#            time.sleep(5)
#    except KeyboardInterrupt:
#        sys.exit()
#        print "Exiting..."

if __name__ == '__main__':
    threadLock = threading.Lock()
    main()

