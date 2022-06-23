<?php
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >';
echo '<HTML><HEAD>';
echo '<title>CABAL Online - The Revolution of Action</title> ';
echo '<meta content="JavaScript" name="vs_defaultClientScript">';
echo '<link title="style" href="./shopstyle.css" type="text/css" rel="stylesheet">';	
echo '</HEAD>';
echo '<body bgcolor="#000000;" onLoad="setTimeout(\'loaded()\',500)" id="default">';

$v1=$_REQUEST['v1'];
$v2=$_REQUEST['v2'];
$ip=$_SERVER['REMOTE_ADDR'];
if (!is_numeric($v1)) die('Hack attempt');
if (!ctype_alnum($v2)) die('Hack attempt');
 
$item=0;
$confirm=0;
if (isset($_REQUEST['cd'])) {
  $item=$_REQUEST['cd'];
  if (!ctype_digit($item)) $item=0;
}
if (isset($_REQUEST['co'])) {
  $confirm=$_REQUEST['co'];
  if (!ctype_digit($confirm)) $confirm=0;
}

  include('config.php');
  $link = mssql_connect(DB_ADDR, DB_USER, DB_PASS);
  
$is_gm=false;
$r=query_db('select * from '.DB_GAM.'.dbo.cabal_character_table where CharacterIdx between '.$v1.' * 8 and '.$v1.' * 8 + 5 and nation=3');
if (mssql_num_rows($r)>0) $is_gm=true;  
if (MAINTMODE==true and $is_gm==false) die ('Maintenance mode is active.');

if ($confirm>0 && $item==0) {
  if (!$link) die('Could not connect to MSSQL database.');
  $q="select * from ".DB_ACC.".dbo.cabal_auth_table where UserNum='".$v1."'and AuthKey='".$v2."'";
  if (IPVALIDATION==true) $q=$q." and LastIp='".$ip."'";  
  $r=query_db($q);
  $row = mssql_fetch_row($r);
  $name=$row[1];
  $r=query_db("exec ".DB_CSH.".dbo.getbankalz '".$v1."'");
  $row = mssql_fetch_row($r);
  $alz=$row[1];
  $r=query_db("select * from ".DB_CSH.".dbo.ShopItems where Id='".$confirm."' and Available>0");
  if (mssql_num_rows($r)==0) {
	  error_box('Purchase failed','Not enough items left in the shop.');
  } else {
    $row = mssql_fetch_row($r);
    $itemidx=$row[3];
    $durationidx=$row[4];
    $itemopt=$row[5];
    $price=$row[8];
    $available=$row[10];
    if ($alz<$price) {
      error_box('Error','You do not have enough Alz to purchase the item');
    } else {
      $newalz=$alz-$price;
      $newavailable=$available-1;
      hardlog('Item purchased: '.$itemidx.','.$durationidx.','.$itemopt.','.$price.','.$available.' ('.$alz.'/'.$newalz.')');
      $r=query_db("update ".DB_CSH.".dbo.ShopItems set Available='".$newavailable."' where Id='".$row[0]."'");
      $r=query_db("exec ".DB_CSH.".dbo.setbankalz '".$v1."','".$newalz."'");
      $r=query_db("exec ".DB_CCA.".dbo.up_addmycashitem '".$v1."','1','".SVR_IDX."','".$itemidx."','".$itemopt."','".$durationidx."'");
      error_box('Purchase successful','The item was successfully. You can claim the cash item by closing the cash shop.');
    }
  }
  
} elseif ($item>0 && $confirm==0) {
  $r=query_db("select * from ".DB_CSH.".dbo.ShopItems where Id='".$item."' and Available>0");
  if (mssql_num_rows($r)==0) {
	  error_box('Purchase failed','Not enough items left in the shop.');
  } else {
	
    echo '<DIV id=wrapper style="DISPLAY: none">';

    echo '<TABLE height="100%" width="100%">';
    echo '<TBODY><TR><TD vAlign=center align=middle>';
      echo '<TABLE cellSpacing=0 cellPadding=0 border=0><TBODY>';
      echo '<TR><TD width=35><IMG height=40 src="images/Item_Game_Box_s_01.gif" width=35></TD>';
      echo '<TD class=white style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; PADDING-TOP: 5px" vAlign=top align=middle background="images/Item_Game_Box_s_02.gif"><STRONG>Are you sure?</STRONG></TD>';
      echo '<TD width=35><IMG height=40 src="images/Item_Game_Box_s_03.gif" width=35></TD></TR>';
      echo '<TR>';
      echo '<TD background="images/Item_Game_Box_s_04.gif">&nbsp;</TD>';
      echo '<TD class=orange style="PADDING-BOTTOM: 20px; PADDING-TOP: 20px" align=middle width=200 background="images/Item_Game_Box_s_05.gif" height=50><STRONG><SPAN style="WIDTH: 280px">Please confirm you wish to buy the selected item.</SPAN></STRONG></TD>';
      echo '<TD background="images/Item_Game_Box_s_06.gif">&nbsp;</TD>';
      echo '</TR>';
      echo '<TR>';
      echo '<TD background="images/Item_Game_Box_s_04.gif">&nbsp;</TD>';
      echo '<TD class=orange style="PADDING-BOTTOM: 20px; PADDING-TOP: 20px" align=middle background="images/Item_Game_Box_s_05.gif" height=20>';
      echo '<IMG style="CURSOR: pointer" onclick="javscript:location.href=\'./buy.php?v1='.$v1.'&v2='.$v2.'&co='.$item.'\'" alt="Confirm purchase" src="images/Btn_Yes.gif" border=0>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
      echo '<IMG style="CURSOR: pointer" onclick="javscript:location.href=\'./webshop.php?v1='.$v1.'&v2='.$v2.'\'" alt="Cancel purchase" src="images/Btn_No.gif" border=0>';
      echo '</TD>';
      echo '<TD background="images/Item_Game_Box_s_06.gif">&nbsp;</TD>';
      echo '</TR>';
      echo '<TR>';
      echo '<TD><IMG src="images/Item_Game_Box_s_07.gif" width=35></TD>';
      echo '<TD background="images/Item_Game_Box_s_08.gif">&nbsp;</TD>';
      echo '<TD><IMG src="images/Item_Game_Box_s_09.gif" width=35></TD>';
      echo '</TR></TBODY>';
      echo '</TABLE>';
    echo '</TD></TR></TBODY>';
    echo '</TABLE>';

    echo '</DIV>';
  }

} else {
	
error_box('Uh oh','An error has occurred.');		
}

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


function error_box($title,$msg) {
  global $v1, $v2;
  echo '<DIV id=wrapper style="DISPLAY: none">';
  echo '<TABLE height="100%" width="100%">';
  echo '<TBODY><TR><TD vAlign=center align=middle>';
    echo '<TABLE cellSpacing=0 cellPadding=0 border=0><TBODY>';
    echo '<TR><TD width=35><IMG height=40 src="images/Item_Game_Box_s_01.gif" width=35></TD>';
    echo '<TD class=white style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; PADDING-TOP: 5px" vAlign=top align=middle background="images/Item_Game_Box_s_02.gif"><STRONG>'.$title.'</STRONG></TD>';
    echo '<TD width=35><IMG height=40 src="images/Item_Game_Box_s_03.gif" width=35></TD></TR>';
    echo '<TR>';
    echo '<TD background="images/Item_Game_Box_s_04.gif">&nbsp;</TD>';
    echo '<TD class=orange style="PADDING-BOTTOM: 20px; PADDING-TOP: 20px" align=middle width=200 background="images/Item_Game_Box_s_05.gif" height=50><STRONG><SPAN style="WIDTH: 280px">'.$msg.'</SPAN></STRONG></TD>';
    echo '<TD background="images/Item_Game_Box_s_06.gif">&nbsp;</TD>';
    echo '</TR>';
    echo '<TR>';
    echo '<TD background="images/Item_Game_Box_s_04.gif">&nbsp;</TD>';
    echo '<TD class=orange style="PADDING-BOTTOM: 20px; PADDING-TOP: 20px" align=middle background="images/Item_Game_Box_s_05.gif" height=20>';
    echo '<IMG style="CURSOR: pointer" onclick="javscript:location.href=\'./webshop.php?v1='.$v1.'&v2='.$v2.'\'" alt="Close" src="images/Btn_Close.gif" border=0>';
    echo '</TD>';
    echo '<TD background="images/Item_Game_Box_s_06.gif">&nbsp;</TD>';
    echo '</TR>';
    echo '<TR>';
    echo '<TD><IMG src="images/Item_Game_Box_s_07.gif" width=35></TD>';
    echo '<TD background="images/Item_Game_Box_s_08.gif">&nbsp;</TD>';
    echo '<TD><IMG src="images/Item_Game_Box_s_09.gif" width=35></TD>';
    echo '</TR></TBODY>';
    echo '</TABLE>';
  echo '</TD></TR></TBODY>';
  echo '</TABLE>';
  echo '</DIV>';			
}


function query_db($query,$caller='unknown') {
  global $link;
  hardlog($query);
  $r=mssql_query($query);
  return $r;
}

function hardlog($text) {
  $h=fopen('hardlog.txt','a');
  if (is_writable('hardlog.txt')) {
    if (!$h=fopen('hardlog.txt','a')) {
      die('Error opening hardlog.txt file, check permissions.');
    }
    if (fwrite($h,"[".date("H:i:s G:i:s")."] ".$text."\n")===false) {
      die('Error writing to hardlog.txt, check permissions.');
    }
    fclose($h);
  } else {
    die('Error, hardlog.txt is not writable.');
  }
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