<?php

require 'DB.php';
$dbh = DB::connect('mysql://root:linhtinh@localhost/auth');
if (PEAR::isError($dbh))
{
die($dbh->getMessage());
}
else
{
print "Connected to 'mydb'";
}



$con = mysql_connect("localhost","root","linhtinh");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// some code
echo "connect ok" ;

mysql_close($con);




phpinfo();
?>
