#!/bin/sh

# Set your MSSQL access details here
# and you won't be asked for them
pubip="192.168.208.1"
dbip=mssql
dbac="sa"
dbpass="__Alex772"
dbport=1422

echo -n "Removing old configuration... "
rm -f /etc/init.d/GlobalDBAgent
rm -f /etc/init.d/CashDBAgent
rm -f /etc/init.d/DBAgent_*
rm -f /etc/init.d/ChatNode_*
rm -f /etc/init.d/WorldSvr_*
rm -f /etc/init.d/LoginSvr_*
rm -f /etc/cabal/*.ini
rm -f /etc/cabal/*.cfg
rm -f /etc/cabal/server_list
rm -f /etc/odbc.ini
rm -f /usr/bin/GlobalDBAgent
rm -f /usr/bin/CashDBAgent
rm -f /usr/bin/DBAgent_*
rm -f /usr/bin/ChatNode_*
rm -f /usr/bin/WorldSvr_*
rm -f /usr/bin/LoginSvr_*
echo "done."

echo "Deleting old logfiles..."
rm -f /var/log/cabal/*

echo -e "\nConfigurations available :"
echo " 1 - Mercury (1 chan. Normal)"
echo " 2 - Venus  (1 chan. PK)"
echo " 3 - Mars (1 chan. War)"
echo " 4 - Jupiter (1 chan. Tierra Gloriosa)"
echo " 5 - Saturn (2 chan. Normal/TG)"
echo " 6 - Neptune (3 chan. Normal/War/Tierra Gloriosa)"
echo " 7 - Pluto (3 chan. PK/War/Tierra Gloriosa)"
echo " 8 - Leo (4 chan. Normal/PK/Prem War/Tierra Gloriosa)"
echo " 9 - Sirius (4 chan. Normal/PK/War/Tierra Gloriosa)"
echo "10 - Draco (5 chan. Normal/Prem/Prem PK/Prem War/TG)"
echo "11 - Test Server (1 chan. PK)"
echo "12 - Duality (2 server, 1 norm and 1 War channel)"
echo "20 - Divinity (3 server, 1 norm and 1 PK channel each)"
echo -ne "\nEnter a configuration [11] : "
read configtype
if [ -z $configtype ]; then
configtype="1"
fi

tg_chan=0
if [ $configtype == "1" ]; then
  cfgfile=Mercury
  channels=1
elif [ $configtype == "2" ]; then
  cfgfile=Venus
  channels=1
elif [ $configtype == "3" ]; then
  cfgfile=Mars
  channels=1
elif [ $configtype == "4" ]; then
  cfgfile=Jupiter
  channels=1
  tg_chan=1
elif [ $configtype == "5" ]; then
  cfgfile=Saturn
  channels=2
  tg_chan=1
elif [ $configtype == "6" ]; then
  cfgfile=Neptune
  channels=3
  tg_chan=1
elif [ $configtype == "7" ]; then
  cfgfile=Pluto
  channels=3
  tg_chan=1
elif [ $configtype == "8" ]; then
  cfgfile=Leo
  channels=4
  tg_chan=1
elif [ $configtype == "9" ]; then
  cfgfile=Sirius
  channels=4
  tg_chan=1
elif [ $configtype == "10" ]; then
  cfgfile=Draco
  channels=5
  tg_chan=1
elif [ $configtype == "12" ]; then
  cfgfile=Duality
  channels=2
elif [ $configtype == "20" ]; then
  cfgfile=Divinity
  channels=6
else
  cfgfile=Test24
  channels=1
fi

if [ $tg_chan -eq 1 ]; then
  echo -ne "Tierra Gloriosa lobby wait time (min) [30] : "
  read tg_wait
  if [ -z $tg_wait ]; then
    tg_wait=30
  fi

  echo -ne "Tierra Gloriosa duration (min) [60] : "
  read tg_duration
  if [ -z $tg_duration ]; then
    tg_duration=60
  fi
else
  tg_wait=30
  tg_duration=60
fi

echo -e "\nInitialising $cfgfile configuration..."
cp -f /etc/cabal/templates/$cfgfile /etc/cabal/server_list

count1=1
count2=1
count3=1
serverport=23
server=24
maxplayers=10
loglvl=3
let playertotal=$maxplayers*$channels
let tgw=$tg_wait*60
let tgd=$tg_duration*60

for daemon in `cat /etc/cabal/server_list | grep -v ^#`; do
    name="${daemon%%_*}"
    echo -n "$daemon:"

    t="${daemon#*_}"
    i="${t%%_*}"
    j="${t##*_}"
    
    if [ $name == "GlobalMgrSvr" ]; then
        echo -n " ini..."
        sed /etc/cabal/templates/$name.cfg \
        -e "s/MaxUserNum=600/MaxUserNum=$playertotal/g" \
        -e "s/LogLevel=3/LogLevel=$loglvl/g" \
        -e "s/WorldMaxUserNum=300/WorldMaxUserNum=$maxplayers/g" \
        -e "s/=100/=$maxplayers/g" \
        > /etc/cabal/$daemon.ini
        
    elif [ $name == "LoginSvr" ]; then
        echo  -n " link..."
        ln -sf /usr/bin/$name /usr/bin/$daemon
        echo -n " ini..."
        sed /etc/cabal/templates/$name.cfg \
        -e "s/MaxUserNum=20000/MaxUserNum=$playertotal/g" \
        -e "s/LogLevel=3/LogLevel=$loglvl/g" \
        -e "s/GroupIdx=1/GroupIdx=`expr $i / 1`/g" \
        > /etc/cabal/$daemon.ini

    elif [ $name == "GlobalDBAgent" ]; then
        echo  -n " link..."
        ln -sf /usr/bin/DBAgent /usr/bin/$daemon
        echo -n " ini..."
        sed /etc/cabal/templates/$name.cfg \
        -e "s/MaxUserNum=32/MaxUserNum=$playertotal/g" \
        -e "s/LogLevel=3/LogLevel=$loglvl/g" \
        -e "s/DBId=cabaluser/DBId=$dbac/g" \
        -e "s/DBPwd=cabalpassword/DBPwd=$dbpass/g" \
        > /etc/cabal/$name.ini.tmp
        mv /etc/cabal/$name.ini.tmp /etc/cabal/$name.ini

    elif [ $name == "CashDBAgent" ]; then
        echo  -n " link..."
        ln -sf /usr/bin/DBAgent /usr/bin/$daemon
        echo -n " ini..."
        sed /etc/cabal/templates/$name.cfg \
        -e "s/MaxUserNum=2048/MaxUserNum=$playertotal/g" \
        -e "s/LogLevel=3/LogLevel=$loglvl/g" \
        -e "s/DBId=cabaluser/DBId=$dbac/g" \
        -e "s/DBPwd=cabalpassword/DBPwd=$dbpass/g" \
        > /etc/cabal/$name.ini.tmp
        mv /etc/cabal/$name.ini.tmp /etc/cabal/$name.ini

    elif [ $name == "DBAgent" ]; then
        echo  -n " link..."
        ln -sf /usr/bin/$name /usr/bin/$daemon
        echo -n " ini..."
        sed /etc/cabal/templates/$name.cfg \
        -e "s/MaxUserNum=2048/MaxUserNum=$playertotal/g" \
        -e "s/LogLevel=3/LogLevel=$loglvl/g" \
        -e "s/ServerIdx=1/ServerIdx=`expr $i / 1`/g" \
        -e "s/Port=38181/Port=381`expr 80 + $i`/g" \
        -e "s/DSN=CabalGame24/DSN=CabalGame/g" \
        -e "s/DBId=cabaluser/DBId=$dbac/g" \
        -e "s/DBPwd=cabalpassword/DBPwd=$dbpass/g" \
        -e "s/DBAppName=DBAgent/DBAppName=$daemon/g" \
        > /etc/cabal/$daemon.ini
        
        count1=`expr $count1 + 1`

   elif [ $name == "WorldSvr" ]; then
        echo -n " link..."
        ln -sf /usr/bin/$name /usr/bin/$daemon
        echo -n " ini..."
        sed /etc/cabal/templates/$name.cfg \
        -e "s/MaxUserNum=500/MaxUserNum=$maxplayers/g" \
        -e "s/LogLevel=3/LogLevel=$loglvl/g" \
        -e "s/IPAddress=[0-9.]*/IPAddress=$pubip/g" \
        -e "s/ServerIdx=1/ServerIdx=`expr $i / 1`/g" \
        -e "s/GroupIdx=1/GroupIdx=`expr $j / 1`/g" \
        -e "s/Port=38111/Port=381`expr 10 + $count2`/g" \
        -e "s/Port=38181/Port=381`expr 80 + $i`/g" \
        -e "s/Port=38121/Port=381`expr 20 + $i`/g" \
        -e "s/AddrForClient=[0-9.]*/AddrForClient=$pubip/g" \
        > /etc/cabal/$daemon.ini

        instantwars="10 36 37 38 39 40 43 44 45 46 47"  #instant war channel number, ex. instantwars="31 32 33"
        for instantwar in $instantwars; do
        if [ ${daemon##*_} -eq $instantwar ]; then
          sed '/UseInstantWarNationReward=[01]/a\ \
          #only instant war channel \
          UseBootUpGmsChannelType=1 \
          WaitUntilChannelTypeSet=1 \
          InstantWarShutDownTimeAttackMilliSec=1800000' \
          /etc/cabal/$daemon.ini > /etc/cabal/$daemon.ini.tmp
          mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
          fi
        done

        count2=`expr $count2 + 1`

    elif [ $name == "ChatNode" ]; then
        echo  -n " link..."
        ln -sf /usr/bin/$name /usr/bin/$daemon
        echo -n " ini..."
       sed /etc/cabal/templates/$name.cfg \
       -e "s/MaxUserNum=20000/MaxUserNum=$playertotal/g" \
       -e "s/LogLevel=3/LogLevel=$loglvl/g" \
       -e "s/ServerNationIdx=1/ServerNationIdx=`expr $i / 1`/g" \
       -e "s/Port=38121/Port=381`expr 20 + $i`/g" \
       -e "s/Port=38181/Port=381`expr 80 + $i`/g" \
       > /etc/cabal/$daemon.ini

       count3=`expr $count3 + 1`
    fi

    ln -sf /etc/init.d/cabal_server /etc/init.d/$daemon
    echo  " service."
done

echo -n "Creating: Common.ini... "
sed /etc/cabal/templates/Common.cfg \
-e "s/TimeAttackSec=1800/TimeAttackSec=$tgw/g" \
-e "s/TimeAttackSec=3600/TimeAttackSec=$tgd/g" \
> /etc/cabal/Common.ini
cp /etc/cabal/templates/Common-hardcore.cfg /etc/cabal/Common-hardcore.ini
cp /etc/cabal/templates/Common-hardcore4x.cfg /etc/cabal/Common-hardcore4x.ini
cp /etc/cabal/templates/Common-halloween.cfg /etc/cabal/Common-halloween.ini

echo "odbc.ini... $dbip"
sed /etc/cabal/templates/odbc.cfg \
-e "s/192.168.2.9/$dbip/g" \
-e "s/1433/$dbport/g" \
-e "s/CabalGame24/CabalGame/g" \
> /etc/odbc.ini.tmp
mv /etc/odbc.ini.tmp /etc/odbc.ini

echo "Setting permissions..."
chmod -R 0777 /etc/cabal
chmod 0777 /usr/bin/LoginSvr*
chmod 0777 /usr/bin/DBAgent*
chmod 0777 /usr/bin/ChatNode*
chmod 0777 /usr/bin/WorldSvr*
chmod 0777 /etc/init.d/LoginSvr_*
chmod 0777 /etc/init.d/DBAgent_*
chmod 0777 /etc/init.d/ChatNode_*
chmod 0777 /etc/init.d/WorldSvr_*
chmod 0777 /usr/bin/GlobalDBAgent
chmod 0777 /usr/bin/GlobalMgrSvr
chmod 0777 /usr/bin/CashDBAgent
chmod 0777 /etc/odbc.ini

sed /etc/cabal/templates/Const.cfg \
-e "s/u00/1000/g" \
-e "s/v00/1000/g" \
-e "s/w00/1000/g" \
-e "s/x00/1000/g" \
-e "s/y00/1000/g" \
-e "s/z00/1000/g" \
-e "s/abcd/2/g" \
> /etc/cabal/Data/Const.scp
echo "Creating: Const.scp... "

if [ -f /etc/cabal/where_are_my_configs.txt ]; then
  rm -f /etc/cabal/where_are_my_configs.txt
fi

for daemon in `cat /etc/cabal/server_list | grep -v ^#`; do
  name="${daemon%%_*}"
  echo -e "\nStarting $daemon..."
  if [ $name == "GlobalMgrSvr" ]; then
    /usr/bin/$daemon
    sleep 10
  else
    /usr/bin/$daemon
    sleep 2
  fi
done