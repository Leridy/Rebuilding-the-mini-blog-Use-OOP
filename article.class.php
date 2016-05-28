<?php
require_once('page.class.php');
require_once('DisplayArticle.int.php');

/**
 * Created by PhpStorm.
 * User: LERIDY
 * Date: 2016/5/24
 * Time: 16:44
 */
class ArticlePage extends basePage
{
    /**
     * @var array 用于保存查询文章的所有数据
     */
    private $AMainContent;
    /**
     * @var int 用于保存当前文章ID
     */
    private $ArticleId;
    /**
     * @var string 文章的查询sql
     */
    private $ArticleSql;
    /**
     * @var string 用于查询文章标题列表和id列表的Sql
     */
    public $forIdandTitleSql = "select id, title  from article order by time desc";
    /**
     * @var string 用于储存查询到的文章的标题和id列表
     */
    public $forIdandTitleQuery;
    /**
     * @var array 用于保存上下文标签
     */
    private $ArticleLable;


    /**
     * ArticlePage constructor.
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function setArtcleId()
    {
        $this->ArticleId = intval($_GET['id']);
        $this->setArticleSql();
    }

    /**
     *
     */
    public function setArticleSql()
    {
        $this->ArticleSql = "select * from article where id=" . $this->ArticleId;
        //echo $this->ArticleSql."<br>";
    }

    /**
     *
     */
    public function DisplayMain()
    {
        echo "<main id=\"main\">";
        $this->DisplayArticle();
        echo "</main>";
    }

    /**
     *
     */
    public function DisplayArticle()
    {

        echo "<article id=\"post-$\" class=\"atc-content card-box\">";
        ?>
        <header class="atc-h">
            <h1 class="atc-c-t"><a href="article.php?id=<?php echo $this->ArticleId ?>"><?php echo $this->title ?></a>
            </h1>
            <span class="atc-info"><i class="fa fa-user"></i> <?php echo $this->AMainContent["author"] ?></span>
            <span class="atc-info"><i
                    class="fa fa-calendar"></i> <?php echo date("Y-m-d", $this->AMainContent['time']) ?></span>
        </header>
        <p class="atc-p">
            <?php echo $this->AMainContent['content'] ?>
        </p>
        <?php echo $this->ArticleLable ?>
        <?php
        echo "</article>";
        echo "<p class=\"atc-notice\"> >_< 对不起，暂未开放评论功能</p>";
    }

    /**
     * @param mixed $AMainContent
     */
    public function setAMainContent($AMainContent)
    {
        $this->AMainContent = $AMainContent;
        if (is_null($this->AMainContent)) {
            echo "<script>window.location.href='404.php';</script>";
            exit;
        }
        $this->title = $this->AMainContent['title'];
        $this->description = substr($this->AMainContent['summary'], 0, 50);
    }

    /**
     * @return mixed
     */
    public function getArticleSql()
    {
        return $this->ArticleSql;
    }

    /**
     * @return mixed
     */
    public function getAMainContent()
    {
        return $this->AMainContent;
    }






    //获取article的id和title
    //在文章内容页中获取上一篇和下一篇的id和title值
    //传参为 当前文章的 id值
    public function get_article_id_title()
    {
        //设置查询数据库中的id和标题，获取id和标题 的sql语句
        //$forIdandTitleSql = "select id, title  from article order by time desc";
        //执行查询，返回查询定位符给$forIdandTitleQuery
        //$forIdandTitleQuery = mysql_query($forIdandTitleSql);
        //判断$forIdandTitleQuery 是否存在，存在则以 键值对和数值对 的方法将获取值逐条复制给$IdandTitleQuerys

        //遍历 $idandTitleArray 以键值对的方式进入循环
        foreach ($this->forIdandTitleQuery as $key => $value) {
            //判断每次遍历出来的$idandTitleArray的$value 值得id值是否等于 当前文章的id的值
            //若文章的id相等则进入判断，
            if ($value['id'] == $this->ArticleId) {
                //rtv1 返回值 1  rtv2返回值2

                //判断本id存在的数组的上一条数组是否存在，若存在则将该数组赋值给 $rtv1 若不存在则将NULL值赋值给 $rtv1
                $rtv1 = (!isset($this->forIdandTitleQuery[$key - 1])) ? NULL : $this->forIdandTitleQuery[$key - 1];
                //判断本id存在的数组的下一条数组是否存在，若存在则将该数组赋值给 $rtv2 若不存在则将NULL值赋值给 $rtv2
                $rtv2 = (!isset($this->forIdandTitleQuery[$key + 1])) ? NULL : $this->forIdandTitleQuery[$key + 1];
                //将$rtv1 和 $rtv2 的值组成数组返回
                $this->ArticleLable = array($rtv1, $rtv2);
                $this->format_article_id();

            }
        }
    }

//方法 格式化 文章的 上一篇 下一篇的输出
//传参为 get_article_id_title($id) 方法的返回数组。
    /**
     * @param $array
     */
    public function format_article_id()
    {

        //声明变量 用于当传入的值中 标题为空时 的处理数组
        $notice = array('id' => 0, 'title' => ">_< ! 没有啦");
        //判断前一个的id和title是否存在，存在则 将 前一个数组赋值给 $preIdandTitle,否则将$notice 赋值到
        $preIdandTitle = ($this->ArticleLable[0] == NULL) ? $notice : $this->ArticleLable[0];

        //判断下一个的id和title是否存在，存在则 将 前一个数组赋值给 $preIdandTitle,否则将$notice 赋值到
        $nextIdandTitle = ($this->ArticleLable[1] == NULL) ? $notice : $this->ArticleLable[1];

        //将上面的数组的各项赋值给 对应 变量 并按格式输出，判断前一篇 或后一篇的 数组中id 是否为0 为零则将连接的输出 替换为 span输出
        $preId = $preIdandTitle['id'];
        $preTitle = $preIdandTitle['title'];
        $nextId = $nextIdandTitle['id'];
        $nextTitle = $nextIdandTitle['title'];
        $link1 = !($preId == 0) ? "<span class=\"atc-link\">上一篇：<a href=\"article.php?id=$preId\" title=\"$preTitle\" >$preTitle </a></span>" : "<span class=\"atc-link\">上一篇：$preTitle </span>";
        $link2 = !($nextId == 0) ? "<span class=\"atc-link\">下一篇：<a href=\"article.php?id=$nextId\" title=\"$nextTitle\" >$nextTitle </a></span>" : "<span class=\"atc-link\">下一篇：$nextTitle </span>";

        $output = $link1 . $link2;
        $this->ArticleLable = $output;
    }

//
}


