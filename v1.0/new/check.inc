<?
    if( !$PHP_AUTH_USER){
	Header("HTTP/1.0 401 Unauthorized");
	Header("WWW-authenticate: basic realm=\"ØtherLands\"");
	exit;
    } else {
        mysql_connect("localhost","other","Lands");
 	$passwd_in =  $PHP_AUTH_PW;
	
	$database="equator01";
	$sql = "select password from users where alias = '$PHP_AUTH_USER'";
        $result = mysql_db_query($database,$sql);
	
        $num_rows = mysql_num_rows($result);
	    $passwd = mysql_result($result,0,"password");
	
	if ($num_rows == 1 && $passwd == $passwd_in){
	    $user = $PHP_AUTH_USER;
	} else {
	    Header("HTTP/1.0 401 Unauthorized");
	    Header("WWW-authenticate: basic realm=\"phase\"");
	    exit;
	}
     }
?>
