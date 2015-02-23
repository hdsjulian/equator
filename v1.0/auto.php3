<?
include "check.inc";
include "settings.inc";
include "functions.inc";

$debug = 1;

/* if no node select a default one */

if (!$this_node && !$next_node):

		$this_node = get_movie();

endif;

if ($this_node):
	$next_node = $this_node;
	
else:

	$node_in = $next_node;

	/* get children */
	
	$children_r = get_children($node_in);
	$children_nr = mysql_num_rows($children_r);

	if ($children_nr == 0):
		
		$next_node = get_movie();

	elseif ($children_nr == 1):	
		$next_node = mysql_result($children_r,0,"connections.target");
	
	elseif ($children_nr > 1):	
		$tmp = rand() % $children_nr;
		$next_node = mysql_result($children_r,$tmp,"connections.target");
	endif;
endif;

/* get the timing */

$sql = "select timing from nodes where _index = $next_node";
$result = mysql_db_query($database,$sql);
$timing = mysql_result($result,0,"timing") * 100;

echo "<head> <title> Eq 1.0: Story [node $next_node]</title> </head>\n";
?>
<SCRIPT language=JavaScript>
function load_Next() {
open("auto.php3?next_node=<?echo $next_node?>", "_self");
}
</SCRIPT>
<?
echo "<BODY onLoad=\"setTimeout('load_Next()', $timing)\" bgcolor=000000 text=eeeeee link=99ff99 vlink=99ff99\n>";
echo "<table cellpadding=0 cellspacing=5 border=0 width=100% height=100%\n>";

if ($children_nr == 0):
	echo "<tr><td>\n";
	echo "on to &Oslash;therLands -><p>\n";
	echo "</td></tr>\n";
endif;

echo "<tr valign=top><td>\n";
include "header.inc";
echo "</td></tr>\n";

echo "<tr valign=center> <td align=center>";

	display_node($next_node, $node_in, "movie");

/* raise the count */

$displays = get_value($nodes_t, $next_node, "displays") + 1;

$sql = "update nodes set displays = $displays where _index = $next_node";
mysql_db_query($database, $sql);


echo "</td></tr></table>";
?>

