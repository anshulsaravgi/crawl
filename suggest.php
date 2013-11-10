<?php
// Fill up array with names

$db=mysql_connect("localhost","root","");
mysql_select_db("maths",$db)or die("cannot connect");;

	
	
if (!$db)
  {
  die('Could not connect: ' . mysql_error());
  }
	
$query = "SELECT * from links";
$result = mysql_query($query)or die("cannot get");
while($row = mysql_fetch_array($result))
{
$a[] = $row['file'];
}
//foreach($a as $ass)
//echo $ass;

$q=$_GET["q"];

//lookup all hints from array if length of q>0
if (strlen($q) > 0)
  {
  $hint="";
  for($i=0; $i<count($a); $i++)
    {
    if (strtolower($q)==strtolower(substr($a[$i],0,strlen($q))))
      {
  $hint=$a[$i];
$query6=mysql_query("Select * from links where file='$hint'")or die("cannot get");
while($info=mysql_fetch_array($query6))
{
echo "<br>";
echo $info['link']."  ";
echo $info['file']."  ";
echo "<br>";

//}        
      }


      }
    }
  }

if ($hint == "")
  {
  $response="no suggestion";
  }
?>
