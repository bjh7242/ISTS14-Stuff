#!/usr/bin/env python

import string
import sys

TEAMNUM=sys.argv[1]

def print_beginning():
    print """"## Last changed: 2016-02-22 09:01:24 UTC
version 15.1X49-D15.4;
system {
    root-authentication {
        encrypted-password "$1$vNKQ4UPn$gyDIaC0/sclRpftu8NhYg/"; ## SECRET-DATA
    }
    services {
        finger;
        ftp;
        ssh;
        telnet;
        web-management {
            http {
                interface [ ge-0/0/1.0 ge-0/0/0.0 ];
            }
        }
    }
    syslog {
        user * {
            any emergency;
        }
        file messages {
            any any;
            authorization info;
        }
        file interactive-commands {
            interactive-commands any;
        }
    }
    license {
        autoupdate {
            url https://ae1.juniper.net/junos/key_retrieval;
        }
    }
}
security {
    screen {
        ids-option untrust-screen {
            icmp {
                ping-death;
            }
            ip {
                source-route-option;
                tear-drop;
            }
            tcp {
                syn-flood {
                    alarm-threshold 1024;
                    attack-threshold 200;
                    source-threshold 1024;
                    destination-threshold 2048;
                    timeout 20;
                }
                land;
            }
        }
    }
    nat {
        static {
            rule-set STATIC_NAT {
                from zone untrust;"""

def make_nat_rules():
    for i in range(1,255):
        print """                rule {0} {{
                    match {{
                        destination-address 10.3.{1}.{2}/32;
                    }}
                    then {{
                        static-nat {{
                            prefix {{
                                172.25.1.{3}/32;
                            }}
                        }}
                    }}
                }}""".format(i, TEAMNUM, i, i)
    print "            }"

def set_proxy_arp():
    print """        }
        proxy-arp {
            interface ge-0/0/0.0 {
                address {"""

    for i in range(1,255):
        print """                    10.3.{0}.{1}""".format(TEAMNUM, i)

def print_security_end():
    print """                }
            }
        }
    }
    policies {
        from-zone trust to-zone trust {
            policy default-permit {
                match {
                    source-address any;
                    destination-address any;
                    application any;
                }
                then {
                    permit;
                }
            }
        }
        from-zone trust to-zone untrust {
            policy default-permit {
                match {
                    source-address any;
                    destination-address any;
                    application any;
                }
                then {
                    permit;
                }
            }
        }
        from-zone untrust to-zone trust {
            policy default-permit {
                match {
                    source-address any;
                    destination-address any;
                    application any;
                }
                then {
                    permit;
                }
            }
        }
    }
    zones {
        security-zone trust {
            tcp-rst;
            interfaces {
                ge-0/0/1.0 {
                    host-inbound-traffic {
                        system-services {
                            all;
                        }
                    }
                }
            }
        }
        security-zone untrust {
            screen untrust-screen;
            interfaces {
                ge-0/0/0.0 {
                    host-inbound-traffic {
                        system-services {
                            ping;
                        }
                    }
                }
            }
        }
    }
}"""

def print_interfaces_and_routing():
    print """interfaces {
    ge-0/0/0 {
        unit 0 {
            family inet {"""
    print "                address 10.3.{0}.1/24;".format(TEAMNUM)
    print """            }
        }
    }
    ge-0/0/1 {
        unit 0 {
            family inet {
                address 172.25.1.254/24;
            }
        }
    }
    fxp0 {
        unit 0;
    }
}
routing-options {
    static {"""
    print "        route 0.0.0.0/0 next-hop 10.3.{0}.254;".format(TEAMNUM)
    print """    }
}"""

print_beginning()
make_nat_rules()
set_proxy_arp()
print_security_end()
print_interfaces_and_routing()
