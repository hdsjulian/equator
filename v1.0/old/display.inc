<?

echo "<table>";
echo "<tr valign=top>";

echo "<td width=33%>";

	/* get parents */
	
	$parents_r = get_parents($node_in);
	$parents_nr = mysql_numrows($parents_r);
	
	/* display parents */
		
	$row = 0;
	while ($row < $parents_nr);
		$node_display = mysql_result($parents_r,$row,"connections.origin");
		display_node($node_display, $node_in, "parent");
		echo "<br>";
		$row++;
	endwhile;
	
echo "</td>";
echo "<td width=33%>";

	/* display object node */
	
	display_node($node_in, $node_in "object");
	
echo "</td>";
echo "<td width=33%>";

	/* get children */
	
	$children_r = get_children($node_in);
	$children_nr = mysql_numrows($children_r);
	
	/* display children */
	
	$row = 0;
	while ($row < $children_nr);
		$node_display = mysql_result($children_r,$row,"connections.target");
		display_node($node_display, $node_in, "child");
		echo "<br>"; 
		$row++;
	endwhile;
	
echo "</td>";
echo "</tr>";
echo "</table>";

>
