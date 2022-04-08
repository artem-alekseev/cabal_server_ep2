#!/bin/sh

daemons=`cat /etc/cabal/server_list | grep -v ^#`
logfile=/var/log/cabal/TG_daemon.log

for daemon in $daemons; do
    t="${daemon#*_}"
    i="${t%%_*}"
    j="${t##*_}"
	if [ $j == "10" ]; then
	  echo "`date`: check $daemon" >> $logfile
	  ret=`ps aux | grep $daemon | grep ^cabal | grep -v grep`
	  if [ -z "$ret" ]; then
		echo "`date`: $daemon starting" | tee -a $logfile
		/sbin/service $daemon start
	  fi
	fi
done

