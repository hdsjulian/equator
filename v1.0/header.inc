<?

$sql = "select displays, hits from $nodes_t";
$result = mysql_db_query($database,$sql);
$num_rows = mysql_num_rows($result);

$hits_sum = 0;
$displays_sum = 0;
$row=0;
while ($row < $num_rows):
    $hits_cnt = mysql_result($result,$row,"hits");
    $displays_cnt = mysql_result($result,$row,"displays");
    $hits_sum = $hits_sum + $hits_cnt;
    $displays_sum = $displays_sum + $displays_cnt;
    $row++;
endwhile;


echo "<table width=100%><tr>";

echo "<td align=left bgcolor=$sys_color >";
echo "<nobr>";

$status = get_status(); if ($status != "anon"):
	echo "<tt><a href=user_data.php3?select=id_place_data>$PHP_AUTH_USER</a></font>";
else:
	echo "$PHP_AUTH_USER";
endif;

echo "</nobr>";
echo "</td>";

echo "<td bgcolor=$sys_color align=center>";
echo "<nobr>";
echo "<font size=+0><tt>";
echo "<a href=info/info.html>INFO</a> ";
echo "<a href=map.php3>MAP</a> ";
echo "<a href=news.php3>NEWS</a> ";
echo "<a href=chat/>CHAT</a> ";
echo "</nobr>";
echo "</td>";

echo "<td bgcolor=$sys_color align=center>";
echo "<nobr>";
echo "<font size=+0><tt>";
$qstr = "var=var";
echo "<a href=$PHP_SELF?$QUERY_STRING target=_parent>[1]</a> ";
echo "<a href=frames.php3?doc=$PHP_SELF&$QUERY_STRING&multi=V>[V]</a> ";
echo "<a href=frames.php3?doc=$PHP_SELF&$QUERY_STRING&multi=H>[H]</a>";
echo "</nobr>";
echo "</td>";


echo "<td bgcolor=$sys_color align=right>";
echo "<nobr>";
echo "<font size=+0><tt>";
echo "$num_rows $hits_sum:$displays_sum";
echo "</nobr>";
echo "</td>";

echo "</td></tr></table>";

?>
