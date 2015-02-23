<?
include "check.inc";
include "settings.inc";
if ($next_node): $node = $next_node; endif;
if ($this_node): $node = $this_node; endif;
echo "<head> <title>Eq 1.0: Feedback [node $node]</title> </head>";
echo $body_sets;

include "functions.inc";
include "header.inc";

$debug = 0;

?>

<? display_node($node, $node, "single");?>

<? if ($action == "mailto"): ?>

	<?
	/*
	echo "<br> Thanks for recoding the EQuator!<br>";
	echo "Your contribution is being processed by the human/machine system ... <p>";
	echo "Go back to the script or RE.play ... unlimited credit! <p>";
	*/
	?>

	<? if($text):
		$maildate=date("D, d.M Y");
	
		if($lsubject): $subject = $lsubject;
		else:
		$subject = "mail to ¯therLands";
	endif;
	
	        if($lemail): $email = $lemail;
	        else:
	        $email = "equator@king.dom.de";
	        endif;
	
	        if($lname): $name = $lname;           
	        else:
	        $name = "nobody";          
	        endif;
	
	        if($llocation): $location = $llocation;
	        else:
	        $location = "elsewhere";
	        endif;
	 
	
	        mail(
	        "equator",
	        "$subject",
	        "Mail to ¯therLands, created by $name at $maildate\nReference: http://king.dom.de/equator/v1.0/script.php3?node=$node\nSubject: $subject\nLocation: $location\n\n$text\n",
		"From: $name \<$email\>\nReply-To: $email");
	        echo "<p><font size=6>done!</font><p>\n";
		echo "\<a href=\"http://king.dom.de/equator/mail/\"\>goto \</a\>\n";
		echo "recent archives.\n";
	else:
	
?>
	<form action=user_mail.php3?node=<? echo "$node";?>&action=mailto method=post>
	<input type=submit value="Mailto equator list">
	<p>
	If you wish to subscribe to our mailing list, click on
	<a href="mailto:majordomo@king.dom.de">*Majordomo@king.dom.de*</a>,<br>
	put: <i>subscribe equator</i> in the message body.<p>
	<table><tr><td>
	Subject:<br><input type=text size=35 name=lsubject></td>
	<td>Email:<br><input type=text size=35 name=lemail></td>
	</tr><tr>
	<td>Name:<br><input type=text size=35 name=lname></td>
	<td>Location:<br>
	<input type=text size=35 name=llocation></td></tr>
	</table>
	<textarea
	name=text 
	rows=15 
	cols=70 
	wrap=yes></textarea>
	
	<p>
	</form>
<? endif?>	
<? endif?>

</table>
