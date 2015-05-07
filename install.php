<?php

if(!defined('ABSPATH')) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );	
}

if(false) {
	echo "<h1>SumHax requires PHP.</h1>";
	die;
	}
	
/* If not installed, install
 *
*/

if(file_exists(ABSPATH . "/install.me")) {
	if(isset($_POST['createdatabase'])) {
		$config = fopen(ABSPATH . "/config.php", "w");
		$config_param = array(
				"host"=>$_POST['host'],
				"user"=>$_POST['user'],
				"pass"=>$_POST['pass'],
				"db"=>$_POST['db'],
				"pre"=>$_POST['pre']);
		fwrite($config,"<?\n");
		foreach($config_param as $key=>$value) {
			fwrite($config,"$" . "$key=$" . "$value;\n");
		}
		fwrite($config,"?>\n");
		fclose($config);
		unlink(ABSPATH ."/install.me");
		echo "<h1>Done.  <a href='". ABSPATH ."'/index.php'>Click here to continue</a></h1>";
	}
	else {
?>
	<h1>Please enter the DB credentials</h1>
	<form method='post' action='<?php ABSPATH . "/install.php"?>'>
	<table>
	<tr><td>Database Host</td><td><input type='text' name='host' value='' /></td></tr>
	<tr><td>User Name</td><td><input type='text' name='user' value='' /></td></tr>
	<tr><td>Password</td><td><input type='text' name='pass' value='' /></td></tr>
	<tr><td>Database Name</td><td><input type='text' name='db' value='' /></td></tr>
	<tr><td>Database Prefix</td><td><input type='text' name='pre' value='' /></td></tr>
	<input type='hidden' name='createdatabase' value='good' />
	<tr><td></td><td><input type='submit' value='Connect' /></td></tr>
	</table>
	<input type='submit'>
	</form>
<?php 
	}
	die;
}

?>
<h1>SumHax is already installed.</h1>