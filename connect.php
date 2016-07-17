<?php
require_once 'config.php';
//Á¬¿â
if (!($con = mysqli_connect(HOST, USERNAME, PASSWORD, 'b_article'))) {
	echo mysqli_error($con);
}
//Ñ¡¿â
/*if (!mysql_select_db('b-article')) {
echo mysql_error();
}*/
//×Ö·û¼¯
if (!mysqli_query($con, 'set names utf8')) {
	echo mysqli_error($con);
}
?>