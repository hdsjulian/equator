<?
include "check.inc";
include "settings.inc";
echo "<head> <title> Equator 1.0: Script </title> </head>";
echo $body_sets;

include "functions.inc";
include "header.inc";

$node_in = $node;

echo "<table width=300>";
echo "<tr><td>";

if ($action == "insert"):
	display_node($object, $object, "single");
	echo "<tr><td bgcolor=$info_color> <p>NEW NODE GOES HERE ... <p></td>";
	echo "</tr><td>";
	display_node($node_in, $object, "single");
else:
	display_node($node_in, $object, "single");
	
endif;

echo "</td></tr>";
echo "</table>";

if ($action == "update"):

	echo "<form action=script.php3?node=$node_in&action=update method=post>\n";
	
	echo "<input type=submit value=\"Update this Node\">\n";
	echo "<p>";
?>

	<? $body = get_value ($nodes_t, $node_in, "body");?>
	<? $tag = get_value ($nodes_t, $node_in, "tag");?>
	<? $timing = get_value ($nodes_t, $node_in, "timing");?>
	
	<INPUT TYPE=text size=20 maxlength=20 NAME="tag" value="<? echo $tag?>">
	TAG: abstract literal or keyword <br>
	<INPUT TYPE=text size=5 maxlength=4 NAME="timing" value="<? echo $timing?>">
	TIMING: display time in 10th of seconds (5 sec. = 50)
	<br>
	
	<textarea name=body rows=15 cols=80 wrap=yes ><? echo $body?></textarea>
	
	<p>
	</form>
	
<? endif?>

<? if ($action == "add"): ?>

	<table>
	<tr><td>
	
	<form action=script.php3?node=<? echo "$node_in";?>&action=add method=post>
	<input type=submit value="Add this Node to <? echo $node_in?>"><br>
	<input type="checkbox" name="email" value="yes">
	send content to equator@king.dom.de
	</td></tr>
	</table>	
	<p>
	
	<INPUT TYPE=text size=20 maxlength=20 NAME="tag">
	TAG: abstract literal or keyword <br>
	<INPUT TYPE=text size=5 maxlength=4 NAME="timing">
	TIMING: display time in 10th of seconds (5 sec. = 50)
	<br>
	
	<textarea name=body rows=15 cols=80 wrap=yes ></textarea>
	
	
	</form>
	

<? endif?>

<? if ($action == "insert"): ?>

	<table>
	<tr><td>
	
	<form action=script.php3?node=<? echo $node_in?>&object=<? echo $object?>&action=insert method=post>
	<input type=submit value="Insert this Node between <? echo $object?> and <? echo $node_in?>"><br>
	<input type="checkbox" name="email" value="yes">
	send content to equator@king.dom.de
	</td></tr>
	</table>	
	<p>
	
	<INPUT TYPE=text size=20 maxlength=20 NAME="tag">
	TAG: abstract literal or keyword <br>
	<INPUT TYPE=text size=5 maxlength=4 NAME="timing">
	TIMING: display time in 10th of seconds (5 sec. = 50)
	<br>
	
	<textarea name=body rows=15 cols=80 wrap=yes ></textarea>
		
	</form>
	
<? endif?>

<? if ($action == "delete"): ?>
	<?
	$parents_r = get_parents($node);
	echo "node = $node";
	$one_parent = mysql_result($parents_r,0,"connections.origin");
	echo "one_parent = $one_parent";
	?>
	
	<form action=script.php3?node=<? echo $node_in?>&one_parent=<? echo $one_parent?>&action=delete method=post>
		
	<input type=submit value="Delete this Node">
	
	</form>
	
<? endif?>

<font size=+2><a href=upload.php3 target=ext>Upload Files ></a></font> from a seperate window. 
