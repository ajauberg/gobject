#!/bin/sh

WIFI=eth1
BR=br0

# Update the MAC and IP address of the AP
WGET=http://gobject.googlecode.com/svn/trunk/owRemote/update.php

IP=`ifconfig $BR | grep inet | cut -d B -f1 | sed s/[^0-9.]//g`
MAC=`ifconfig $WIFI | grep HWaddr | cut -c39- | cut -d" " -f1`
ESSID=`iwconfig $WIFI | grep ESSID | cut -d\" -f2`
RATE=`wl rate | cut -d" " -f3`
UPTIME=`cat /proc/uptime | cut -d"." -f1`
CLI=`cat /proc/net/arp | grep $BR | wc -l`

WGET="$WGET?IP=$IP&MAC=$MAC&ESSID=$ESSID&UPTIME=$UPTIME&CLI=$CLI&RATE=$RATE"
#echo $WGET
wget -O /dev/null "$WGET"

# Update link status of known peers
WGET=http://www.aiwisp.net/owRemote/peers.php

AP=`iwconfig $WIFI | grep Access | cut -d" " -f18`

iwlist $WIFI scanning | grep 'Quality' | while read line;
do
  MAC=`nvram show | grep wl0_wds | cut -d"=" -f2`
  QUAL=`echo $line | cut -d":" -f2 | cut -d"/" -f1`
  SIG=`echo $line | cut -d":" -f3 | cut -d" " -f1`
  NOISE=`echo $line | cut -d":" -f4 | cut -d" " -f1`

  WGET2="$WGET?AP=$AP&MAC=$MAC&QUAL=$QUAL&SIG=$SIG&NOISE=$NOISE"
#  echo $WGET2
  wget -O /dev/null "$WGET2"
done

