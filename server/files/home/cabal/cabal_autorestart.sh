#!/bin/sh

if [[ $EUID -ne 0 ]]; then
   echo "The cabal_autorestart.sh script must be run as root." 1>&2
   exit 1
fi

case "$1" in

  enable)
    if [ -f /etc/cron.d/chk_cabal ]; then
      echo "Auto restart is already enabled."
    else
      echo -n "Enabling auto restart... "
      echo "*/1 * * * * root /home/cabal/daemons/check_daemon.sh" >> /etc/cron.d/chk_cabal
      echo "done."
    fi          
    ;;

  disable)
    if [ -f /etc/cron.d/chk_cabal ]; then
      echo -n "Disabling auto restart... "
      rm -f /etc/cron.d/chk_cabal
      echo "done."
    else
      echo "Auto restart is not enabled."
    fi  
    ;;
    
  status)
    if [ -f /etc/cron.d/chk_cabal ]; then
      echo "Auto restart support is enabled."
    else
      echo "Auto restart is not enabled."
    fi   
    ;;
            
  *)
        echo -e "\n Cabal process auto-restart v1.0 by mrmagoo (Chumpy)"
        echo "====================================================="
        echo "When enabled watches your server processes and automatically"
        echo "restarts them if they have crashed or stopped."
        echo "Usage: cabal_autorestart <command>"
        echo "<Commands>"
        echo " status  : Show if process auto restart is enabled or not."
        echo " enable  : Enables process auto restart."
        echo -e " disable : Disables process auto restart.\n"
        exit 1
esac
exit 0