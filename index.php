<?php
require_once('index.class.php');
/**
 * Created by PhpStorm.
 * User: LERIDY
 * Date: 2016/5/24
 * Time: 12:42
 */

//实例化一个IndexPage $p
$Index = new IndexPage("你在干什么？", "这是小博客");
//实例化一个数据库类
$IndexSQL = $Index->touchDatabase();
//连接数据库
$IndexSQL->LinkDatabase();
//进行id数量查询，以确定文章总数
$IndexSQL->SelectSql($Index->getIdSql());
//处理查询数字
$IndexSQL->HandleResult();
//获取总页数
$Index->setTotalPage(ceil($IndexSQL->getSqlResultNum() / $Index->getArticleNum()));
//获取当前页面号
$Index->getPageNum();
//调用SqlStart
$Index->getSqlStart();
//组成一个文章的SQL语句
$Index->MakeArticleSql();
//查询数据库
$IndexSQL->SelectSql($Index->getArticleSql());
//处理查询到的数据
$IndexSQL->HandleResult();
//返回处理过的数据并将其保存至IndexPage 的 ArticleArray中
$Index->setArticleArray($IndexSQL->data);

//执行显示
$Index->DisplayHtml();