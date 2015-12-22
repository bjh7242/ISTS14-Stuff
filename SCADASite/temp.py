#!/usr/bin/env python

import random
import time

numteams = 10

while True:
    for i in range(1,numteams+1):
        teamfile = "t" + str(i) + "-temp.txt"
        print teamfile
        f = open(teamfile,'w')
        temp = random.randint(68,72)
        print str(temp)
        f.write(str(temp))
        f.close()
    time.sleep(1)
