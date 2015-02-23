<?
include "check.inc";
include "settings.inc";
echo "<head> <title>Eq 1.0: Script [node $node]</title> </head>";
echo $body_sets;

include "functions.inc";
include "header.inc";

$debug = 0;

/* if no node select a default one */

if ($node):
	$node_in = $node;
else:
	$node_in = get_movie();
endif;

$status = get_status();
if ($status != "anon"):
	
	/* EDIT FUNCTIONS */
	
	if ($action == "update"):
/*        $owner=get_owner($node_in);
	if ($owner==$PHP_AUTH_USER){ */
	
		$time = time();
		
		$sql = "update $nodes_t set body = '$body', edited = $time, tag = '$tag', timing = $timing where _index = $node_in";
	
		if ($debug):
			echo"$sql <p>";
		else:
			mysql_db_query($database,$sql);
		endif;
/*	}*/
		
	endif;
	
	if ($action == "add" || $action == "insert"):
	
		/* get identity */
		
		$sql = "select _index, timestamp from identities where author = '$PHP_AUTH_USER' order by timestamp desc";
			
		$result = mysql_db_query($database,$sql);
		$identity = mysql_result($result,0,"_index");
		
		/* get place */
		
		$sql = "select _index, timestamp from places where author = '$PHP_AUTH_USER' order by timestamp desc";
			
		$result = mysql_db_query($database,$sql);
		$place = mysql_result($result,0,"_index");
		
		/* assemble data for nodes */
		
		$index_node = get_new_index($nodes_t);
		$created = time();
		$edited = time();
		
		settype($timing, "integer");
		if (!$timing):
			$timing = 60;
		endif;
		
		$editor_id = $identity;
		$hits = 0;
		$displays = 0;
		$body = $body;
		
		/* mail to majordomo by un@dom.de, 22.03.97 */
		if ($email=="yes"):
		$email = "equator";
		$maildate=date("D, d.M Y");
		mail("$email", 
	        "$PHP_AUTH_USER passed through an ¿therLand", 
		"a new entry to ¿ther Lands was created by $PHP_AUTH_USER\nReference: $index_node $tag\n $maildate :\n\n$body\n\nkeep going...",
		"From: $PHP_AUTH_USER \<$email\>\nReply-To: $email");
		endif;
	
		/* SQL CALL */
		
		$sql = "insert into $nodes_t values ( $index_node, $created, $edited, '$tag', $identity, $editor_id, $place, $timing, $hits, $displays, '$body')";
	
		if ($debug):
			echo"$sql <p>";
		else:
			mysql_db_query($database,$sql);
		endif;
		
		/* ADD CONNECTION */
		
		$new_index = get_new_index($connections_t);
		
		if ($action == "add"):
		
			$sql = "insert into $connections_t values ( $new_index, $created, $node_in, $index_node, '')";
			if ($debug): echo"$sql <p>"; else: mysql_db_query($database,"$sql"); endif;
		
		elseif ($action == "insert"):
		
			$sql = "insert into $connections_t values ( $new_index, $created, $object, $index_node, '')";
			if ($debug): echo"$sql <p>"; else: mysql_db_query($database,"$sql"); endif;
			
			$sql = "update $connections_t set origin = $index_node, timestamp = $created " .
				"where origin = $object and target = $node_in";
			if ($debug): echo"$sql <p>"; else: mysql_db_query($database,"$sql"); endif;
			
			$node_in = $index_node;
		
		endif;
		
	endif;
	
	if ($action == "delete"):
		$owner=get_owner($node_in);
/*		if ($owner==$PHP_AUTH_USER){	 check owner */
			/* get parents */
		
			$parents_r = get_parents($node_in);
			$parents_nr = mysql_num_rows($parents_r);
		
			/* get children */
		
			$children_r = get_children($node_in);
			$children_nr = mysql_num_rows($children_r);
		
			/* delete node */
		
			$sql = "delete from nodes where _index = $node_in";
			if (! $debug): mysql_db_query($database, $sql); else: echo "$sql <p>"; endif;
		
			$sql = "delete from connections where origin = $node_in or target = $node_in";
			if (! $debug): mysql_db_query($database, $sql); else: echo "$sql <p>"; endif;
	
			/* connect every child to every parent */
		
			$children_i = 0;
			while ($children_i < $children_nr):
		
				$child_id = mysql_result($children_r,$children_i,"connections.target");
			
				$parents_i = 0;
				while ($parents_i < $parents_nr):
				
				$parent_id = mysql_result($parents_r,$parents_i,"connections.origin");
				$new_index = get_new_index($connections_t);
	
				$sql = "insert into connections values ( " +
				"$new_index, $now, $parent_id, $child_id, '')";
				if (! $debug): mysql_db_query($database, $sql); else: echo "$sql <p>"; endif;
				
				$parents_i++;
			endwhile;
			$children_i++;
		endwhile;
		$node_in = $one_parent;
		
	endif;
/*	}  owner checked */
endif;

	


/* DISPLAY THE TREE */

include "display.inc";


/* raise the count */

$hits = get_value($nodes_t, $node_in, "hits") +1;

$sql = "update nodes set hits = $hits where _index = $node_in";
mysql_db_query($database, $sql);

?>

