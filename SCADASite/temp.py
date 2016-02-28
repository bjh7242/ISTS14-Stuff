#!/usr/bin/env python

import random
import time
import sys

numteams = 11

try:
    while True:
        for i in range(1,numteams+1):
            teamfile = "t" + str(i) + "-temp.txt"
            print teamfile
            f = open(teamfile,'w')
            temp = random.randint(68,72)
            print str(temp)
            f.write(str(temp))
            f.close()
        time.sleep(2)
except KeyboardInterrupt:
    sys.exit(0)
