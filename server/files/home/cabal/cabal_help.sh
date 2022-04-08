#!/bin/sh

clear
echo -e "\n\e[32;1;44m################################################################################"
echo -e "########################## \e[31mThe Divinity Project v2.80\e[32m ##########################"
echo    "############## Cabal server command list v2.8 by mrmagoo (chumpy) ##############"
echo -e "################################################################################\e[0m"

    echo "Useful locations to explore :"
    echo " /etc/cabal                 : Config files"
    echo " /etc/cabal/docs            : Documentation and client info"
    echo " /etc/cabal/Data            : General server data"
    echo " /etc/cabal/Data/Data_World : Map specific scripts/drops/npcs"
    echo " /var/log/cabal             : Server log files"
    echo " /home/cabal                : Scripts and ImageAuth data"
    echo -e "System configuration locations:"
    echo " /etc/resolve.conf          : Contains the addresses of your DNS nameservers"
    echo " /etc/selinux/config        : Your SELinux config file"
    echo " /etc/sysconfig/network     : Your Centos hostname and gateway"
    echo " /etc/sysconfig/network-scripts/ifcfg-eth0 : IP address and netmask"
    echo -e "Useful commands:"
    echo "ifconfig : Display Centos IP addresses"
    echo "top      : Display memory and CPU usage info"
    echo "uptime   : Display uptime and load averages"
    echo -e "df -h    : Display disk space information\n"

    read -p "< Press any key >" -n 1
    
    clear    
    echo -e "\n\e[32;1;44m################################################################################"
    echo -e "########################## \e[31mThe Divinity Project v2.80\e[32m ##########################"
    echo    "############## Cabal server command list v2.8 by mrmagoo (chumpy) ##############"
    echo -e "################################################################################\e[0m"    
    echo "Server control commands:"
    echo " service cabal start   : Starts all services (not TG)"
    echo " service cabal restart : Restarts all services (not TG)"
    echo " service cabal reload  : Reloads some sections of the config"
    echo " service cabal stop    : Stops all services"
    echo " service cabal status  : Displays service statuses"   
    echo -e "\nYou can also use things like 'service LoginSvr_01 restart' and"
    echo -e "'service WorldSvr_05_10 start' to control services individually.\n"
    
    read -p "< Press any key >" -n 1
    
    clear    
    echo -e "\n\e[32;1;44m################################################################################"
    echo -e "########################## \e[31mThe Divinity Project v2.80\e[32m ##########################"
    echo    "############## Cabal server command list v2.8 by mrmagoo (chumpy) ##############"
    echo -e "################################################################################\e[0m"    
    echo "Other commands:"
    echo " cabal_install     : Reinstall Cabal (completely wipe server files)"
    echo " cabal_config      : Rebuild config (IPs, MSSQL access, channel layout etc)"
    echo " cabal_patchtool   : Packs and unpacks client enc files for editing patches"
    echo " cabal_help info   : Locations of useful files and useful OS commands"
    echo " cabal_rates       : Set server rates (static or floating)"
    echo " cabal_channeltypes: Changes channels to event modes"
    echo " cabal_TG          : Configure Tierra Gloriosa times"
    echo " cabal_autorestart : Auto restart crashed services"
    echo " cabal_dynip       : Dynamic IP auto configuration support"
    echo " cabal_portchange  : Quickly change all ports to new range (editing needed)"
    echo "Type any of these commands (from any directory) for further info."
    echo -e "* A reinstall/re config of the server files does not affect your databases *\n"   

exit 0