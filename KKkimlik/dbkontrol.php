<?php
$link = mysql_connect("localhost", "root", "root") or die(mysql_error());
$db = mysql_select_db("prg", $link) or die (mysql_error());

?>