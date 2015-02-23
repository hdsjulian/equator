<?
function get_movie(){

	global $database;
	
	/* select one from properties control=start */
	
	$sql = "select reference from properties where type = 'control' and value = 'start'";
	$result = mysql_db_query($database,$sql);
	$numrows = mysql_num_rows($result);
	$tmp = rand() % $numrows;
	$node = mysql_result($result,$tmp,"reference");
	
	return($node);
};

function get_status() {

	global $database, $PHP_AUTH_USER;
	
	$sql = "select status from users where alias = '$PHP_AUTH_USER'";
	$result = mysql_db_query($database,$sql);
	$status = mysql_result($result,0,"status");
	
	return($status);
};

function get_last_index ($table){ 

	global $database, $PHP_AUTH_USER;
	
	$sql = "select _index from $table where author = '$PHP_AUTH_USER' order by _index desc";
	$result = mysql_db_query($database,$sql);
	$last_index = mysql_result($result,0,"_index");
	
	return($last_index);
};

function get_new_index ($table) {

	global $database;
	
	$sql = "select _index from $table order by _index desc";
	$result = mysql_db_query($database,$sql);
	$new_index = mysql_result($result,0,"_index") + 1;
	
	return($new_index);
};

function get_parents ($node) {

	global $database;
	
	$sql = "select connections.origin, nodes.hits from connections, nodes where connections.target = $node and connections.target = nodes._index order by nodes.hits desc";
		
	$result = mysql_db_query($database,$sql);
	
	return($result);
};

function get_children ($node) {

	global $database;
	
	$sql = "select connections.target, nodes.hits from connections, nodes where connections.origin = $node and connections.origin = nodes._index order by nodes.hits desc";
		
	$result = mysql_db_query($database,$sql);
	
	return($result);
};

function can_delete ($node) {

	global $database;
	
	/* get parents */
	
	$parents_r = get_parents($node);
	$parents_nr = mysql_num_rows($parents_r);
	
	/* get children */
	
	$children_r = get_children($node);
	$children_nr = mysql_num_rows($children_r);
	
	if ($children_nr > 1 && $parents_nr > 1){
		return(0);
	} else {
		return(1);
	}
};

function get_value ($table, $index, $value) {

	global $database;
	
	$sql = "select $value from $table where _index = $index";
	$result = mysql_db_query($database,$sql);
	
	$out = mysql_result($result,0,$value);
	
	return($out);
};

function get_owner ($index_) {

	global $database;

	$sql = "select nodes._index, nodes.tag, nodes.created, identities.author from nodes, identities where identities._index = nodes.identity and nodes._index = $index_ ";
	$result = mysql_db_query("$database",$sql);
	$author = mysql_result($result,0,"identities.author");
		
return($author);
};


function display_node ($node, $object, $mode) {
	
	global $info_color, $PHP_SELF;

	$body = get_value ("nodes", $node, "body"); 
	$tag = get_value ("nodes", $node, "tag");
	
	if ($mode == "movie"){
		echo "<table width=275>\n";
	} else {
		echo "<table cellpadding=0 cellspacing=0>\n";
	}
		
	echo "<tr>";
	
	echo "<td>\n";
	echo "<font color=$info_color>$node $tag </font>\n";
	echo "</td>\n";
	
	echo "</tr>\n";
	echo "<tr>\n";
	
	echo "<td>\n";
	
	if ($mode == "movie")	echo "<font size=+1 FACE=\"Geneva,Areal,Helvetica\">\n";
	
	echo "$body\n";
	echo "</td>\n";
	
	echo "</tr>\n";
	echo "<tr>\n";
	
	echo "<td>\n";
	
	/*echo "<nobr>";*/
	if ($mode == "parent"){
		echo "<a href=auto.php3?this_node=$node&type=normal>< RUN</a> ";
		
		$status = get_status(); if ($status != "anon"){
			echo "<a href=edit.php3?node=$node&object=$object&action=add>add</a> ";
			echo "<a href=edit.php3?node=$object&object=$node&action=insert>ins</a> ";
			echo "<a href=edit.php3?node=$node&object=$object&action=update>upd</a> ";
			$tmp = can_delete($node); if ($tmp){
				echo "<a href=edit.php3?node=$node&object=$object&action=delete>del</a>";
			}
		} else {
			echo "<a href=user_mail.php3?action=mailto&doc=$PHP_SELF&$QUERY_STRING>add</a> ";
		}
		echo "<br><a href=$PHP_SELF?node=$node><font color=$info_color><nobr>< PREV</nobr></font></a>";
		
	} elseif($mode == "child"){
		echo "<a href=auto.php3?this_node=$node&type=normal>< RUN</a> ";
		
		$status = get_status(); if ($status != "anon"){
			echo "<a href=edit.php3?node=$node&object=$object&action=add>add</a> ";
			echo "<a href=edit.php3?node=$node&object=$object&action=insert>ins</a> ";
			echo "<a href=edit.php3?node=$node&object=$object&action=update>upd</a> ";
			$tmp = can_delete($node); if ($tmp){
				echo "<a href=edit.php3?node=$node&object=$object&action=delete>del</a> ";
			}
		} else {
			echo "<a href=user_mail.php3?action=mailto&node=$node>add</a> ";
		}
		
		echo "<a href=$PHP_SELF?node=$node> <font color=$info_color><br><nobr>NEXT ></nobr></font></a>";
		
	} elseif ($mode == "object"){
		echo "<a href=auto.php3?this_node=$node&type=normal>< RUN</a> ";
		
		$status = get_status(); if ($status != "anon"){
			echo "<a href=edit.php3?node=$node&object=$object&action=add>add</a> ";
			echo "<a href=edit.php3?node=$node&object=$object&action=update>upd</a> ";
			$tmp = can_delete($node); if ($tmp){
				echo "<a href=edit.php3?node=$node&object=$object&action=delete>del</a> ";
			}
		} else {
 			echo "<a href=user_mail.php3?action=mailto&node=$node>add</a> ";
		}
		
	} elseif ($mode == "single"){
		echo "<a href=script.php3?node=$node>< CANCEL</a> Back to this node in the script!";
	} elseif ($mode == "movie"){
		echo "<a href=script.php3?node=$node>< SCRIPT</a> ";
		
		$status = get_status(); if ($status == "anon"){
			echo "<a href=user_mail.php3?action=mailto&node=$node>add</a> ";
		}
		
	}	
	
	/*echo "</nobr>";*/
	
	echo "</td>\n";
	
	echo "</tr>\n";
	echo "</table>\n";

};
?>
