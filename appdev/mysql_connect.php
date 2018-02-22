<?php
$dbc=mysqli_connect('localhost','root','p@ssword','oulcdb');

if (!$dbc) {
 die('Could not connect: '.mysql_error());
}

?>