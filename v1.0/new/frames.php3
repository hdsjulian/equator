<?include "check.inc";?>

<HTML>
<HEAD>
<TITLE>Equator 1.0: Parallel</TITLE>
</HEAD>

<?
$qstr = "var=var";

if ($multi == "H"):
	echo "<frameset border=1 rows=\"50%,50%\">";
		echo "<frame src=$doc?$QUERY_STRING>";
		echo "<frame src=$doc?$QUERY_STRING>";
	echo "</frameset>";
endif;
?>
<?
if ($multi == "V"):
	echo "<frameset border=1 cols=\"50%,50%\">";
		echo "<frame src=$doc?$QUERY_STRING>";
		echo "<frame src=$doc?$QUERY_STRING>";
	echo "</frameset>";
endif;
?>
	
	
<?
if ($multi == "4"):
	echo "<frameset border=1 cols=\"50%,*\">";
		echo "<frameset border=0 rows=\"50%,*\">";
			echo "<frame src=auto.php3?mode=follow&dir=117&id=$next_id>";
			echo "<frame src=auto.php3?mode=follow&dir=117&id=$next_id>";
		echo "</frameset>";
		echo "<frameset border=0 rows=\"50%,*\">";
			echo "<frame src=auto.php3?mode=follow&dir=117&id=$next_id>";
			echo "<frame src=auto.php3?mode=follow&dir=117&id=$next_id>";
		echo "</frameset>";
	echo "</frameset>";
endif;
?>
	
	
</html>
