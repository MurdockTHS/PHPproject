<?php
ob_start(); //this turns on output buffering
session_start();

$timezone = date_default_timezone_set("America/Los_Angeles");
$con = mysqli_connect("localhost","root", "", "mssabuilderapp");

if(mysqli_connect_errno()) 
{
	echo "Failed to connect: " . mysqli_connect_errno();
}

?>