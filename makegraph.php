<?php
global $db,$source,$destination,$q2,$r2,$e;
 $parsed=array();
 //global $parsed="";
 $db=mysql_connect("localhost", "root", "");
    mysql_select_db("phpdb");
	$q1=mysql_query("Select * from sitegraph");
	$hop=0;
	while($r=mysql_fetch_array($q1))
	{
	$hop=1;
	
	//echo $r['source']."<br>";
	$a=$r['source'];
	$b=$r['destination'];
	if(!in_array($a,$parsed))
	{
	recur($a,$b);
	}
	//array_push($parsed, $a);
	}
	
	function recur($source,$destination)
	{
	//echo $source."<br>".$destination;
	$d=addslashes($destination);
	$hop=$hop+1;
	
	echo $d."<br>";
	$q2=mysql_query("select destination from sitegraph where source='$d'")or die("cannot");
	while($r2=mysql_fetch_array($q2))
	{
	$e=$r2['destination'];
	echo $source."------------->>>    ".$e."--------->>>   ".$hop."<br>";
	//mysql_query("INSERT INTO sitegraph VALUES ('$source', '$e','$hop')");
	}
	//recur($source,$e);
		
	}
	
	foreach($parsed as $p)
	echo $p."<br>";
	?>