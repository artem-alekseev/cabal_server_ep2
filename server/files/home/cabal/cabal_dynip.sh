#!/bin/sh

if [[ $EUID -ne 0 ]]; then
   echo "The cabal_dynip.sh script must be run as root." 1>&2
   exit 1
fi
   
case "$1" in

  enable)
    if [ -f /etc/cron.d/cabalWANcheck ]; then
        echo "WAN check is already enabled."
    else
      chmod 0777 /home/cabal/daemons/wancheck_daemon.sh
      echo "*/15 * * * * root /home/cabal/daemons/wancheck_daemon.sh --reload" >> /etc/cron.d/cabalWANcheck
      echo "WAN check is now enabled."
    fi    
    ;;

  disable)
    if [ -f /etc/cron.d/cabalWANcheck ]; then
      rm -f /etc/cron.d/cabalWANcheck
      echo "WAN check is now disabled."
    else
      echo "WAN check is already disabled."
    fi  
    ;;
    
  status)
    if [ -f /etc/cron.d/cabalWANcheck ]; then
      echo "WAN check is currently enabled."
    else
      echo "WAN check is currently disabled."
    fi  
    ;;
            
  *)
        echo -e "\n WAN IP checker v1.1 by mrmagoo (Chumpy)"
        echo "==========================================="
        echo "When enabled the dynamic IP checker will check your WAN IP"
        echo "when the server starts or restarts. It will also check"
        echo "every 15 minutes (don't spam the sites more than this)."
        echo "If the WAN IP changes the server config will be updated."
        echo "Usage: cabal_dynip <command>"
        echo "<Commands>"
        echo " status  : Display dynamic IP checker status."
        echo " enable  : Enables dynamic IP checker."
        echo -e " disable : Enables dynamic IP checker.\n"
        exit 1
esac
exit 0