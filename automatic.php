<?php
  
$loc='C:';
//$loc='F:\English Songs';
$dir = new RecursiveDirectoryIterator($loc,
    FilesystemIterator::SKIP_DOTS);
global $dir1,$k,$file,$fp;
// Flatten the recursive iterator, folders come before their files
$it  = new RecursiveIteratorIterator($dir,
    RecursiveIteratorIterator::SELF_FIRST);
$db=mysql_connect("localhost","root","");
mysql_select_db("maths",$db);
$f=0;

// Maximum depth is 1 level deeper than the base folder
$it->setMaxDepth(5 );
echo '<html><body><form name="form1" method="POST" action="fileread.php"><table border=2>';
// Basic loop displaying different messages based on file or folder
foreach ($it as $fileinfo) 
{
    if ($fileinfo->isDir()) 
	{
	echo "<br>";
      //  printf("Folder - %s\n", $fileinfo->getFilename());
		$dir1=$fileinfo->getFilename();
		//echo $dir1;
    } 
	elseif ($fileinfo->isFile())
	{
	echo "<br>";
       // printf("subpath%s ", $it->getSubPath());
		//echo "<br>";
		//printf("filename %s",$fileinfo->getFilename());
	$k=$it->getSubPath();
		$file=$fileinfo->getFilename();
	}
	
	if($dir1=='' || $k=='')
	{
	//echo "loop1<br>";
	$fp="$loc\\$file";
	//echo $fp;
	}
	else
	{
	//echo "loop2<br>";
	$fp="$loc\\$k\\$file";
	//echo $fp;
	}
	$fpx=addslashes($fp);
	$query2="insert into links(link,file) values('$fpx','$file')";
$result2=mysql_query($query2,$db)or die("cannot");

echo '<tr><td>'.$fp.'<td><input type="checkbox" name="file[]" value=" '.$fp.' "><td>
<input type="submit" name="submit">';
		
}
?>