<?php

$num_acc=0;
$num_cha=0;
$num_onl=0;
$r=mssql_query('select count (*) from '.DB_ACC.'.dbo.cabal_auth_table');
$num_acc=mssql_result($r,0,0);
$r=mssql_query('select count (*) from '.DB_ACC.'.dbo.cabal_auth_table where Login=1');
$num_onl=mssql_result($r,0,0);
$r=mssql_query('select count (*) from '.DB_GAM.'.dbo.cabal_character_table');
$num_cha=mssql_result($r,0,0);

echo '<p>There are currently <span style="font-size:16px;font-weight:bold">'.$num_onl.'</span> people online right now.</p>';
echo '<p>Registered accounts: <span style="font-size:16px;font-weight:bold">'.$num_acc.'</span> | Characters created: <span style="font-size:16px;font-weight:bold">'.$num_cha.'</span></p>';

echo '<p style="font-size:24px;font-weight:bold">Account registration</p>';

echo '<p>Username and password must be minimum 6 chars, letters and numbers only.</p>';

echo '<form method="post" action="'.$_PHP['self'].'">';
echo '<table cellspacing="4" cellpadding="0" border="0">';
echo '<tr><td align="right">Login:&nbsp;</td><td><input type="text" name="uname" class="editbox"></td></tr>';
echo '<tr><td align="right">Pass:&nbsp;</td><td><input type="password" name="pass" class="editbox"></td></tr>';
echo '<tr><td align="right">Confirm pass:&nbsp;</td><td><input type="password" name="pass2" class="editbox"></td></tr>';
echo '<tr><td colspan="2" align="right"><input type="submit" value="Register account" class="button"></td></tr>';
echo '</table>';
echo '</form>';

echo '<br /><span style="font-weight:bold">Website:</span>&nbsp;<a href="'.LINK_WSITE.'">'.NAME_WSITE.'</a><br />';
echo '<span style="font-weight:bold">Forums:</span>&nbsp;<a href="'.LINK_FORUM.'">'.NAME_FORUM.'</a><br />';

$uid='';
$pass='';
$failed=false;

if (isset($_POST['uname'])) {
  if (!ctype_alnum($_POST['uname']) || strlen($_POST['uname'])<6) {
	  $failed=true;
	  echo '<p class="errortext">Invalid username. Minimum 6 characters, letters and numbers only.</p> ';
  } else {
	$uid=$_POST['uname'];	
  }
}

if (isset($_POST['pass'])) {
  if (!ctype_alnum($_POST['pass']) || strlen($_POST['pass'])<6) {
	  $failed=true;
	  echo '<p class="errortext">Invalid password. Minimum 6 characters, letters and numbers only.</p> ';
  } else {
	$pass=$_POST['pass'];	
  }
}

if (isset($_POST['pass2'])) {
  if (!ctype_alnum($_POST['pass2'])) {
	  $failed=true;
  } else {
    if ($_POST['pass2']!=$_POST['pass']) {
	    $failed=true;
	    echo '<p class="errortext">The entered passwords do not match.</p> ';
    }
  }
}

if ($failed==true) {
  echo '<p class="errortext">Failed.</p> ';	
} else {
	
	if ($uid!='' && $pass!='') {
      $r=mssql_query('select count (*) from '.DB_ACC.'.dbo.cabal_auth_table where ID="'.$uid.'"');
      if (mssql_result($r,0,0)==0) {
        $r=mssql_query('exec '.DB_ACC.'.dbo.cabal_tool_registerAccount "'.$uid.'","'.$pass.'"');
        if ($r==false) {
  	      echo '<p class="errortext">Something went wrong :( </p>';
        } else {
  	      echo '<p class="goodtext">Account created successfully!</p>';
        }
        mssql_free_result($r);
        mssql_close($link);	
      } else {
	      echo '<p class="errortext">Logon name already used.</p> ';
      }
    }
}

?>