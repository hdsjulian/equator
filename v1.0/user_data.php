<?
include "check.inc";
include "settings.inc";
echo "<head> <title> Equator 1.0: Script </title> </head>";
echo $body_sets;

include "functions.inc";
include "header.inc";

$debug = 0;

echo "<table width=400>\n";
echo "<tr><td>";

$status = get_status();
if ($status != "anon"):

	echo "<a href=$PHP_SELF?select=id_place_data>add new identity/place ></a><p>";
	echo "<a href=$PHP_SELF?select=user_data>update your user data ></a><p>";
	echo "<a href=later.php3>view your user_log ></a><p>";
	
	if ($select == "user_data"):
		
		if ($action == "update"):
			
			/* update data from form input */
			
			$sql = "update $users_t set " +
			"name = '$name', e_mail = '$e_mail', password = '$password' " +
			"where alias = '$PHP_AUTH_USER'";
			
			if ($debug): echo"$sql <p>"; else: mysql_db_query($database,$sql); endif;
	
		endif;
		
		/* get data */
		
		$sql = "select * from users where alias = '$PHP_AUTH_USER'";
		$result = mysql_db_query($database,$sql);
		$alias = mysql_result($result,0,"alias");
		$status = mysql_result($result,0,"status");
		$password = mysql_result($result,0,"password");
		$name = mysql_result($result,0,"name");
		$e_mail = mysql_result($result,0,"e_mail");
		
		/* display fixed data */
		
		echo "user login: <font size=+2>$PHP_AUTH_USER</font><p>";
		echo "security clearing: <font size=+2>$status</font><p>";
		
		/* display form data */
		
		echo "<form action=$PHP_SELF?select=user_data&action=update method=post>";
		
		echo "<input name=name type=Text SIZE=30 value=\"$name\">";
		echo "<br>name<p>\n";
		
		echo "<input name=e_mail type=Text SIZE=30 value=\"$e_mail\">";
		echo "<br>e-mail address<p>";
		
		echo "<input name=password type=Text SIZE=30 value=\"$password\">";
		echo "<br>password, DONT FORGET IT!<p>";
		
		echo "<input type=submit value=\"Update my Agent\">";
		
		echo "</form>";
		
	elseif ($select == "id_place_data"):
	
		if ($action == "update"):
			
			/* get the last identity and test for changes */
			
			$last_index = get_last_index($identities_t);		
			
			$sql = "select * from $identities_t where _index = $last_index";
			$result = mysql_db_query($database, $sql);
			$alias_n = mysql_result($result,0,"alias");
			$state_n = mysql_result($result,0,"state");
			$comment_n = mysql_result($result,0,"comment");
			
			if ($alias_n != $alias || $state_n != $state || $comment_n != $comment):
			
				/* add identity from form input */
				
				$new_index = get_new_index($identities_t);
				
				$sql = "insert into $identities_t values ( " +
				"$new_index, '$PHP_AUTH_USER', $now, '$alias', '$state', '$comment')";
				
				if ($debug): echo"$sql <p>"; else: mysql_db_query($database,$sql); endif;
				
			endif;
	
			/* get the last place and test for changes */
			
			$last_index = get_last_index($places_t);		
			
			$sql = "select * from $places_t where _index = $last_index";
			$result = mysql_db_query($database, $sql);
			$location_n = mysql_result($result,0,"location");
			$long_n = mysql_result($result,0,"_long");
			$lat_n = mysql_result($result,0,"lat");
			
			if ($location_n != $location || $long_n != $long || $lat_n != $lat):
			
				/* add place from form input */
				
				$new_index = get_new_index($places_t);
				
				$sql = "insert into $places_t values ( " +
				"$new_index, '$PHP_AUTH_USER', $now, '$location', '$long', '$lat')";
				
				if ($debug): echo"$sql <p>"; else: mysql_db_query($database,$sql); endif;
				
			endif;
			
		endif;
		
		/* IDENTITY */
		
		/* get data */
		
		$last_index = get_last_index($identities_t);		
		
		$sql = "select * from $identities_t where _index = $last_index";
		$result = mysql_db_query($database, $sql);
		$alias = mysql_result($result,0,"alias");
		$state = mysql_result($result,0,"state");
		$comment = mysql_result($result,0,"comment");
			
		/* identity form input */
		
		echo "<p>current <font size=+2>IDENTITY</font> of $PHP_AUTH_USER<br><p>";
		
		echo "<form action=$PHP_SELF?select=id_place_data&action=update method=post>";
		
		echo "<input name=alias type=Text SIZE=40 maxlength=32 value=\"$alias\">";
		echo "<br>ALIAS: your alternative identity name<p>\n";
		
		echo "<input name=state type=Text SIZE=40 maxlength=64 value=\"$state\">";
		echo "<br>STATE: emotional or physical<p>";
		
		echo "<textarea name=comment rows=5 cols=40 wrap=virtual>$comment</textarea>";
		echo "<br>COMMENT: your logbook<p>";
		
		/* PLACE */
		
		/* get data */
		
		$last_index = get_last_index($places_t);		
		
		$sql = "select * from $places_t where _index = $last_index";
		$result = mysql_db_query($database, $sql);
		$location = mysql_result($result,0,"location");
		$long = mysql_result($result,0,"_long");
		$lat = mysql_result($result,0,"lat");
			
		/* place form input */
		
		echo "<P>current <font size=+2>PLACE</font> of $PHP_AUTH_USER<P>";
		
		echo "<input name=location type=Text SIZE=40 maxlength=64 value=\"$location\">";
		echo "<br>LOCATION: geographic position, city, in bed etc. <p>\n";
		
		echo "<input name=long type=Text SIZE=8 maxlength=7 value=\"$long\">";
		echo "<br>LONGITUDE: i. e. \"30:11\" (degrees, minutes)<p>";
		
		echo "<input name=lat type=Text SIZE=8 maxlength=7 value=\"$lat\">";
		echo "<br>LATITUDE: i. e. \"30:11\" (degrees, minutes)<p>";
		
		echo "<input type=submit value=\"Update my Identity/Place\">";
		
		echo "</form>";
		
	endif;
	
endif;
	
echo "</td></tr>";
echo "</table>\n";

