<?php
require_once('article.class.php');
/**
 * Created by PhpStorm.
 * User: LERIDY
 * Date: 2016/5/28
 * Time: 18:11
 */

$article = new ArticlePage();
$article->setArtcleId();
$articleSql = $article->touchDatabase();
$articleSql->LinkDatabase();

$articleSql->SelectSql($article->getArticleSql());
$articleSql->HandleResult();
$article->setAMainContent($articleSql->data[0]);

$articleSql->SelectSql($article->forIdandTitleSql);
$articleSql->HandleResult();
$article->forIdandTitleQuery = $articleSql->data;
$article->get_article_id_title();

$article->DisplayHtml();