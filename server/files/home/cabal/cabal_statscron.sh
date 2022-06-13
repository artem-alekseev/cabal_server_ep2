#!/bin/sh

if [[ $EUID -ne 0 ]]; then
   echo "The cabal_statscron.sh script must be run as root." 1>&2
   exit 1
fi
logfile=/var/log/cabal/statscron.log
case "$1" in

  collect)
    wget http://192.168.0.15/cabal/cron.php?action=stats -O - -q   
    echo "`date`: Stats collection done." | tee -a $logfile      
    ;;

  enable)
    if [ -f /etc/cron.d/cabal_statscron ]; then
      echo "Stats collection is already enabled."
    else
      echo -n "Enabling stats collection... "
      echo "00 00 * * * root /home/cabal/cabal_statscron.sh collect" >> /etc/cron.d/cabal_statscron
      echo "done."
    fi          
    ;;

  disable)
    if [ -f /etc/cron.d/cabal_statscron ]; then
      echo -n "Disabling stats collection... "
      rm -f /etc/cron.d/cabal_statscron
      echo "done."
    else
      echo "Stats collection is not enabled."
    fi  
    ;;
    
  status)
    if [ -f /etc/cron.d/chk_cabal ]; then
      echo "Stats collection support is enabled."
    else
      echo "Stats collection is not enabled."
    fi   
    ;;
            
  *)
        echo -e "\n Cabal stats collector v1.0 by mrmagoo (Chumpy)"
        echo "================================================"
        echo "When enabled collects stats about the server."
        echo "Usage: cabal_statscron.sh <command>"
        echo "<Commands>"
        echo " status  : Show if stats collection is enabled or not."
        echo " enable  : Enables stats collection."
        echo -e " disable : Disables stats collection.\n"
        exit 1
esac
exit 0