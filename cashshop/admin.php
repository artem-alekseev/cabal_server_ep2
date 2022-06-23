<?php

include('config.php');

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >';
echo '<HTML><HEAD>';
echo '<meta content="JavaScript" name="vs_defaultClientScript">';
echo '<link title="style" href="shopstyle.css" type="text/css" rel="stylesheet">';	
echo '<meta http-equiv="Content-Type" content="text/html; charset=US">';
echo '<title>'.PAGE_TITLE.'</title></head>';

if (ini_get('register_globals')!=0) {
	echo 'The "register_globals" setting in your php.ini is on. This is a security problem and must be fixed.';
	die;
}

$v=split('&',$_SERVER['QUERY_STRING']);
$v1=substr($v[0],3,strlen($v[0])-3);
$v2=substr($v[1],3,strlen($v[1])-3);
  
if (!is_numeric($v1)) die('Hack attempt');
if (!ctype_alnum($v2)) die('Hack attempt');

$action=0;
$target=0;
if (isset($_REQUEST['a'])) {
  $action=$_REQUEST['a'];
  if (!ctype_digit($action)) $action=0;
}
if (isset($_REQUEST['b'])) {
  $target=$_REQUEST['b'];
  if (!ctype_digit($target)) $target=0;
}
if (isset($_REQUEST['c'])) {
  $cat=$_REQUEST['c'];
  if (!ctype_digit($cat)) $cat=1;
} else {
	$cat=1;
}
$link = mssql_connect(DB_ADDR, DB_USER, DB_PASS);
if (!$link) die('Could not connect to MSSQL database.');
$r=mssql_query('select * from '.DB_GAM.'.dbo.cabal_character_table where CharacterIdx between '.$v1.' * 8 and '.$v1.' * 8 + 5 and nation=3');
if (mssql_num_rows($r)==0) die('Hack attempt - None of your chars are GMs.');

if ($action==0) {
  $r=mssql_query('select * from '.DB_CSH.'.dbo.ShopItems where category="'.$cat.'" order by alz desc');

  echo '<div align="center">';

  echo '<table width="800" border="0">';
  echo '<tr><td background="images/Item_Game_Box_01.gif" width="800" height="25" colspan="5"></td></tr>';
  echo '<tr>';
    echo '<td align="center"><a href="admin.php?v1='.$v1.'&v2='.$v2.'&c=1">Category 1 ('.$cats[1].')</a></td>';
    echo '<td align="center"><a href="admin.php?v1='.$v1.'&v2='.$v2.'&c=2">Category 2 ('.$cats[2].')</a></td>';
    echo '<td align="center"><a href="admin.php?v1='.$v1.'&v2='.$v2.'&c=3">Category 3 ('.$cats[3].')</a></td>';
    echo '<td align="center"><a href="admin.php?v1='.$v1.'&v2='.$v2.'&c=4">Category 4 ('.$cats[4].')</a></td>';
    echo '<td align="center"><a href="admin.php?v1='.$v1.'&v2='.$v2.'&c=5">Category 5 ('.$cats[5].')</a></td>';
  echo '</tr>';
  echo '<tr><td align="center" class="Orange" colspan="5"><a href="admin.php?v1='.$v1.'&v2='.$v2.'&a=1&c='.$cat.'"><strong>Add item</strong></a>&nbsp;|&nbsp;<a href="webshop.php?v1='.$v1.'&v2='.$v2.'"><strong>View cash shop</strong></a></td></tr>';
  echo '</table>';

  echo '<table width="800" border="0" style="background-color:#000000;border-width:1px;border-color:#ffffff">';
  echo '<tr><td>Action</td><td>Item</td><td>Alz cost</td><td>Category</td><td>Available</td></tr>';
    if (mssql_num_rows($r)==0) {
	 //echo 'No items found.';
    } else {
 	  for ($i=1;$i<=mssql_num_rows($r);$i++) {
		$row = mssql_fetch_row($r);
		echo '<tr style="background-color:#333333">';
		echo '<td style="padding-left:4px"><a href="admin.php?v1='.$v1.'&v2='.$v2.'&a=3&b='.$row[0].'"><span class="orange"><strong>Edit</strong></span></a>&nbsp;|&nbsp;<a href="admin.php?v1='.$v1.'&v2='.$v2.'&a=2&b='.$row[0].'"><span class="orange"><strong>Delete</strong></span></a></td>';
		echo '<td style="padding-left:4px"><span class="cloud2"><strong>'.$row[1].'</strong></span><br /><span class="mini">'.$row[2].'</span></td><td style="padding-left:4px">'.$row[8].'</td><td style="padding-left:4px">'.$row[9].'</td><td style="padding-left:4px">'.$row[10].'</td>';
		echo '</tr>';
		mssql_next_result($r);
	  }	  
    }
  echo '</table>';
}

// Delete
if ($action==2) {
  $r=mssql_query('delete from '.DB_CSH.'.dbo.ShopItems where Id="'.$target.'"');
  echo '<div align="center"><a href="admin.php?v1='.$v1.'&v2='.$v2.'">Done</a></div>';
}

// Edit
if ($action==3) {
  $r=mssql_query('select * from '.DB_CSH.'.dbo.ShopItems where Id="'.$target.'"');
  $row = mssql_fetch_row($r);
  $iname=$row[1];
  $idesc=$row[2];
  $iidx=$row[3];
  $idur=$row[4];
  $iopt=$row[5];
  $iimage=$row[6];
  $ialz=$row[8];
  $icat=$row[9];
  $iavail=$row[10];
  echo '<table width="540" border="0"><form method="post" action="admin.php?v1='.$v1.'&v2='.$v2.'&a=5&b='.$target.'">';
  echo '<tr><td align="center" colspan="6">Edit item</td></tr>';
  echo '<tr><td align="right">Item name:&nbsp;</td><td colspan="5" align="right"><input type="text" name="item_name" size="64" value="'.$iname.'"></td></tr>';
  echo '<tr><td align="right">Item Description:&nbsp;</td><td colspan="5" align="right"><textarea name="item_desc" rows="3" cols="49">'.$idesc.'</textarea></td></tr>';
  echo '<tr><td align="right">Item Idx:&nbsp;</td><td align="right"><input type="text" name="item_id" size="10" value="'.$iidx.'"></td><td align="right">ItemOpt:&nbsp;</td><td align="right"><input type="text" name="item_opt" size="10" value="'.$iopt.'"></td><td align="right">DurationIdx:&nbsp;</td><td align="right"><input type="text" name="item_dur" size="3" value="'.$idur.'"></td></tr>';
  echo '<tr><td align="right">Item image:&nbsp;</td><td align="right"><input type="text" name="item_image" size="10" value="'.$iimage.'"></td></tr>';
  echo '<tr><td align="right">Item Alz cost:&nbsp;</td><td align="right"><input type="text" name="item_alz" size="10" value="'.$ialz.'"></td></tr>';
  echo '<tr><td align="right">Item Category:&nbsp;</td><td align="right"><input type="text" name="item_cat" size="10" value="'.$icat.'"></td></tr>';
  echo '<tr><td align="right">Item Available:&nbsp;</td><td align="right"><input type="text" name="item_avail" size="10" value="'.$iavail.'"></td><td align="right"><input type="submit" value="Save"></tr>';
  echo '</form></table>';
}

// Add
if ($action==1 ) {
	echo '<table width="540" border="0"><form method="post" action="admin.php?v1='.$v1.'&v2='.$v2.'&a=4">';
	echo '<tr><td align="center" colspan="6">Add item</td></tr>';
	echo '<tr><td align="right">Item name:&nbsp;</td><td colspan="5" align="right"><input type="text" name="item_name" size="64"></td></tr>';
	echo '<tr><td align="right">Item Description:&nbsp;</td><td colspan="5" align="right"><textarea name="item_desc" rows="3" cols="49"></textarea></td></tr>';
	echo '<tr><td align="right">Item Idx:&nbsp;</td><td align="right"><input type="text" name="item_id" size="10"></td><td align="right">ItemOpt:&nbsp;</td><td align="right"><input type="text" name="item_opt" size="10"></td><td align="right">DurationIdx:&nbsp;</td><td align="right"><input type="text" name="item_dur" size="3"></td></tr>';
	echo '<tr><td align="right">Item image:&nbsp;</td><td align="right"><input type="text" name="item_image" size="10"></td></tr>';
	echo '<tr><td align="right">Item Alz cost:&nbsp;</td><td align="right"><input type="text" name="item_alz" size="10"></td></tr>';
	echo '<tr><td align="right">Item Category:&nbsp;</td><td align="right"><input type="text" name="item_cat" size="10" value="'.$cat.'"></td></tr>';
	echo '<tr><td align="right">Item Available:&nbsp;</td><td align="right"><input type="text" name="item_avail" size="10"></td><td align="right"><input type="submit" value="Save"></tr>';
	echo '</form></table>';
}

// Save new
if ($action==4 ) {
  $iname=$_REQUEST['item_name'];
  $idesc=$_REQUEST['item_desc'];
  $iidx=$_REQUEST['item_id'];
  $iopt=$_REQUEST['item_opt'];
  $idur=$_REQUEST['item_dur'];
  $iimage=$_REQUEST['item_image'];
  $ialz=$_REQUEST['item_alz'];
  $icat=$_REQUEST['item_cat'];
  $iavail=$_REQUEST['item_avail'];
  $r=mssql_query('insert into '.DB_CSH.'.dbo.ShopItems values ("'.$iname.'","'.$idesc.'","'.$iidx.'","'.$idur.'","'.$iopt.'","'.$iimage.'",0,"'.$ialz.'","'.$icat.'","'.$iavail.'")');
  echo '<div align="center"><a href="admin.php?v1='.$v1.'&v2='.$v2.'&">Done</a></div>';
}

// Update existing
if ($action==5 ) {
  $iname=$_REQUEST['item_name'];
  $idesc=$_REQUEST['item_desc'];
  $iidx=$_REQUEST['item_id'];
  $iopt=$_REQUEST['item_opt'];
  $idur=$_REQUEST['item_dur'];
  $iimage=$_REQUEST['item_image'];
  $ialz=$_REQUEST['item_alz'];
  $icat=$_REQUEST['item_cat'];
  $iavail=$_REQUEST['item_avail'];
  $r=mssql_query('update '.DB_CSH.'.dbo.ShopItems set name="'.$iname.'",description="'.$idesc.'",itemidx="'.$iidx.'",durationidx="'.$idur.'",itemopt="'.$iopt.'",image="'.$iimage.'",alz="'.$ialz.'",category="'.$icat.'",available="'.$iavail.'" where id="'.$target.'"');
  echo '<div align="center"><a href="admin.php?v1='.$v1.'&v2='.$v2.'">Done</a></div>';
}



?>