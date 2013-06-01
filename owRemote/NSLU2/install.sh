#!/bin/sh
#
# Install NSLU2 with USB support
#
# wget -O /etc/install.sh http://www.aiwisp.net/owRemote/NSLU2/install.sh

# Point to www.aiwisp.net
wget -O /etc/ipkg.conf http://www.aiwisp.net/owRemote/NSLU2/etc/ipkg.conf
ipkg update

# Install X-WRT web interface
ipkg install http://www.aiwisp.net/xwrt/kamikaze/snapshots/ixp4xx-2.6/webif_latest.ipk

# Point to www.aiwisp.net
wget -O /etc/ipkg.conf http://www.aiwisp.net/owRemote/NSLU2/etc/ipkg.conf
ipkg update

# Install USB storage kernel modules and file utilities
#ipkg install kmod-usb2 kmod-usb-storage kmod-fs-ext3
ipkg install e2fsprogs cfdisk fdisk swap-utils
ipkg install ntpclient

# External USB
wget -O /etc/init.d/usbdrive http://www.aiwisp.net/owRemote/NSLU2/etc/init.d/usbdrive
chmod +x /etc/init.d/usbdrive
/etc/init.d/usbdrive enable

mkswap /dev/sdb2
mke2fs -j /dev/sdb2
swapon /dev/sdb2
mke2fs -j /dev/sda1

mkdir -p /mnt
mount /dev/sda1 /mnt/

# Modify profile for external USB stick
wget -O /etc/profile http://www.aiwisp.net/owRemote/NSLU2/etc/profile

# Asterisk
ipkg install asterisk14
ipkg install asterisk14-mysql
wget -O /etc/asterisk/extconfig.conf http://www.aiwisp.net/owRemote/NSLU2/etc/asterisk/extconfig.conf
wget -O /etc/asterisk/res_mysql.conf http://www.aiwisp.net/owRemote/NSLU2/etc/asterisk/res_mysql.conf
wget -O /etc/asterisk/modules.conf http://www.aiwisp.net/owRemote/NSLU2/etc/asterisk/modules.conf

#TRUST SPYC@M 300S
#Manufafactured by Trust International BV
#USB\VID_2770&PID_9120\5&3063F765&0&2
#ipkg install kmod-usb2 kmod-videodev kmod-usb-pwc
#ipkg install kmod-usb-qc kmod-usb-video kmod-video-core kmod-video-cpia2 kmod-video-gspca
#ipkg install kmod-video-konica kmod-video-nw8xx kmod-video-ovcamchip kmod-video-pwc kmod-video-uvc

#ipkg install kmod-videodev
#ipkg install gphoto2 libgphoto2-drivers


