<?php
require_once('index.class.php');

/**
 * Created by PhpStorm.
 * User: LERIDY
 * Date: 2016/5/24
 * Time: 12:45
 */
class SearchPage extends IndexPage
{
    /**
     * @var string 用于储存搜索类型
     */
    protected $SearchHeader;
    /**
     * @var string 用于存放搜索Keywords
     */
    protected $SKeyWords;
    //数据库查询开始点
    protected $SqlStart;
    //文章的SQL语句
    protected $ArticleSql;
    //id的Sql语句
    protected $IdSql;
    //存放搜索类型
    public $SType;
    /**
     * @var string 当没有内容时的提醒内容
     */
    protected $Notice;

    /**
     * SearchPage constructor.
     * @param string $SearchHeader
     */
    public function __construct()
    {
    }
    //




    //重写输出main的函数
    public function DisplayMain()
    {
        echo "<main id=\"main\">";
        echo "<header id=\"search-page-header\" class=\"main-header\">
                <h1 class=\"s-p-h-keywords main-title\">" . $this->SearchHeader . ":" . $this->SKeyWords . "</h1>
            </header>";
        $this->DisplayArticleList($this->ArticleArray);
        $this->Pagination();
        echo "</main>";
    }

    //判断是否为搜索
    //用于在搜索页中判断是否是当需要搜索时调用的跳转搜索页面
    public function is_search()
    {
        //判断keywords 是否存在 和是否为空 若成立 则返回 keywords 。 若不成立则将页面跳转至 首页
        if (isset($_GET['keywords']) && !empty($_GET['keywords'])) {
            $this->SKeyWords = $_GET['keywords'];
        } else {
            echo "<script>window.location.href='index.php'</script>";
            return 0;
        }
        $this->tag_or_search();
    }

    //判断是 tag  还是 搜索
    public function tag_or_search()
    {
        //判断是否存在 type传参，若存在则将 type传参赋值给 变量$type 若 type值为 tag 这返回 标签，若为空 或不为tag 则返回搜索
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            if ($type == "tag") {
                $this->SearchHeader = "标签";
                $this->SType = "tag";
            } else {
                $this->SearchHeader = "搜索";
                $this->SType="s";
            }

        } else {
            $this->SearchHeader = "搜索";
            $this->SType="s";
        }
        $this->setIdSql();
    }




//SearchPage 类中的get和set函数
    public function setNotice()
    {
        $this->Notice = "<article  class=\"atc-entry card-box\">
                        <header class=\"atc-h\">
                        <h1 class=\"atc-c-t\">>~< ! 对不起，没有内容</h1>
                        <span class=\"atc-info\"><i class=\"fa fa-user\"></i> 勤劳的程序猿</span>
                        <span class=\"atc-info\"><i class=\"fa fa-calendar\"></i> 盘古开天辟地之时</span>
                        </header>
                        <section class=\"atc-r\">
                        对不起暂时没有与<strong>\"" . $this->SKeyWords . "\"</strong>相关内容被添加，请联系博主添加相关内容 ;-) .
                        </section>
                        <a href=\"mailto://admin@leridy.pw\" title=\"联系博主\" class=\"atc-ra\"><i class=\"fa fa-envelope\"></i> 联系博主 +</a>
                        </article>";
    }


    /**
     * @param mixed $IdSql
     */
    public function setIdSql()
    {
        $this->IdSql ="select * from article where keywords like '%$this->SKeyWords%'";
    }

    /**
     * @param mixed $ArticleSql
     */
    public function MakeArticleSql()
    {
        $this->ArticleSql = "select * from article where keywords like '%$this->SKeyWords%' order by time desc limit " .$this->SqlStart. ",".$this->ArticleNum;
        //echo $this->pageNum." | ".$this->SqlStart."<br>";
        $this->setDescription();
        $this->setTitle();
        $this-> setNotice();
    }
    /**
     * @param mixed $description
     */
    public function setDescription()
    {
        $this->description = " 与".$this->SKeyWords."有关的".$this->SearchHeader."结果";
    }

    /**
     * @param mixed $title
     */
    public function setTitle()
    {
        $this->title = $this->SKeyWords."--".$this->SearchHeader." " ;
    }



}