<?php

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >';
echo '<HTML><HEAD>';
echo '<title>CABAL Online - The Revolution of Action</title> ';
echo '<meta content="JavaScript" name="vs_defaultClientScript">';
echo '<link title="style" href="./shopstyle.css" type="text/css" rel="stylesheet">';	
echo '</HEAD>';
echo '<body bgcolor="#000000;" onLoad="setTimeout(\'loaded()\',500)" id="default">';

if (ini_get('register_globals')!=0) {
	echo 'The "register_globals" setting in your php.ini is on. This is a security problem and must be fixed.';
	die;
}

include('config.php');

if (TESTMODE==true) echo '<span class="white"><strong>User data='.$_SERVER['QUERY_STRING'].'<br />';
$v1=$_REQUEST['v1'];
$v2=$_REQUEST['v2'];
$ip=$_SERVER['REMOTE_ADDR'];
if (TESTMODE==true) echo 'v1='.$v1.'<br />v2='.$v2.'<br />IP address: '.$ip.'<br />';
  
if (!is_numeric($v1)) die('Hack attempt');
if (!ctype_alnum($v2)) die('Hack attempt');

$link = mssql_connect(DB_ADDR, DB_USER, DB_PASS);
if (!$link) die('Could not connect to MSSQL database.');
  $q="select * from ".DB_ACC.".dbo.cabal_auth_table where UserNum='".$v1."'and AuthKey='".$v2."'";
  if (IPVALIDATION==true) $q=$q." and LastIp='".$ip."'";
  $r=mssql_query($q);
  if (mssql_num_rows($r)==1) {
	if (TESTMODE==true) echo 'Found user ok<br />';
  } else {
	die('You are not a valid user');
  }
  $row = mssql_fetch_row($r);
  $name=$row[1];
  if (TESTMODE==true) echo 'Name='.$name.'<br />';

  $r=mssql_query("exec ".DB_CSH.".dbo.getbankalz '".$v1."'");
  if (mssql_num_rows($r)==0) {
	  die('Could not get Warehouse Alz');
  } else {
	if (TESTMODE==true) echo 'Found Alz ok<br />';
  }
  $row = mssql_fetch_row($r);
  $alz=$row[1];
  if (TESTMODE==true) echo 'Alz='.$alz.'</strong></span>';
  
  if (isset($_REQUEST['tab'])) {
	  $tab=$_REQUEST['tab'];
	  if (!is_numeric($tab)) die('Hack attempt');
  } else {
	  $tab='1';
  }

$is_gm=false;
$r=mssql_query('select * from '.DB_GAM.'.dbo.cabal_character_table where CharacterIdx between '.$v1.' * 8 and '.$v1.' * 8 + 5 and nation=3');
if (mssql_num_rows($r)>0) $is_gm=true;  
if (MAINTMODE==true and $is_gm==false) die ('Maintenance mode is active.');

echo '<div id="wrapper" style=display:none>';

echo '<form name="Default" method="post" action="webshop.php" id="Default">';

echo '<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">';
echo '<tr>';
echo '<td align="center">';
  echo '<table width="800" border="0" cellspacing="0" cellpadding="0">';
  echo '<tr>';
  echo '<td height="25" background="images/Item_Game_Box_01.gif" style="PADDING-RIGHT: 0px; PADDING-LEFT: 773px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px"><img src="images/Item_Game_Box_10.gif" width="11" height="10" border="0" onclick="javscript:location.href=\'http://cabalclose\'" style="cursor:pointer;" alt="Item Shop Close"></td>';
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
      echo '<td width="174" height="50" align="center" class="white">Welcome <strong>'.$name.'</strong></td>';
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
        echo '<img src="images/Item_Game_Box_20.gif" width="160" height="26" border="1" style="CURSOR:pointer" onclick="javascript:location.href=\'./webshop.php?v1='.$v1.'&v2='.$v2.'\'" width="160" height="26" vspace="3" border="0"></br>';
        echo '<img src="images/Item_Game_Box_21.gif" width="160" height="26" border="1" style="CURSOR:pointer" onclick="javascript:location.href=\'./index.php?action=account&v1='.$v1.'&v2='.$v2.'\'" width="160" height="26" vspace="3" border="0"></br>';
        if ($is_gm==true) echo '<img src="images/Item_Game_Box_22.gif" style="CURSOR:pointer" onclick="javascript:location.href=\'./admin.php?v1='.$v1.'&v2='.$v2.'\'" width="160" height="26" vspace="3" border="0"></br>';
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
    
	draw_tabs($tab);
	
    echo '</td>';
    echo '</tr>';
    echo '</table>';
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td><img src="images/Item_Game_Box_04.gif" width="800" height="17"></td>';
  echo '</tr>';
  echo '</table>';
echo '</td>';
echo '</tr>';
echo '</table>';

echo '</div>';

echo '<table width="100%" height="100%"  align="center" id="loading">';
echo '<tr>';
echo '<td align="center" valign="middle">';
echo '<table bgcolor="#666666" cellspacing="9" border="1" width="250" height="60">';
echo '<tr>';
echo '<td align="center">';
echo '<font size="2" color="#eeeeee">Loading...</font>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<marquee direction="right" width="250" scrollamount="8">';
echo '<table width="250" height="5" bgcolor="white">';
echo '<tr><td><p></td></tr>';
echo '</table>';
echo '</marquee>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';
echo '</table>';

echo '</form>';

				       		
function draw_tabs($tab) {
  global $v1, $v2;
  $t1='Off';$t2='Off';$t3='Off';$t4='Off';$t5='Off';
  switch ($tab) {
    case 1:
      $t1='On';
    break;	  
    case 2:
      $t2='On';
    break;		  
    case 3:
      $t3='On';
    break;	
    case 4:
      $t4='On';
    break;	    
    case 5:
      $t5='On';
    break;	    
  }    
    	  
  echo '<table width="594"  border="0" cellspacing="0" cellpadding="0">';
  echo '<tr><td valign="top"><img src="images/Item_Box_Img_01.gif" width="594" height="12"></td></tr>';
  echo '<tr><td valign="top" align="center" background="images/Item_Box_Img_03.gif" height="500">';
    echo '<table width="571" border="0" cellspacing="0" cellpadding="0">';
    echo '<tr><td height="50" colspan="3" background="images/Item_Menu_Bg_00.gif" bgcolor="#000000">';
   
      echo '<table width="287" height="50" border="0" cellpadding="0" cellspacing="0">';
      echo '<tr>';
	  echo '<td align="left" style="PADDING-RIGHT:1px"><img  src="images/Menu_Item1_'.$t1.'.gif" name="Image9" width="95" height="50" border="0" onclick="javascript:location.href=\'./webshop.php?v1='.$v1.'&v2='.$v2.'&tab=1\'" style="CURSOR:pointer"></td>';
	  echo '<td align="left" style="PADDING-RIGHT:1px"><img  src="images/Menu_Item2_'.$t2.'.gif" name="Image9" width="95" height="50" border="0" onclick="javascript:location.href=\'./webshop.php?v1='.$v1.'&v2='.$v2.'&tab=2\'" style="CURSOR:pointer"></td>		';		
	  echo '<td align="left" style="PADDING-RIGHT:1px"><img  src="images/Menu_Item3_'.$t3.'.gif" name="Image9" width="95" height="50" border="0" onclick="javascript:location.href=\'./webshop.php?v1='.$v1.'&v2='.$v2.'&tab=3\'" style="CURSOR:pointer"></td>';
	  echo '<td align="left" style="PADDING-RIGHT:1px"><img  src="images/Menu_Item4_'.$t4.'.gif" name="Image9" width="95" height="50" border="0" onclick="javascript:location.href=\'./webshop.php?v1='.$v1.'&v2='.$v2.'&tab=4\'" style="CURSOR:pointer"></td>';		
	  echo '<td align="left" style="PADDING-RIGHT:1px"><img  src="images/Menu_Item5_'.$t5.'.gif" name="Image9" width="95" height="50" border="0" onclick="javascript:location.href=\'./webshop.php?v1='.$v1.'&v2='.$v2.'&tab=5\'" style="CURSOR:pointer"></td>	';	
      echo '</tr>';
      echo '</table>';
  
    echo '</td></tr>';
    echo '<tr>';
    echo '<td width="1" valign="top"><img src="images/Item_Box_Img_07.gif" width="1" height="133"></td>';
    echo '<td width="569" align="center" valign="top">';
      content($tab);
    echo '</td>';
    echo '<td width="1" valign="top"><img src="images/Item_Box_Img_07.gif" width="1" height="133"></td>';
    echo '</tr>';
    echo '</table>';
  
  echo '</td></tr>';
  echo '<tr><td valign="top"><img src="images/Item_Box_Img_02.gif" width="594" height="12"></td></tr>';
  echo '</table>';
	
}


function content($tab) {
  global $v1, $v2;
  $r=mssql_query("select * from ".DB_CSH.".dbo.ShopItems where Category='".$tab."' and Available>0 order by Id asc");

  echo '<table width="541"  border="0" cellspacing="0" cellpadding="0">';
  echo '<tr><td valign="top" colspan="3"><img src="images/Item_premium_inbox1.gif" width="541" height="8"></td></tr>';	
  echo '<tr>';
  echo '<td background="images/Item_premium_inbox3.gif" width="8"></td>';
  echo '<td bgcolor="131313" height="420" width="525" valign="top" align="center">';
  
  echo '<div style="OVERFLOW-y: scroll;bgcolor:red; width:525;height:419">';  
  echo '<table width="500" cellspacing="4" cellpadding="0" border="0">';
  if (mssql_num_rows($r)==0) {
	 //echo 'No items found.';
  } else {
	  for ($i=1;$i<=mssql_num_rows($r);$i++) {
		  $row = mssql_fetch_row($r);
		  if ($row[6]=='') {
			  $pic='no_pic.gif';
	      } else {
		      $pic=$row[6];
	      }
		  echo '<tr>';
		  echo '<td width="90" rowspan="2"><img src="images/items/'.$pic.'" /></td>';
		  echo '<td valign="top" align="left" style="padding-left:8px;padding-top:4px" colspan="2"><span class="teal" style="font-size:14px;font-weight:bold;">'.$row[1].'</span><br /><span class="mini">'.$row[2].'</span></td></tr>';
		  echo '<tr><td align="left" style="padding-left:8px" width="270"><img src="images/Item_premium_R_03.gif" width="16" height="12"/>&nbsp<strong class="orange">'.$row[8].'</strong>&nbsp;<span class="mini">Alz</span></td>';
		  echo '<td align="right" width="81" height="22"><img src="images/Item_Purchase_05.gif" style="CURSOR: pointer" onclick="javscript:location.href=\'./buy.php?v1='.$v1.'&v2='.$v2.'&cd='.$row[0].'\'" alt="Confirm purchase" width="81" height="22" /></td></tr>';
		  echo '</tr>';
		  echo '<tr><td background="images/Item_premium_R_04.gif" width="7" height="1" colspan="3" style="padding-right:8px"></td></tr>';
		  mssql_next_result($r);
	  }
  }
  echo '</table>';
  echo '</div>';
    
  echo '</td>';
  echo '<td background="images/Item_premium_inbox4.gif" width="8"></td>';
  echo '</tr>';
  echo '<tr><td valign="top" colspan="3"><img src="images/Item_premium_inbox2.gif" width="541" height="8"></td></tr>';
  echo '</table>';	

}

?>

<script>
document.body.scroll = "no";

function loaded() 
{   
	setTimeout
	loading.style.display = 'none';
	wrapper.style.display = '';
}
</script>

</body></html>