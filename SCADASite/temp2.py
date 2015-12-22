#!/usr/bin/env python

import random

f = open('t2-temp.txt','w')
temp = random.randint(68,72)
print str(temp)
f.write(str(temp))
f.close()
