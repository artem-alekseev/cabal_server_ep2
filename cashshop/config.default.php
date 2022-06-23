<?php

// General options for both reg page and cash shop

// Title shown at the top of pages
define('PAGE_TITLE','My Cabal Server');

// Link to website or patch
define('LINK_WSITE','http://www.mywebs.com');

// Text to display for link
define('NAME_WSITE','My Website Name');

// Link to forums
define('LINK_FORUM','http://mywebs.com/forums');

// Text to display for link
define('NAME_FORUM','My Forum Name');


// MSSQL server connection details
// Database server
define('DB_ADDR','127.0.0.1');
// Database login
define('DB_USER','sa');
// Database password
define('DB_PASS','password');

// In case you have a different db names
define('DB_ACC','ACCOUNT');
define('DB_GAM','GAMEDB');
define('DB_CCA','CABALCASH');
define('DB_CSH','CASHSHOP');

// ServerIdx MUST match the one in WorldSvr_XX_YY.ini or cash items
// Will not get delivered correctly.
define('SVR_IDX','24');

// Category names for cash shop admin panel
$cats=array(1=>'Costumes',2=>'Gear',3=>'Pets',4=>'Consumables',5=>'Items');

// Print debug info at the top of the cash shop pages
define('TESTMODE',true);

// Maintenance mode, open to GMs only.
define('MAINTMODE',true);

// Uses LastIp validation as well as UserNum and AuthKey
// Can cause problems
define('IPVALIDATION',true);

// Allow transfer of Alz from warehoue to the bank
// Set to false if you don't want to use Alz for cash items
define('ALLOW_BANK',true);

?>