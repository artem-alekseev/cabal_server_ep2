#!/bin/sh
# Update odbc.ini as well as worldsvrs?
update_odbc=false

if [[ $EUID -ne 0 ]]; then
   echo "The wancheck_daemon.sh script must be run as root." 1>&2
   exit 1
fi
logfile=/var/log/cabal/wan_check.log

if [[ ! -f /etc/cron.d/cabalWANcheck && "$1" == "--reload" ]]; then
 echo "`date`: Timed WAN IP check called but WAN check is disabled. Nothing to do."
 exit 1
fi

echo "`date`: Checking WAN IP..." | tee -a $logfile
# 2 methods in case 1 fails
wip1=`wget www.whatismyip.com/automation/n09230945.asp -O - -q`
wip2=`wget -q -O - checkip.dyndns.org | sed -e 's/[^[:digit:]|.]//g'`
echo "`date`: www.whatismyip.com says $wip1" | tee -a $logfile
echo "`date`: www.dyndns.org says $wip2" | tee -a $logfile

if [[ $wip1 == $wip2 ]]; then
  wip=$wip1
elif [[ $wip1 == "" ]]; then
  wip=$wip2
elif [[ $wip2 == "" ]]; then
  wip=$wip1
fi

if [[ $wip == "" ]]; then
  echo "`date`: I cannot find the WAN IP. Panic and die." | tee -a $logfile
  exit 1
fi
echo "`date`: I choose $wip." | tee -a $logfile

current_ip=""
changed=false
for daemon in `cat /etc/cabal/server_list | grep -v ^#`; do
    name="${daemon%%_*}"
    t="${daemon#*_}"
    i="${t%%_*}"
    j="${t##*_}"
    if [ $name == "WorldSvr" ]; then
      current_ip=`cat /etc/cabal/$daemon.ini | grep IPAddress= | sed -e 's/IPAddress=//g'`
      echo "`date`: $daemon.ini config has $current_ip." | tee -a $logfile
      if [ $current_ip == $wip ]; then
        echo "`date`: $daemon.ini config is correct. No need to update." | tee -a $logfile
      else
        echo "`date`: $daemon.ini config out of date, updating..." | tee -a $logfile
        sed /etc/cabal/$daemon.ini \
        -e "s/IPAddress=[0-9.]*/IPAddress=$wip/g" \
        -e "s/AddrForClient=[0-9.]*/AddrForClient=$wip/g" \
        > /etc/cabal/$daemon.ini.tmp
        mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
        echo "`date`: $daemon.ini updated with new IP." | tee -a $logfile
        changed=true
      fi
    fi
done

if [ $changed == true ]; then

  if [ $update_odbc == true ]; then
    sed /etc/odbc.ini \
    -e "s/Address     = [0-9.]*/Address     = $wip/g" \
    > /etc/odbc.ini.tmp
    mv /etc/odbc.ini.tmp /etc/odbc.ini
    echo "`date`: odbc.ini updated with new IP." | tee -a $logfile
  fi

  if [ "$1" == "--reload" ]; then
    echo "`date`: WAN check was called via cron. Restarting server..." | tee -a $logfile
    service cabal restart
    echo "`date`: Restart complete." | tee -a $logfile
  fi
fi
exit 0