#!/bin/sh

SERVER=127.0.0.1
PORT=4245
USER=chnLog
PASSWD=ace@log

ago="10 minutes ago"

upday=`date -d "$ago" +%y%m%d`
uphour=`date -d "$ago" +%y%m%d%H`

echo "mkdir /trc/$upday" |  ncftp -P $PORT -u $USER -p $PASSWD $SERVER

host=`echo $HOSTNAME`
if [ \( $host = game08 \) -o \( $host = game40 \) ]; then
	lists=`cat /etc/cabal/server_list | grep -v ^# | grep -v Global`
else
	lists=`cat /etc/cabal/server_list | grep -v ^#`
fi

t1=`date -d "$ago" +%s`
from=`expr $t1 \/ 3600 \* 3600`
to=`expr \( $t1 + 3600 \) \/ 3600 \* 3600`

for daemon in $lists; do
	trcfile=/var/log/cabal/"$daemon"_"$upday".trc
	backfile=/trc/$upday/"$daemon"_"$uphour".trc
	tmpfile=/tmp/backfile

	awk -F'|' '{ if ('"$from"' <= $1 && $1 < '"$to"') print $1"|"$2"|"$3"|"$4"|"$5"|"$6"|"$7"|"$8"|"$9"|"$10 }' $trcfile | unix2dos > $tmpfile

	ncftpput -P $PORT -u $USER -p $PASSWD -C $SERVER $tmpfile $backfile
done
