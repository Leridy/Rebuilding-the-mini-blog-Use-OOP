<?php
require_once('SearchPage.class.php');
/**
 * Created by PhpStorm.
 * User: LERIDY
 * Date: 2016/5/24
 * Time: 15:25
 */
$SearchPage=new SearchPage();
$SearchPage->is_search();

//实例化一个数据库类
$SearchPageSQL = $SearchPage->touchDatabase();

//链接数$据库
$SearchPageSQL->LinkDatabase();

//进行id数量查询，以确定文章$总数
$SearchPageSQL->SelectSql($SearchPage->getIdSql());
//处理查询$数字
$SearchPageSQL->HandleResult();

//获取总页数
$SearchPage->setTotalPage(ceil($SearchPageSQL->getSqlResultNum() / $SearchPage->getArticleNum()));

//调用SqlStart
$SearchPage->getPageNum();
$SearchPage->getSqlStart();
//
$SearchPage->MakeArticleSql();
//查询数$据库
$SearchPageSQL->SelectSql($SearchPage->getArticleSql());
//获取当前页面号
$SearchPage->getPageNum();

//处理查询到的$数据
$SearchPageSQL->HandleResult();
//返回处理过的数据并将其保存SearchPage 的 ArticleArray中
$SearchPage->setArticleArray($SearchPageSQL->data);


$SearchPage->DisplayHtml();