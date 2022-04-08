#!/bin/sh

sqlcmd -S localhost -U SA -P "$SA_PASSWORD" -Q "CREATE DATABASE [account];
CREATE DATABASE [cabal_managerdb];
CREATE DATABASE [Cabal_Stat];
CREATE DATABASE [CabalCash];
CREATE DATABASE [Event];
CREATE DATABASE [gamedb]"

chown mssql /var/opt/mssql/data

sqlcmd -S localhost -U SA -P "$SA_PASSWORD" -Q "RESTORE DATABASE [account] FROM DISK = N'/var/opt/mssql/backup/account.bak' WITH FILE = 1, NOUNLOAD, REPLACE, STATS = 5;
RESTORE DATABASE [cabal_managerdb] FROM DISK = N'/var/opt/mssql/backup/cabal_managerdb.bak' WITH FILE = 1, NOUNLOAD, REPLACE, STATS = 5;
RESTORE DATABASE [Cabal_Stat] FROM DISK = N'/var/opt/mssql/backup/Cabal_Stat.bak' WITH FILE = 1, NOUNLOAD, REPLACE, STATS = 5;
RESTORE DATABASE [CabalCash] FROM DISK = N'/var/opt/mssql/backup/CabalCash.bak' WITH FILE = 1, NOUNLOAD, REPLACE, STATS = 5;
RESTORE DATABASE [Event] FROM DISK = N'/var/opt/mssql/backup/Event.bak' WITH FILE = 1, NOUNLOAD, REPLACE, STATS = 5;
RESTORE DATABASE [gamedb] FROM DISK = N'/var/opt/mssql/backup/gamedb.bak' WITH FILE = 1, NOUNLOAD, REPLACE, STATS = 5;"

sqlcmd -S localhost -U SA -P "$SA_PASSWORD" -Q "USE [account];EXEC [dbo].[cabal_user_register] @id = N'admin', @password = N'admin';"