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

//ʵ����һ�����ݿ���
$SearchPageSQL = $SearchPage->touchDatabase();

//������$�ݿ�
$SearchPageSQL->LinkDatabase();

//����id������ѯ����ȷ������$����
$SearchPageSQL->SelectSql($SearchPage->getIdSql());
//�����ѯ$����
$SearchPageSQL->HandleResult();

//��ȡ��ҳ��
$SearchPage->setTotalPage(ceil($SearchPageSQL->getSqlResultNum() / $SearchPage->getArticleNum()));

//����SqlStart
$SearchPage->getPageNum();
$SearchPage->getSqlStart();
//
$SearchPage->MakeArticleSql();
//��ѯ��$�ݿ�
$SearchPageSQL->SelectSql($SearchPage->getArticleSql());
//��ȡ��ǰҳ���
$SearchPage->getPageNum();

//�����ѯ����$����
$SearchPageSQL->HandleResult();
//���ش���������ݲ����䱣��SearchPage �� ArticleArray��
$SearchPage->setArticleArray($SearchPageSQL->data);


$SearchPage->DisplayHtml();