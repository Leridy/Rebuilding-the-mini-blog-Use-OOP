<?php
require_once '../connect.php';
$id = $_POST['id'];
$title = $_POST['atc-title'];
$author = $_POST['atc-author'];
$summary = $_POST['atc-summary'];
$content = $_POST['atc-content'];
$keywords = $_POST['atc-keywords'];
$content = str_replace(array("\r\n\t", "\r\n", "\r", "\n", "\t"), "</p><p class=\"atc-p\">", $content);
$updatesql = "update article set title='$title',author='$author',summary='$summary',content='$content',keywords='$keywords' where id=$id";
if (mysqli_query($con, $updatesql)) {
	echo "<script>alert('修改文章成功');window.location.href='manage-article.php';</script>";
} else {
	echo "<script>alert('修改文章失败');window.location.href='manage-article.php';</script>";
}
?>