#!/bin/sh

WIFI=ath0
BR=br0
TMP=/tmp/tmp.tmp

# Update the MAC, IP address and peers of the AP
WGET=http://gobject.googlecode.com/svn/trunk/owRemote/update.php

IP=`ifconfig $BR | grep inet | cut -d B -f1 | sed s/[^0-9.]//g`
AP=`iwconfig $WIFI | grep Access | cut -d" " -f18`
ESSID=`iwconfig $WIFI | grep ESSID | cut -d\" -f2`
RATE=`iwconfig $WIFI | grep Rate | cut -d"M" -f1 | cut -b20-25`
UPTIME=`cat /proc/uptime | cut -d"." -f1`
CLI=`cat /proc/net/arp | grep $BR | wc -l`

WGET="$WGET?IP=$IP&AP=$AP&ESSID=$ESSID&UPTIME=$UPTIME&CLI=$CLI&RATE=$RATE"
#echo $WGET

rm -f $TMP
iwlist $WIFI peers | grep 'Quality' > $TMP
while read line
do
  MAC=`echo $line | cut -d" " -f1`
  QUAL=`echo $line | cut -d"=" -f2 | cut -d"/" -f1`
  SIG=`echo $line | cut -d"=" -f3 | cut -d" " -f1`
  NOISE=`echo $line | cut -d"=" -f4 | cut -d" " -f1`

  WGET="$WGET&MAC[]=$MAC&QUAL[]=$QUAL&SIG[]=$SIG&NOISE[]=$NOISE"
#  echo $WGET
done < $TMP

#echo $WGET
wget -O /dev/null "$WGET"
