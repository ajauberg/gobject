# Introduction #

The following Linux utilities are used to create the HTTP GET sent to the gObject Management System:

  1. Linux shell is used for running a script
  1. `cron` is calling the script at a fixed interval
  1. `ifconfig`, `iwconfig` and `iwlist` is used to retrieve the information
  1. `grep`, `cut`, `sed`, `cat` and `wc` is used to format the information into a HTTP format string
  1. `wget` is used to transfer the string back to the server

# cron #

The line below is added to the cron utility using the command 'crontabs -e'. The following actions are performed when running the line:

  1. The file `ow.sh` is retrieved from a remote server every 5 minutes
  1. The file is copied to `/tmp/ow.sh`, and made executable
  1. The file is then executed locally in the unit, and finally deleted

```
*/5 * * * * wget -O /tmp/ow.sh http://<server>/ow.sh && chmod +x /tmp/ow.sh && /tmp/ow.sh; rm -rf /tmp/ow.sh
```

# ow.sh #

The following script is run locally, and draws its information from the following Linux utilities:

  1. `ifconfig` - Packets, Collisions and Bytes
  1. `iwconfig` - Access Point MAC-address, ESSID, Rate
  1. `iwlist` - Peer MAC-address, Quality, Signal and Noise

`grep`, `cut`, `sed`, `cat` and `wc` is used to format the information into a HTTP format string

Finally the `wget` utility is used to transfer the constructed string back to the server using a HTTP GET. See the [PHPFiles](PHPFiles.md) page for a description of the `update.php` file that receives the information.

```
#!/bin/sh

WIFI=ath0
BR=br0
TMP=/tmp/tmp.tmp

# Update the MAC, IP address and peers of the AP
WGET=http://<server>/update.php

IP=`ifconfig $BR | grep inet | cut -d B -f1 | sed s/[^0-9.]//g`
AP=`iwconfig $WIFI | grep Access | cut -d" " -f18`
ESSID=`iwconfig $WIFI | grep ESSID | cut -d\" -f2`
RATE=`iwconfig $WIFI | grep Rate | cut -d"M" -f1 | cut -b20-25 | cut -d" " -f1`
UPTIME=`cat /proc/uptime | cut -d"." -f1`
CLI=`cat /proc/net/arp | grep $BR | wc -l | sed s/[^0-9]//g`

WGET="$WGET?IP=$IP&AP=$AP&ESSID=$ESSID&UPTIME=$UPTIME&CLI=$CLI&RATE=$RATE"
#echo $WGET

RXP=`ifconfig $BR | grep "RX packets" | cut -d":" -f2 | cut -d" " -f1 | sed s/[^0-9.]//g` # RX packets
RXe=`ifconfig $BR | grep "RX packets" | cut -d":" -f3 | cut -d" " -f1 | sed s/[^0-9.]//g` # RX errors
RXd=`ifconfig $BR | grep "RX packets" | cut -d":" -f4 | cut -d" " -f1 | sed s/[^0-9.]//g` # RX dropped
RXo=`ifconfig $BR | grep "RX packets" | cut -d":" -f5 | cut -d" " -f1 | sed s/[^0-9.]//g` # RX overruns
RXf=`ifconfig $BR | grep "RX packets" | cut -d":" -f6 | cut -d" " -f1 | sed s/[^0-9.]//g` # RX frame
RXb=`ifconfig $BR | grep "RX bytes" | cut -d":" -f2 | cut -d" " -f1 | sed s/[^0-9.]//g` # RX bytes

WGET="$WGET&RXP=$RXP&RXe=$RXe&RXd=$RXd&RXo=$RXo&RXf=$RXf&RXb=$RXb"
#echo $WGET

TXP=`ifconfig $BR | grep "TX packets" | cut -d":" -f2 | cut -d" " -f1 | sed s/[^0-9.]//g` # TX packets
TXe=`ifconfig $BR | grep "TX packets" | cut -d":" -f3 | cut -d" " -f1 | sed s/[^0-9.]//g` # TX errors
TXd=`ifconfig $BR | grep "TX packets" | cut -d":" -f4 | cut -d" " -f1 | sed s/[^0-9.]//g` # TX dropped
TXo=`ifconfig $BR | grep "TX packets" | cut -d":" -f5 | cut -d" " -f1 | sed s/[^0-9.]//g` # TX overruns
TXc=`ifconfig $BR | grep "TX packets" | cut -d":" -f6 | cut -d" " -f1 | sed s/[^0-9.]//g` # TX frame
TXco=`ifconfig $BR | grep "coll" | cut -d":" -f2 | cut -d" " -f1 | sed s/[^0-9.]//g` # TX collisions
TXq=`ifconfig $BR | grep "coll" | cut -d":" -f3 | sed s/[^0-9.]//g` # TX txqueuelen
TXb=`ifconfig $BR | grep "TX bytes" | cut -d":" -f3 | cut -d" " -f1 | sed s/[^0-9.]//g` # TX bytes

WGET="$WGET&TXP=$TXP&TXe=$TXe&TXd=$TXd&TXo=$TXo&TXc=$TXc&TXco=$TXco&TXq=$TXq&TXb=$TXb"
#echo $WGET

# ath0      Peers/Access-Points in range:
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
```