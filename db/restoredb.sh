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

sqlcmd -S localhost -U SA -P "$SA_PASSWORD" -Q "USE [CabalCash]; CREATE TABLE [dbo].[Bank] (
    [UserNum] [int] NOT NULL ,
    [Alz] [bigint] NOT NULL
    ) ON [PRIMARY]
    GO

    CREATE TABLE [dbo].[ShopItems] (
    [Id] [int] IDENTITY (1, 1) NOT NULL ,
    [Name] [varchar] (50) COLLATE Chinese_PRC_CI_AS NOT NULL ,
    [Description] [varchar] (200) COLLATE Chinese_PRC_CI_AS NOT NULL ,
    [ItemIdx] [int] NOT NULL ,
    [DurationIdx] [int] NOT NULL ,
    [ItemOpt] [int] NOT NULL ,
    [Image] [varchar] (200) COLLATE Chinese_PRC_CI_AS NOT NULL ,
    [Honour] [int] NULL ,
    [Alz] [int] NULL ,
    [Category] [int] NOT NULL ,
    [Available] [int] NOT NULL
    ) ON [PRIMARY]
    GO

    SET QUOTED_IDENTIFIER OFF
    GO
    SET ANSI_NULLS OFF
    GO


    CREATE PROCEDURE SetBankAlz( @UserNum int, @Alz bigint)
    AS
    BEGIN
    BEGIN TRAN
    IF NOT EXISTS( SELECT UserNum
    FROM Bank
    WHERE UserNum = @UserNum )
    BEGIN
    INSERT Bank	(UserNum, Alz)
    VALUES ( @UserNum, 0)
    END
    ELSE
    BEGIN
    UPDATE Bank
    SET Alz = @Alz
    WHERE UserNum = @UserNum
    END
    COMMIT TRAN
    END


    GO
    SET QUOTED_IDENTIFIER OFF
    GO
    SET ANSI_NULLS ON
    GO

    SET QUOTED_IDENTIFIER ON
    GO
    SET ANSI_NULLS OFF
    GO



    CREATE PROCEDURE [dbo].[GetBankAlz]( @UserNum int ) AS
    BEGIN
    if ( SELECT UserNum FROM Bank WHERE UserNum = @UserNum ) is Null
    BEGIN
    INSERT Bank ( UserNum, Alz)
    VALUES( @UserNum, 0)
    END
    SELECT UserNum, Alz
    FROM Bank
    WHERE UserNum = @UserNum
    END



    GO
    SET QUOTED_IDENTIFIER OFF
    GO
    SET ANSI_NULLS ON
    GO

    BEGIN TRANSACTION
    SET TRANSACTION ISOLATION LEVEL SERIALIZABLE
    SET QUOTED_IDENTIFIER ON
    SET ANSI_NULLS ON
    SET ANSI_PADDING ON
    SET ANSI_WARNINGS ON
    SET ARITHABORT ON
    SET NUMERIC_ROUNDABORT OFF
    SET CONCAT_NULL_YIELDS_NULL ON
    SET XACT_ABORT ON
    COMMIT TRANSACTION
    GO

    IF EXISTS (select * from tempdb..sysobjects where id = OBJECT_ID('tempdb..#ErrorLog'))
    DROP TABLE #ErrorLog
    CREATE TABLE #ErrorLog
    ( pkid [int] IDENTITY(1,1) NOT NULL, errno [int] NOT NULL, errdescr [varchar](100) NULL )
    GO

    IF @@TRANCOUNT=0 BEGIN TRANSACTION
    GO

    ALTER TABLE [dbo].[Bank] ADD
    CONSTRAINT [DF_Bank_Alz] DEFAULT (0) FOR [Alz]
    GO

    IF @@TRANCOUNT=0 BEGIN TRANSACTION
    GO
    SET QUOTED_IDENTIFIER ON
    GO
    SET ANSI_NULLS OFF
    GO

    SET QUOTED_IDENTIFIER OFF
    GO
    SET ANSI_NULLS ON
    GO

    IF @@TRANCOUNT=0 BEGIN TRANSACTION
    GO
    SET QUOTED_IDENTIFIER OFF
    GO
    SET ANSI_NULLS OFF
    GO

    SET QUOTED_IDENTIFIER OFF
    GO
    SET ANSI_NULLS ON
    GO

    IF EXISTS (Select * from #ErrorLog)
    BEGIN
    IF @@TRANCOUNT>0 ROLLBACK TRANSACTION
    END
    ELSE
    BEGIN
    IF @@TRANCOUNT>0 COMMIT TRANSACTION
    END
    IF EXISTS (Select * from #ErrorLog)
    BEGIN
    Print 'Database synchronization script failed'
    GOTO QuitWithErrors
    END
    ELSE
    BEGIN
    Print 'Database synchronization completed successfully'
    END

    QuitWithErrors:"