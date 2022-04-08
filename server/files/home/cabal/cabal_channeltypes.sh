#!/bin/sh

if [[ $EUID -ne 0 ]]; then
   echo "The cabal_channeltypes.sh script must be run as root." 1>&2
   exit 1
fi

case "$1" in

  change)
        chantypes[1]="Common.ini"
        chantypes[2]="Common-hardcore.ini"
        chantypes[3]="Common-hardcore4x.ini"
        chantypes[4]="Common-halloween.ini"
        cabal_channeltypes
        for daemon in `cat /etc/cabal/server_list | grep -v ^#`; do
          name="${daemon%%_*}"
          t="${daemon#*_}"
          i="${t%%_*}"
          j="${t##*_}" 
          types="1 2 3 4"
          if [[ $name == "WorldSvr" && $j != "10" ]]; then
            echo -ne "Enter channel type for server $i channel $j [1] : "
            read chtype
            if [ -z $chtype ]; then
              chtype="1"
            fi
            
            if [[ $types =~ $chtype ]];  then
               sed /etc/cabal/$daemon.ini \
               -e "s/CommonIniPath=Common.ini/CommonIniPath=${chantypes[$chtype]}/g" \
               > /etc/cabal/$daemon.ini.tmp
               mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
            else
              echo "Invalid type."
              exit 1
            fi

          fi
        done
        echo -e "\nAll done. You need to restart the WorldSvrs now."
    ;;
            
  *)
        echo -e "\n Map type changer v1.0 by mrmagoo (Chumpy)"
        echo "=========================================="
        echo "Changes WorldSvr map types to one of the following:"
        echo " 1 - Normal"
        echo " 2 - Hardcore (tougher mobs)"
        echo " 3 - Hardcore4x (tougher mobs + more mobs)"
        echo " 4 - Halloween (normal + Halloween mobs"
        echo "Each channel number will be listed and you will be asked for a type."
        echo -e "Usage: cabal_chaneltypes change\n"
        exit 1
esac
exit 0