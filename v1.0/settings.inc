<?php
//setshowinfo(0);
//setlogging(0);
srand(time());

$now=time();

$database="equator01";
$nodes_t = "nodes";
$connections_t = "connections";
$users_t = "users";
$identities_t = "identities";
$places_t = "places";
$properties_t = "properties";

$upload_path = "/var/www/html/king.dom.de/equator/upload";
$upload_url = "/equator/upload";
$base = "http://king.dom.de/equator/";

$sys_color = "000000";
$info_color = "990000";
$block_color = "181818";

$color_sets[] = "<BODY BGCOLOR=#000000 text=eeeeee LINK=#99ff99 VLINK=#99ff99>";
$color_sets[] = "<BODY BGCOLOR=#252500 text=eeeeee LINK=#99ff99 VLINK=#99ff99>";
$color_sets[] = "<BODY BGCOLOR=#aaaa00 text=eeeeee LINK=#99ff99 VLINK=#99ff99>";
$color_sets[] = "<BODY BGCOLOR=yellow text=green LINK=red VLINK=red>";
$color_sets[] = "<BODY BGCOLOR=#ff0000 text=000000 LINK=#99ff99 VLINK=#99ff99>";
$color_sets[] = "<BODY BGCOLOR=#ff1188 text=00e3e3 LINK=#ffffff VLINK=#ffffff>";

$body_sets = $color_sets[1];

?>
