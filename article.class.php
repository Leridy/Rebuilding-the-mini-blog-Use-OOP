<?php
require_once('page.class.php');
/**
 * Created by PhpStorm.
 * User: LERIDY
 * Date: 2016/5/24
 * Time: 16:44
 */
class ArticlePage extends basePage
{
    private $AMainContent;
    /**
     * ArticlePage constructor.
     */
    public function __construct()
    {
    }
}

$article = new ArticlePage();
$article->DisplayHtml();