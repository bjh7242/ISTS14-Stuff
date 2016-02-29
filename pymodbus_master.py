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
# dict to hold value for number of checks in a row missed
missed_checks = { 't1': 0, 't2': 0, 't3': 0, 't4': 0, 't5': 0, 't6': 0, 't7': 0, 't8': 0, 't9': 0, 't10': 0, 't11': 0 }

class myThread(threading.Thread):
    def __init__(self, threadID, name, filename, addr, temp):
        threading.Thread.__init__(self)
        # lock this thread
        threadLock.acquire()
        self.threadID = threadID
        self.name = name
        self.filename = filename
        self.addr = addr
        self.temp = self.get_temp(self.name, self.addr)
        time.sleep(5)
        # release to next thread
        threadLock.release()

    def get_temp(self, threadName, addr):
        try:
            client = ModbusClient(addr, port=502)
            client.connect()
            rr = client.read_holding_registers(0x00,1,unit=1)
            temp = rr.registers[0]
            return temp
        except:
            #print "UNABLE TO CONNECT TO: " + addr
            # LOG A MISSED CHECK TO THE POWEROFF LOG HERE
            return None

def poweroff_team(team):
    # check poweroff log to see when last poweroff was, if within the last hour don't power off
    print "POWERING OFF TEAM " + str(team)
    missed_checks[team] = 0
    # write out to log file
    # call poweroff script

def check_missed_check(team):
    """ 
    Check to see when the poweroff log says the last missed check was
    """
    print "TEAM " + str(team) + " missed last checks " + str(missed_checks[team]) + " times!"
    if missed_checks[team] > 10:
        print "POWERING OFF TEAM " + str(team)
        poweroff_team(team)
    else:
        missed_checks[team] += 1

def main():
    # connect to modbus slave
    #team_sensors = { 't1-temp.txt': '10.0.0.200', 't2-temp.txt': '127.0.0.1', 't3-temp.txt': '192.168.1.152' }
    team_sensors = { 't1-temp.txt': '10.0.0.200', 't2-temp.txt': '127.0.0.1', 't11-temp.txt': '192.168.1.152' }
    threads = []

    while True:
        count = 0
        for filename in team_sensors:
            # Create new threads
            # sensor_addrs[filename] == address to connect to
            new_thread = myThread(1, "Thread-" + str(count), filename, team_sensors[filename], 0)
            print "new_thread.filename[:new_thread.filename.index('-')] = " + str(new_thread.filename[:new_thread.filename.index('-')])

            # Start new Threads
            new_thread.start()
            
            # Add threads to thread list
            threads.append(new_thread)
            new_thread.join()

            count += 1
            
        # Wait for all threads to complete
        # log temperature to a file here?
        for t in threads:
            #print "TEMP IS: " + str(t.temp) + " for " + str(t.addr)
            with open(temperature_dir + t.filename,'w') as f:
                if (t.temp != None and t.temp <= 80):
                    print "SETTING TEAM NUMBER: " + str(t.filename[:t.filename.index('-')]) + " TO " + str(t.temp)
                    f.write(str(t.temp))
                    # reset the missed checks counter
                    #missed_checks[t.filename[:t.filename.index('-')] = 0
                elif (t.temp != None and t.temp > 80):
                    # write out "OFF" to team's file if the team is above 80 degrees
                    print "SETTING TEAM NUMBER: " + str(t.filename[:t.filename.index('-')]) + " TO OFF"
                    f.write("OFF")
                    poweroff_team(t.filename[:t.filename.index('-')])
                else:
                    # write out "NULL" to team's file if unable to connect
                    print "SETTING TEAM NUMBER: " + str(t.filename[:t.filename.index('-')]) + " TO NULL"
                    f.write("NULL")
                    check_missed_check(t.filename[:t.filename.index('-')])
                f.close()
            #t.join()

if __name__ == '__main__':
    threadLock = threading.Lock()
    main()

