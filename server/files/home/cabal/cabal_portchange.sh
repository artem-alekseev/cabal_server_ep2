#!/bin/sh

if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi

echo -e "Changing server ports...\n"

for daemon in `cat /etc/cabal/server_list | grep -v ^#`; do 
    name="${daemon%%_*}"
    if [ $name == "GlobalMgrSvr" ]; then
        sed /etc/cabal/$daemon.ini \
        -e "s/Port=38170/Port=68170/g" \
        -e "s/Port=38180/Port=68180/g" \
        > /etc/cabal/$daemon.ini.tmp
        mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
        echo "$daemon done."
    elif [ $name == "LoginSvr" ]; then
        sed /etc/cabal/$daemon.ini \
        -e "s/Port=38101/Port=68101/g" \
        -e "s/Port=38170/Port=68170/g" \
        -e "s/Port=38180/Port=68180/g" \
        > /etc/cabal/$daemon.ini.tmp
        mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
        echo "$daemon done."
    elif [ $name == "GlobalDBAgent" ]; then
        sed /etc/cabal/$daemon.ini \
        -e "s/Port=38180/Port=68180/g" \
        > /etc/cabal/$daemon.ini.tmp
        mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
        echo "$daemon done."
    elif [ $name == "CashDBAgent" ]; then
        sed /etc/cabal/$daemon.ini \
        -e "s/Port=38190/Port=68190/g" \
        > /etc/cabal/$daemon.ini.tmp
        mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
        echo "$daemon done."
    elif [ $name == "DBAgent" ]; then
        sed /etc/cabal/$daemon.ini \
        -e "s/Port=38181/Port=68181/g" \
        > /etc/cabal/$daemon.ini.tmp
        mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
        echo "$daemon done."
   elif [ $name == "WorldSvr" ]; then
        sed /etc/cabal/$daemon.ini \
        -e "s/Port=38111/Port=68111/g" \
        -e "s/Port=38112/Port=68112/g" \
        -e "s/Port=38181/Port=68181/g" \
        -e "s/Port=38170/Port=68170/g" \
        -e "s/Port=38190/Port=68190/g" \
        -e "s/Port=38121/Port=68121/g" \
        > /etc/cabal/$daemon.ini.tmp
        mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
        echo "$daemon done."
    elif [ $name == "ChatNode" ]; then
       sed /etc/cabal/$daemon.ini \
       -e "s/Port=38121/Port=68121/g" \
       -e "s/Port=38181/Port=68181/g" \
       -e "s/Port=38170/Port=68170/g" \
        > /etc/cabal/$daemon.ini.tmp
        mv /etc/cabal/$daemon.ini.tmp /etc/cabal/$daemon.ini
        echo "$daemon done."
    fi
done

echo "odbc.ini done."
sed /etc/odbc.ini \
-e "s/Port        = 1433/Port        = 1433/g" \
> /etc/odbc.ini.tmp
mv /etc/odbc.ini.tmp /etc/odbc.ini

echo -e "\nAll done.\n"