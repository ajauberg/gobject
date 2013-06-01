#!/bin/sh

WIFI=ath0
BR=br0
TMP=/tmp/tmp.tmp

# Update the MAC, IP address and peers of the AP
WGET=http://www.aiwisp.net/owRemote/update.php

IP=`ifconfig $BR | grep inet | cut -d B -f1 | sed s/[^0-9.]//g`
AP=`iwconfig $WIFI | grep Access | cut -d" " -f18`
ESSID=`iwconfig $WIFI | grep ESSID | cut -d\" -f2`
RATE=`iwconfig $WIFI | grep Rate | cut -d"M" -f1 | cut -b20-25 | cut -d" " -f1`
UPTIME=`cat /proc/uptime | cut -d"." -f1`
CLI=`cat /proc/net/arp | grep $BR | wc -l | sed s/[^0-9]//g`

WGET="$WGET?IP=$IP&AP=$AP&ESSID=$ESSID&UPTIME=$UPTIME&CLI=$CLI&RATE=$RATE"
#echo $WGET

# ath0      Peers/Access-Points in range:
#    00:15:6D:A6:1B:AD : Quality=44/94  Signal level=-52 dBm  Noise level=-96 dBm
#    00:1A:70:6E:D3:77 : Quality=0/94   Signal level=-96 dBm  Noise level=-96 dBm
#    00:16:B6:49:47:6D : Quality=22/94  Signal level=-74 dBm  Noise level=-96 dBm
#    00:1A:70:6E:D3:CE : Quality=6/94   Signal level=-90 dBm  Noise level=-96 dBm
#    00:16:B6:49:47:70 : Quality=0/94   Signal level=-96 dBm  Noise level=-96 dBm
#    00:04:23:9A:32:03 : Quality=17/94  Signal level=-79 dBm  Noise level=-96 dBm

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
