#!/usr/bin/env python

from pymodbus.client.sync import ModbusTcpClient as ModbusClient
import logging
import argparse
import time
import sys
import random
import time

# NUM_MISSED_CHECKS is a constant that defines the number of missed checks before VMs are powered off
NUM_MISSED_CHECKS = 2
temperature_dir = 'C:\\xampp\\htdocs\\'

class sensor():
    def __init__(self, team, addr, temp):
        self.team = team
        self.filename = str(team) + "-temp.txt"
        self.addr = addr
        self.temp = self.get_temp(self.addr)
        self.sleeping = False
        self.timeout = 0

    def get_temp(self, addr):
        # connect to modbus slave
        try:
            client = ModbusClient(addr, port=502)
            client.connect()
            rr = client.read_holding_registers(0x00,1,unit=1)
            temp = rr.registers[0]
            return temp
        except:
            # if unable to connect, return None
            log_stuff("Unable to connect to " + self.addr)
            return None

def log_stuff(message):
    print "About to log stuff."
    with open('scada.log','a+') as f:
        now = time.strftime("%c")
        f.write(now + " - " + message + "\n")


def poweroff_team(teamsensor):
    #log_stuff("Team " + teamsensor.team + " set to " + str(missed_checks[teamsensor.team]) + " checks.")
    log_stuff("POWERING OFF TEAM " + str(teamsensor.team))
    missed_checks[teamsensor.team] = 0
    # call poweroff script here
    time.sleep(3600)

def check_missed_check(teamsensor):
    """
    Check to see when the poweroff log says the last missed check was
    """
    if missed_checks[teamsensor.team] > NUM_MISSED_CHECKS:
        #print "POWERING OFF TEAM " + str(teamsensor.team)
        with open(temperature_dir + teamsensor.filename,'w') as f:
            f.write('OFF')
        poweroff_team(teamsensor)
    else:
        missed_checks[teamsensor.team] += 1
        log_stuff("Team " + str(teamsensor.team) + " missed " + str(missed_checks[teamsensor.team]) + " checks in a row!")

def main():
    while True:
        sensor_obj = sensor(args.team, args.address, 0)
        # log temperature value reading to a file
        with open(temperature_dir + sensor_obj.filename,'w') as f:
            if (sensor_obj.temp != None and sensor_obj.temp <= 85):
                log_stuff("Setting team number " + str(sensor_obj.team) + " temperature to " + str(sensor_obj.temp) + " in " + str(sensor_obj.filename))
                f.write(str(sensor_obj.temp))
                # reset the missed checks counter
                missed_checks[sensor_obj.team] = 0
            elif (sensor_obj.temp != None and sensor_obj.temp > 85):
                # write out "OFF" to team's file if the team is above 85 degrees
                log_stuff("Team " + str(sensor_obj.team) + " is about to be powered off. Temp reads: " + str(sensor_obj.temp))
                #print "SETTING TEAM NUMBER: " + str(sensor_obj.team) + " TO OFF in " + str(sensor_obj.filename)
                f.write("OFF")
                poweroff_team(sensor_obj)
            else:
                # write out "NULL" to team's file if unable to connect
                #print "SETTING TEAM NUMBER: " + str(sensor_obj.team) + " TO NULL in " + str(sensor_obj.filename)
                f.write("NULL")
                check_missed_check(sensor_obj)
            f.close
        time.sleep(10)

if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Poll the temerature sensor of a given team.')
    parser.add_argument('-t', help='The URL to start scraping from', dest="team",  required="True")
    parser.add_argument('-a', help='Address of the temperature sensor to poll', dest="address", required="True")

    args = parser.parse_args()

    # dict to hold value for number of checks in a row missed
    missed_checks = { args.team : 0 }

    main()
