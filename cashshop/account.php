<?php

if (!isset($_SESSION['v1']) || !isset($_SESSION['v2']) || !is_numeric($_SESSION['v1']) || !ctype_alnum($_SESSION['v2']) || !defined('IN_CP')) {
  session_destroy();
  die('Hack attempt.');
}

// op 1 = warehouse -> bank
// op 2 = bank -> warehouse

$is_gm=false;
$op=0;
if (isset($_REQUEST['op'])) $op=$_REQUEST['op'];
if ($op>0 && ALLOW_BANK==false) die('Hack attempt.');

$r=mssql_query('select * from '.DB_GAM.'.dbo.cabal_character_table where CharacterIdx between '.$_SESSION['v1'].' * 8 and '.$_SESSION['v1'].' * 8 + 5 and login>0');
if (mssql_num_rows($r)>0) $is_online=true;
$r=mssql_query('select * from '.DB_GAM.'.dbo.cabal_character_table where CharacterIdx between '.$_SESSION['v1'].' * 8 and '.$_SESSION['v1'].' * 8 + 5 and nation=3');
if (mssql_num_rows($r)>0) $is_gm=true;  

$r=mssql_query("exec ".DB_GAM.".dbo.cabal_tool_getwarehousealz '".$_SESSION['v1']."'");
$row = mssql_fetch_row($r);
$walz=$row[1];
$r=mssql_query("exec ".DB_CSH.".dbo.getbankalz '".$_SESSION['v1']."'");
$row = mssql_fetch_row($r);
$balz=$row[1];

$q="select * from ".DB_ACC.".dbo.cabal_auth_table where UserNum='".$_SESSION['v1']."'and AuthKey='".$_SESSION['v2']."'";
$r=mssql_query($q);
$row = mssql_fetch_row($r);

if ($op>0) {
  switch($op) {
    case '1':
      $transferalz=$_REQUEST['alz'];
      if ($transferalz>$walz) {
        error_box('Alz transfer failed','You do not have enough Alz in your warehouse.');
        exit;
      }
      $newwalz=$walz-$transferalz;
      $newbalz=$balz+$transferalz;
      $r=mssql_query("exec ".DB_GAM.".dbo.cabal_tool_setwarehousealz '".$_SESSION['v1']."','".$newwalz."',0");
      $r=mssql_query("exec ".DB_CSH.".dbo.setbankalz '".$_SESSION['v1']."','".$newbalz."'");
      error_box('Alz transfer successful','Alz was successfully transferred to your bank.');
      break;
    case '2':
      $transferalz=$_REQUEST['alz'];
      if ($transferalz>$balz) {
        error_box('Alz transfer failed','You do not have enough Alz in your bank.');
        exit;
      }
      $newwalz=$walz+$transferalz;
      $newbalz=$balz-$transferalz;
      $r=mssql_query("exec ".DB_GAM.".dbo.cabal_tool_setwarehousealz '".$_SESSION['v1']."','".$newwalz."',0");
      $r=mssql_query("exec ".DB_CSH.".dbo.setbankalz '".$_SESSION['v1']."','".$newbalz."'");
      error_box('Alz transfer successful','Alz was successfully transferred to your warehouse.');
      break;  	    	  
  }	
} else {
  box_top($balz,$is_gm);
  echo '<table width="554" cellspacing="0" cellpadding="2" style="border:#333333 1px solid" border="0">';
  echo '<tr><td colspan="2" align="center" style="background-color:#333333" class="white"><strong>Account details</strong></td></tr>';
  echo '<tr><td width="120" style="padding-left:8px;border-bottom:#333333 1px dashed" class="cloud2"><strong>Account name</strong></td><td style=";border-bottom:#333333 1px dashed">'.$row[1].'</td></tr>';
  echo '<tr><td style="padding-left:8px;border-bottom:#333333 1px dashed" class="cloud2"><strong>Joined</strong></td><td style=";border-bottom:#333333 1px dashed">'.$row[12].'</td></tr>';
  echo '<tr><td style="padding-left:8px" class="cloud2"><strong>Total Play Time</strong></td><td>'.round($row[7]/60,2).' hours</td></tr>';
  echo '</table><br />';
  
  echo '<table width="554" cellspacing="0" cellpadding="2" style="border:#333333 1px solid" border="0">';
  echo '<tr><td colspan="3" align="center" style="background-color:#333333" class="white"><strong>Alz</strong></td></tr>';
  echo '<tr>';
    echo '<td width="120" style="padding-left:8px;border-bottom:#333333 1px dashed" class="cloud2"><strong>Warehouse Alz</strong></td>';
    echo '<td style="border-bottom:#333333 1px dashed">'.$walz.'</td>';
    if (!$is_online && ALLOW_BANK==true) {
      echo '<form method="post" action="'.PAGE_INDEX.'?action=despoit&op=1"><td style="border-bottom:#333333 1px dashed"><input type="text" size="8" name="alz" class="editbox">&nbsp;<input type="submit" name="deposit" value="Deposit" class="button"></td></form>';
    } else {
      echo '<td style="border-bottom:#333333 1px dashed">&nbsp;</td>';
    }
  echo '</tr>';
  echo '<tr>';
    echo '<td style="padding-left:8px; border-bottom:#333333 1px dashed"  class="cloud2"><strong>Bank Alz</strong></td>';
    echo '<td width="120" style="border-bottom:#333333 1px dashed">'.$balz.'</td>';
    if (!$is_online && ALLOW_BANK==true) {
      echo '<form method="post" action="'.PAGE_INDEX.'?action=despoit&op=2"><td style="border-bottom:#333333 1px dashed"><input type="text" size="8" name="alz" class="editbox">&nbsp;<input type="submit" name="withdraw" value="Withdraw" class="button"></td></form>';
    } else {
      echo '<td style="border-bottom:#333333 1px dashed">&nbsp;</td>';
    }  
  echo '</tr>';
  if (ALLOW_BANK==false) {
      echo '<tr><td align="center" class="mini" colspan="3">Bank transfer disabled.</td></tr>';
  } else {
      echo '<tr><td align="center" class="mini" colspan="3">You can only transfer Alz when not online.</td></tr>';
  }
  echo '</table>';
  box_bottom();  
}

function error_box($title,$msg) {
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
    echo '<IMG style="CURSOR: pointer" onclick="javscript:location.href=\'./index.php?action=account&v1='.$_SESSION['v1'].'&v2='.$_SESSION['v2'].'\'" alt="Close" src="images/Btn_Close.gif" border=0>';
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
}
?>
