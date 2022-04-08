#!/bin/sh

if [[ $EUID -ne 0 ]]; then
   echo "The cabal_TG.sh script must be run as root." 1>&2
   exit 1
fi

case "$1" in

  add)
    if [[ "$2" == *:* ]]; then
      echo "** Wrong format. No : please, e.g. 22 30 **"
      exit 1
    fi
    if [ "$2" == "hourly" ]; then
      if [ -f /etc/cron.hourly/cabalTGhourly ]; then
        echo "Hourly TG is already enabled."
      else
        if [ -f /etc/cron.d/cabalTGstart_* ]; then
          echo "One more more scheduled TG start times exist. You must disable those first."
        else
          echo "/home/cabal/daemons/TG_daemon.sh" >> /etc/cron.hourly/cabalTGhourly
          echo "Hourly TG enabled."
        fi
      fi
    else
      if [ -f /etc/cron.hourly/cabalTGhourly ]; then
        echo "Hourly TG is currently enabled. You must disable that first."
      else
        echo "$3 $2 * * * root /home/cabal/daemons/TG_daemon.sh" >> /etc/cron.d/cabalTGstart_$2_$3
        echo "Scheduled TG start time $2:$3 added."
      fi
    fi     
    ;;

  disable)
    if [[ "$2" == *:* ]]; then
      echo "** Wrong format. No : please, e.g. 22 30 **"
      exit 1
    fi  
    if [ "$2" == "" ]; then
      if [ -f /etc/cron.d/cabalTGstart_* ]; then
        echo -n "Disabling all scheduled TG... "
        rm -f /etc/cron.d/cabalTGstart_*
        echo "done."
      elif  [ -f /etc/cron.hourly/cabalTGhourly ]; then
        echo -n "Disabling Hourly TG... "
        rm -f /etc/cron.hourly/cabalTGhourly
        echo "done."
      else
        echo "There are no TG start times defined."
      fi
    else
      if [ -f /etc/cron.d/cabalTGstart_$2_$3 ]; then
        echo -n "Disabling scheduled TG $2:$3... "
        rm -f /etc/cron.d/cabalTGstart_$2_$3
        echo "done."
      else
        echo "$2:$3 is not a defined TG start time."
      fi
    fi
    ;;
    
  status)
    htg=false
    stg=false
    echo ""
    if [ -f /etc/cron.hourly/cabalTGhourly ]; then
      echo " Hourly TG is enabled."
      htg=true
    fi
    for file in /etc/cron.d/*; do
      name="${file%%_*}"
      t="${file#*_}"
      i="${t%%_*}"
      j="${t##*_}"
      if [ $name == "/etc/cron.d/cabalTGstart" ]; then
        echo " TG scheduled start time $i:$j"
        stg=true
      fi
    done
      
    if [[ $htg == true && $stg == true ]]; then
      echo "Both hourly and sheduled TG is enabled. This is bad. 'Call cabal_TG.sh disable' and re-do your TG starts."
    fi
    if [[ $htg == false && $stg == false ]]; then
      echo " There are no defined TG start times."
    fi
    echo ""
    ;;
            
  *)
        echo -e "\n Tierra Gloriosa controller v1.0 by mrmagoo (Chumpy)"
        echo "====================================================="
        echo "Controls Tierra Gloriosa (TG) start times. You can add multiple TG"
        echo "start times or hourly, but not both. Both 'hour' and 'minute'"
        echo "should be in 24 hour format."
        echo "Usage: cabal_TG <command> [<hour>] [<minute>]"
        echo "<Commands>"
        echo " status              : Display TG status."
        echo " disable             : Disables all TG."
        echo " disable hour minute : Disables specific scheduled TG start time."
        echo " add hourly          : Enables hourly TG."
        echo " add hour minute     : Adds a scheduled TG start time."
        echo -e "\nE.g. TG at 10:30am, 1:00pm and 9:45 pm..."
        echo "cabal_TG add 10 30"
        echo "cabal_TG add 13 00"
        echo -e "cabal_TG add 21 45\n"
        exit 1
esac
exit 0