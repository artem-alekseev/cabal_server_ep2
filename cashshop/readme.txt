This is a VERY basic PHP registration page and cash shop for Cabal Online.

Tested on WinXP 32 bit, Windows 2003 64 bit, Xampp, MSSQL 2000, MSSQL 2005.

You can use the default PHP MSSQL libs or you can use FreeTDS for Windows.
I would probably recommend FreeTDS but this is optional.

It should be ok on IIS with PHP support, but i have not tested this.


 v2 changes
============

It is now possible to log in via the regpage and access both the shop and
the shop admin, you are no longer restricted to accessing in-game only. The
game login and password is used to log in.

When buying items in the cash shop Alz is no longer taken directly from the
warehouse. You must log into the regpage and transfer Alz from warehouse
to the bank (you can only do this when not logged into the game). Alz from
the bank is used to buy cash items either whilst logged into the regpage
or from the in-game cash shop button.

This method does make it easier for those that want donations or some other
form of payment for cash items as you can now populate the bank manually.

DO NOT use the X at the top left of the cash shop itself to try and exit
back to the other panels. The game uses a special URL to close the in-game
browser and this won't work outside the game. Anywhere outside the actual
cash shop the X button should be ok.


 Upgradng from v1
==================

1. Copy the new files to the webserver
   - Your existing config.php will not be overwritten
   - You will need to copy the ALLOW_BANK section into your existing config
     if you want to use the option.

2. Run database/upgrade_v1.sql on you cash shop database
   - Existing items will not be lost


 New Installations
===================

1. Copy the files to a directory on your webserver.

2. Copy config.default.php->config.php, edit to add your MSSQL server logon and
   website/forums. Make SURE you set the right ServerIdx or cash items will not
   get delivered!

3. Create a new database called "CashShop" and run database/db.sql on it.

4. In etc/cabal/WorldSvr_XX_YY.ini set the following:

   UseCashShop=1

   Only enable it on WorldSvrs you want the shop available from.

5. Open cabalmain.exe in a hex editor and look around 0x3dee8c. The actual address
   will be different for different cabalmain.exes but the string you are looking
   for (assiming it hans't been changed already) is:

   http://shop.cabal.ogplanet.com/cabalAppShop/default.aspx?v1=

   Once you have found the string is being used for the cash shop address and replace:

   http://www.myserver.com/webshop.php?v1=

   The string must be properly zero terminated and cannot be longer than 63 chars
   unless you know how to relocate the string in the exe.

   To see exactly what address the client is using hit the cash shop button in
   game. Right-click and select Properties. That will help you find it in the exe
   using a search ;)

6. Test.


Test mode is enabled by default so you can check the shop is picking up the right
users when launched using the in game cash shop button. It will display the
UserNum (v1), the login AuthKey (v2), confirm the login name and the amount of Alz
is the login's Warehouse. It should look similar to this:

data=v1=1&v2=5229E0C411AF4F23B968B0653A76F043 
v1=1 
v2=5229E0C411AF4F23B968B0653A76F043 
Found user ok. 
Name=Test. 
Alz=999999999.

One you are happy it is working ok open config.php and set the following:

// Print debug info at the top of the cash shop pages
define('TESTMODE',false);


 Adding/Editing/Deleting items
===============================

Items are added using the admin button on the left of the cash shop pages.

The admin button will only appear if at least 1 char on your account is
a GM (Nation=3). Otherwise the button will not appear and any attempts to
access the admin panel will result in hack attempt messages.


 Disabling Alz transfers
=========================

In config.php:

define('ALLOW_BANK',false);

Set this to false if you don't want to let players transfer Alz to the bank.
This enables you to populate the bank in other ways such as donations.


 Maintenance Mode
==================

In config.php:

// Maintenance mode, open to GMs only.
define('MAINTMODE',false);

Set this to true and only accounts with at least 1 GM character can access the
cash shop.


 IP validation
===============

In config.php:

// Uses LastIp validation as well as UserNum and AuthKey
// Can cause problems
define('IPVALIDATION',false);

The shop uses the UserNum and AuthKey from the DB to authorise people in the shop
and enabling this will also check the player's IP address matches the LastIp in
the database too. This can cause problems on some setups but for security reasons
keep it enabled unless you get a lot of unexpected hack attempt messages when trying
to use the cash shop.


 Other useful stuff
====================

The DB values are:

Name
Description
ItemIdx
DurationIdx
ItemOpt
Image file (images/items/ucore(high).gif)
Honour cost (not supported yet)
Alz cost
Category
Num available in the shop

The category numbers are the tab numbers in the cash shop 1-5 with 1 being the
left tab and 5 being the right.

Check images/png for blank tab and button images.


 Credits
=========

Code & layout: mrmagoo (chumpywumpy)
Suggestions/testing/bug fixes: VisualEvolution, Xcellz, Cypher, Lost-Spirit, an2ny_18


 FreeTDS for Windows (optional)
================================

First download the right version of the lib for your version of PHP.

PHP 5.1.x
http://kromann.info/php5_1-Release_TS/php_dblib.dll

PHP 5.2.x
http://kromann.info/php5_2-Release_TS/php_dblib.dll

PHP 6.x
http://kromann.info/php6-Release_TS/php_dblib.dll

Place the .dll in the PHP extensions directory (extension_dir in php.ini)


Here are my php.ini settings:

magic_quotes_gpc = Off or
magic_quotes_gpc = On and magic_quotes_sybase = On 

;extension=php_mssql.dll
extension=php_dblib.dll

; Valid range 0 - 2147483647.  Default = 4096.
mssql.textlimit = 20971520

; Valid range 0 - 2147483647.  Default = 4096.
mssql.textsize = 20971520

; Use NT authentication when connecting to the server
mssql.secure_connection = Off

You will also need to create c:\freetds.conf

[global]
host = 127.0.0.1
port = 1433
client charset = UTF-8
tds version = 8.0
text size = 20971520


Note: "tds version = 8.0" is correct for MSSQL 2000, use 9.0 for MSSQL 2005
and 10.0 for MSSQL 2008.