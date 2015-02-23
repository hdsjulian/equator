<? 

include "check.inc";
include "settings.inc";
echo "<head> <title> Equator 1.0: Upload </title> </head>";
echo $body_sets;

/*
include "functions.inc";
include "header.inc";
*/

$fsize = 10000000; /* maximale Filegroesse */;
?>

<FORM ENCTYPE="multipart/form-data" ACTION="<?echo "$PHP_SELF?action=$action&upload=process"?>" METHOD=POST> 
<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="<? echo $fsize?>"> 
Send this file: <INPUT size=40 NAME="userfile" TYPE="file"> 
<INPUT TYPE="submit" VALUE="Send File"> 
</FORM>

<?
$user_upload = $upload_path . "/" . $PHP_AUTH_USER;
if (filesize("$user_upload") == -1):
	mkdir("$user_upload", 0755);
    echo "creating directory: $upload_user<p>";
endif;

if ($upload=="process"):
    
    if($userfile):
	$newname = $upload_path . "/" . $PHP_AUTH_USER . "/" . $userfile_name;
	system("cp $userfile $newname");
    endif;
endif;

/*
if ($upload=="mkdir");
	$dirname = reg_replace("\W","",$dirname);
    if($dirname);
    	$new_dir = "$upload_path/$PHP_AUTH_USER/$dirname";
		mkdir("$new_dir", 0755);
		echo "creating directory: $new_dir<p>";
	endif;
endif;
*/
?>



<?

/* list files of this user */

echo "<table cellpadding=5 border=1> <tr>";

echo "<td colspan=5 bgcolor=$sys_color> <font size=+1> $PHP_AUTH_USER, you have the following files in your upload directory</font></td>";

chdir("$upload_path/$PHP_AUTH_USER");
exec("ls *",$imgs,$tmp);

$i=0;
while($i < count($imgs)):
    echo "<tr>";
    $pic_url="$upload_url/$PHP_AUTH_USER/$imgs[$i]";
    echo "<td><font size=+0><a href=$pic_url>$imgs[$i]</a></font> </td>";
    $size = filesize($imgs[$i]) / 1000;
    $m_date = date("H:i d. M. y", filemtime($imgs[$i]));
    echo "<td><font size=-1>$size Kbytes</td>";
    echo "<td><font size=-1>$m_date</td>";
    echo "<td><font size=-1>URL: $upload_url/$PHP_AUTH_USER/$imgs[$i]</td>";
    echo "<td><font size=-1><a href=$PHP_SELF?action=$action&file=$imgs[$i]&upload=remove>remove</a></td>";
    echo "</tr>";
    next($imgs);
    $i++;
endwhile;

echo "</table>";
?>

<?
if ($upload=="remove"):
    if($file):
	system("rm -f $upload_path/$PHP_AUTH_USER/$file");
    endif;
endif;
?>

