<?php
session_start();

define('IN_CP',true);
define('PAGE_INDEX',$_SERVER['PHP_SELF']);

if (ini_get('register_globals')!=0) {
  echo 'The "register_globals" setting in your php.ini is on. This is a security problem and must be fixed.';
  die;
}

$uid='';$pwd='';$v1=''; $v2='';
if (isset($_REQUEST['uid'])) $uid=$_REQUEST['uid'];
if (isset($_REQUEST['pwd'])) $pwd=md5($_REQUEST['pwd']);
if (isset($_REQUEST['v1'])) $v1=$_REQUEST['v1'];
if (isset($_REQUEST['v2'])) $v2=$_REQUEST['v2'];
if (isset($_REQUEST['logout'])) {
	session_destroy();
	header('Refresh: 1; URL='.PAGE_INDEX);
	html_header('Logging out...');
                echo 'Logging out...';
	exit;
}

include('config.php');
$link = mssql_connect(DB_ADDR, DB_USER, DB_PASS);
if (!$link) die('Could not connect to MSSQL database.');

if ($uid<>'' && $pwd<>'') {
  $r=mssql_query('select ID,UserNum,AuthKey from '.DB_ACC.'.dbo.cabal_auth_table where id="'.$uid.'" and password="'.$pwd.'"');
  if (mssql_num_rows($r)==0) {
    header('Refresh: 4; URL='.PAGE_INDEX);
    html_header('Login failed...');
    echo 'Login Failed...';
    exit;
  } else {
    $row = mssql_fetch_row($r);
    $_SESSION['player']=$row[0];
    $_SESSION['v1']=$row[1];
    $_SESSION['v2']=$row[2];
    header('Refresh: 1; URL='.PAGE_INDEX);
    html_header('Logging in...');
    echo 'Logging in...';
    exit;
  }	
}

if ($v1<>'' && $v2<>'') {
  $r=mssql_query('select ID from '.DB_ACC.'.dbo.cabal_auth_table where UserNum="'.$v1.'" and AuthKey="'.$v2.'"');	
  if (mssql_num_rows($r)==0) {
    header('Refresh: 4; URL='.PAGE_INDEX);
    html_header('Login failed...');
    echo 'Login Failed...';
    exit;
  } else {
    $row = mssql_fetch_row($r);
    $_SESSION['player']=$row[0];
    $_SESSION['v1']=$v1;
    $_SESSION['v2']=$v2;
  }	
}

if (isset($_REQUEST['action'])) {
	$action=$_REQUEST['action'];
} else {
	$action='';
}

html_header();

echo '<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">';
echo '<tr>';
echo '<td align="center">';

// Menu bar

echo '<table width="600" cellspacing="0" cellpadding="0" border="0">';
echo '<tr><td align="left"><img src="./images/logo.png" style="position:absolute;top:0px" height="100" width="600" /></td><tr>';
echo '<tr><td align="center">';
  if (!isset($_SESSION['v1'])) {
    echo '<form method="post" action="'.PAGE_INDEX.'?login">';
    echo 'Login:&nbsp;<input type="text" name="uid" class="editbox" size="10" />&nbsp;';
    echo 'Pass:&nbsp;<input type="password" name="pwd" class="editbox" size="10" />&nbsp;';
    echo '<input type="submit" name="login" value="Log in" class="button" />';
    echo '</form>';
  } else {
    $action='account';
  }
echo '</td></tr></table>';
  
if ($action<>'') {
  switch($action) {
    case 'account':
      include('account.php');
      break;  
    case 'deposit':
      include('account.php');
      break;
    default:
      include('reg.php');	  
  }	
} else {
  include('reg.php');	
}

echo '</td></tr></table>';
echo '</body></html>';

///////////////////////////////////////////////////////////////////////////////

function box_top($alz,$is_gm=true) {
  echo '<table width="800" border="0" cellspacing="0" cellpadding="0">';
  echo '<tr>';
  echo '<td height="25" background="images/Item_Game_Box_01b.gif" style="PADDING-RIGHT: 0px; PADDING-LEFT: 773px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px"><img src="images/Item_Game_Box_10.gif" width="11" height="10" border="0" onclick="javscript:location.href=\''.PAGE_INDEX.'?logout\'" style="cursor:pointer;" alt="Item Shop Close"></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td><img src="images/Item_Game_Box_02.gif" width="800" height="15"></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td align="center" background="images/Item_Game_Box_03.gif">';
    echo '<table width="772" border="0" cellspacing="0" cellpadding="0">';
    echo '<tr>';
    echo '<td width="178" align="center" valign="top">';
      echo '<table width="174" height="400" border="0" cellpadding="0" cellspacing="0">';
      echo '<tr>';
      echo '<td width="174" height="50" align="center" class="white">Welcome <strong>'.$_SESSION['player'].'</strong></td>';
      echo '</tr>';
      echo '<tr>';
        echo '<td width="174" height="55" background="images/Item_Game_Box_05.gif" class="teal" style="PADDING-RIGHT: 0px; PADDING-LEFT: 15px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">';

        echo '<table border="0" cellspacing="0" cellpadding="0">';
        echo '<tr>';
        echo '<td>&nbsp;</td>';
        echo '<td class="cloud2"><strong>Bank Alz</strong></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td width="20"><strong class="white"><img src="images/Item_premium_R_03.gif" width="16"  vspace="0"></strong></td>';
        echo '<td width="130"><strong class="orange">'.$alz.'</strong></td>';
        echo '</tr>';
        echo '</table>';

        echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td align="center" valign="top" background="images/Item_Game_Box_06.gif">';
        echo '<img src="images/Item_Game_Box_20.gif" width="160" height="26" border="1" style="CURSOR:pointer" onclick="javascript:location.href=\'./webshop.php?v1='.$_SESSION['v1'].'&v2='.$_SESSION['v2'].'\'" width="160" height="26" vspace="3" border="0"></br>';
        echo '<img src="images/Item_Game_Box_21.gif" width="160" height="26" border="1" style="CURSOR:pointer" onclick="javascript:location.href=\'./index.php?action=account\'" width="160" height="26" vspace="3" border="0"></br>';
        if ($is_gm==true) echo '<img src="images/Item_Game_Box_22.gif" style="CURSOR:pointer" onclick="javascript:location.href=\'./admin.php?v1='.$_SESSION['v1'].'&v2='.$_SESSION['v2'].'\'" width="160" height="26" vspace="3" border="0"></br>';
        echo '<img src="images/Item_Game_Box_23.gif" width="160" height="26" border="1" style="CURSOR:pointer" onclick="javascript:location.href=\''.LINK_FORUM.'\'" width="160" height="26" vspace="3" border="0"></td>';
      echo '</tr>';   
      echo '<tr>';
      echo '<td height="5"><img src="images/Item_Game_Box_07.gif" width="174" height="5"></td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td height="5"></td>';
      echo '</tr>';
      echo '</table>';
    echo '</td>';		
    echo '<td align="center" valign="top"  style="padding: 5 5 5 0">';
    	
  echo '<table width="594"  border="0" cellspacing="0" cellpadding="0">';
  echo '<tr><td valign="top"><img src="images/Item_Box_Img_01.gif" width="594" height="12"></td></tr>';
  echo '<tr><td valign="top" align="center" background="images/Item_Box_Img_03.gif" height="500" style="padding-top:8px">';
    echo '<table width="571" border="0" cellspacing="0" cellpadding="0">';
    echo '<tr>';
    echo '<td width="569" align="center" valign="top">';

	
}

function box_bottom() {
    echo '</td>';
    echo '</tr>';
    echo '</table>';
  echo '</td></tr>';
  echo '<tr><td valign="top"><img src="images/Item_Box_Img_02.gif" width="594" height="12"></td></tr>';
  echo '</table>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td><img src="images/Item_Game_Box_04.gif" width="800" height="17"></td>';
  echo '</tr>';
  echo '</table>';		
}

function html_header($title=PAGE_TITLE) {
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >';
                echo '<HTML><HEAD>';
                echo '<meta content="JavaScript" name="vs_defaultClientScript">';
                echo '<link title="style" href="layout.css" type="text/css" rel="stylesheet">';	
                echo '<meta http-equiv="Content-Type" content="text/html; charset=US">';
                echo '<title>'.$title.'</title></head>';
                echo '<body>';	
	
}
?>