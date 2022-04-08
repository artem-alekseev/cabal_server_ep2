#!/bin/sh

daemons=`cat /etc/cabal/server_list | grep -v ^#`
logfile=/var/log/cabal/check_daemon.log

for daemon in $daemons; do
    t="${daemon#*_}"
    i="${t%%_*}"
    j="${t##*_}"
	ret=`ps aux | grep $daemon | grep ^cabal | grep -v grep`
	if [ -z "$ret" ]; then
	  if [ $j != "10" ]; then
		echo "`date`: $daemon starting" | tee -a $logfile
		/sbin/service $daemon start
	  fi
	fi
done

