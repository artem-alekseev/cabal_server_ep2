#!/bin/sh

SERVER=127.0.0.1
PORT=4245
USER=chnLog
PASSWD=ace@log

backupdate=`date -d yesterday +%y%m%d`

echo "mkdir -p /trc/$backupdate/day" |  ncftp -P $PORT -u $USER -p $PASSWD $SERVER

host=`echo $HOSTNAME`
if [ \( $host = game08 \) -o \( $host = game40 \) ]; then
	lists=`cat /etc/cabal/server_list | grep -v ^# | grep -v Global`
else
	lists=`cat /etc/cabal/server_list | grep -v ^#`
fi

for daemon in $lists; do
	trcfile=/var/log/cabal/"$daemon"_"$backupdate".trc
    backfile=/trc/$backupdate/day/"$daemon"_"$backupdate".trc
	tmpfile=/tmp/backfileday
	awk -F'|' '{ print $1"|"$2"|"$3"|"$4"|"$5"|"$6"|"$7"|"$8"|"$9"|"$10 }' $trcfile | unix2dos > $tmpfile
	ncftpput -P $PORT -u $USER -p $PASSWD -C $SERVER $tmpfile $backfile
done
