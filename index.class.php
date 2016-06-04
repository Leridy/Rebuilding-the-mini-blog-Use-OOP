<?php
require 'page.class.php';
require 'DisplayArticleList.int.php';

/**
 * index page class
 */
class IndexPage extends basePage implements DisplayArticleList
{
    //index页面的页号码
    protected $pageNum = 1;
    //数据库查询开始点
    protected $SqlStart;
    //文章的SQL语句
    protected $ArticleSql;
    //id的Sql语句
    protected $IdSql = "select id from article where id";
    //获取到的文章数组
    protected $ArticleArray;
    //总页数
    protected $totalPage;
    //煤业文章数
    protected $ArticleNum = 4;
    //当前页路径
    protected $thisUrl;
    //当内容为空时的提醒信息
    protected $Notice = "<article  class=\"atc-entry card-box\">
                        <header class=\"atc-h\">
                        <h1 class=\"atc-c-t\">(￣o￣) . z Z 博主偷懒，没有内容</h1>
                        <span class=\"atc-info\"><i class=\"fa fa-user\"></i> 勤劳的程序猿</span>
                        <span class=\"atc-info\"><i class=\"fa fa-calendar\"></i> 盘古开天辟地之时</span>
                        </header>
                        <section class=\"atc-r\">
                        欢迎你的到来，这里是互联网中的一隅，暂时没有相关内容被添加。如果你看到了提醒请联系博主添加相关内容 ;-) 。
                        </section>
                        <a href=\"mailto://admin@leridy.pw\" title=\"联系博主\" class=\"atc-ra\"><i class=\"fa fa-envelope\"></i> 联系博主 +</a>
                        </article>";

    //获取查询单次搜索开始点
    public function getSqlStart()
    {
        $this->SqlStart = ($this->pageNum - 1) * $this->ArticleNum;
        return $this->SqlStart;
    }

//获取当前页
    public function getPageNum()
    {
        if (!isset($_GET["page"])) {
            $this->pageNum = 1;
        } else {
            //若page存在则将page强制类型专化，用于过滤非法传值
            $this->pageNum = (int)$_GET["page"];
            //若强制转换后的值为0 则返回1，否则返回当前page值
            if ($this->pageNum <= 0) {
                $this->pageNum = 1;
            } elseif ($this->pageNum > $this->totalPage) {
                $this->pageNum = $this->totalPage;

            }
        }
        //echo $this->pageNum."<br/>";
    }


    //生成文章的SQL语句
    public function MakeArticleSql()
    {
        $this->ArticleSql = "select * from article where id order by time desc limit " . $this->SqlStart . "," . $this->ArticleNum;
    }

    public function DisplayArticleList($data)
    {
        if ($data == null) {
            echo $this->Notice;
        } else {
            foreach ($data as $value) {
                ?>

                <article id="post-<?php echo $value['id'] ?>" class="atc-entry card-box">
                    <header class="atc-h">
                        <h1 class="atc-c-t"><a
                                href="article.php?id=<?php echo $value['id'] ?>"><?php echo $value['title'] ?></a></h1>
                        <span class="atc-info"><i class="fa fa-user"></i> <?php echo $value['author'] ?></span>
                        <span class="atc-info"><i
                                class="fa fa-calendar"></i> <?php echo date("Y-m-d", $value['time']) ?></span>
                    </header>
                    <section class="atc-r">
                        <?php echo $value['summary'] ?>
                    </section>
                    <a href="article.php?id=<?php echo $value['id'] ?>" title="阅读全文" class="atc-ra">查看全文 +</a>
                </article>
                <?php
            }
        }

    }

    //输出分页功能
    public function Pagination()
    {
        //首先声明变量$totalPage 并取值为所有文章的数量除以4
        $totalPage = $this->totalPage;
        //声明变量 $thisPage ，并赋值为当前页面的 路径
        $thisPage = $this->thisUrl;
        //当前页页码
        $p = $this->pageNum;
        //检查当前传值中是否存在keywords值 若若不存在 则将变量 $keywords 赋值为空字符串，若存在则赋值为当前 值，以及get请求格式
        if (!isset($this->SKeyWords)) {
            $keywords = "";
        } else {
            if(!isset($this->SType)){
                $keywords = "keywords=" . $this->SKeyWords . "&";
            }else{
                $keywords = "keywords=".$this->SKeyWords."&type=".$this->SType."&";
            }

        }

        //判断当前页是否为第一页或者为空页，若为空，则退出函数不执行任何输出
        if ($totalPage == 0 || $totalPage == 1) {
            return 1;
            //当总页数大于7时首先输出分页最外层的标签
        } elseif ($totalPage > 7) {
            echo "<div class=\"page-label\"><div class=\"page-lab-bx\">";
            //再判断当前页是否为第一页，若是着输出一个不可被点击的上页符号，若不是则输出 一个指向当前页的上页的连接的翻页符号
            if ($p == 1) {
                echo "<span class=\"ban\"><</span>";
            } else {
                echo "<a href=\"$thisPage?" . $keywords . "page=" . ($p - 1) . "\" title=\"上一页\" class=\"page-item\"><</a>";
            }
            //当$p 小于等于4 时
            if ($p <= 4) {
                //循环执行七次 输出 分页函数，并且传入对应参数。
                for ($i = 1; $i <= 7; $i++) {
                    $this->output_pagination($i, $p, $keywords, $thisPage);
                }
                //输出一个省略符
                echo "<span>...</span>";
                //判断 当 当前页大于或等于4 且 当前页小于 总页数减三时
            } elseif ($p >= 4 && $p < $totalPage - 3) {
                //首先输出省略符，在循环执行当前页的前三页至当前页之后三页共七次输出分页函数
                echo "<span>...</span>";
                for ($i = ($p - 3); $i <= ($p + 3); $i++) {
                    $this->output_pagination($i, $p, $keywords, $thisPage);
                }
                //输出省略符
                echo "<span>...</span>";
                //当当前页地页码大于 全部页面数减三时
            } elseif ($p >= $totalPage - 3) {
                // 先输出省略符
                echo "<span>...</span>";
                //在执行总页数及前六页的标签，共七次
                for ($i = ($totalPage - 6); $i <= $totalPage; $i++) {
                    $this->output_pagination($i, $p, $keywords, $thisPage);
                }
            }
            //当当前页数值等于总页数时，输出一个无法被点击的下一页选项，否则输出一个指向当前页的下一页的链接
            if ($p == $totalPage) {
                echo "<span class=\"ban\">></span>";
            } else {
                echo "<a href=\"$thisPage?" . $keywords . "page=" . ($p + 1) . "\" title=\"下一页\" class=\"page-item\">></a>";
            }
            //输出总页数
            echo "<span class=\"totalPage\">共" . $totalPage . "页</span>";
            //在快捷分页选项卡中输出所有的分页链接
            echo "<div class=\"page-label-select\"><h3 class=\"pagination\">分页 <i class=\"fa fa-sort\"></i><ul class=\"select-list\">";
            for ($i = 1; $i <= $totalPage; $i++) {
                echo "<li class=\"child-item\"><a href=\"$thisPage?" . $keywords . "page=$i\" title=\"第" . $i . "页\">$i</a></li>";
            }
            //输出关闭标签
            echo "</ul></h3></div><!-- 选择跳转分页部分 --></div><!-- 分页部分完结 -->";
            //若总页数小于等于七页则换种方法
        } elseif ($totalPage <= 7) {
            //与前相同
            echo "<div class=\"page-label\">
                    <div class=\"page-lab-bx\">";
            if ($p == 1) {
                echo "<span class=\"ban\"><</span>";
            } else {
                echo "<a href=\"$thisPage?" . $keywords . "page=" . ($p - 1) . "\" title=\"上一页\" class=\"page-item\"><</a>";
            }
            //直接执行所有页次的输出
            for ($i = 1; $i <= $totalPage; $i++) {
                $this->output_pagination($i, $p, $keywords, $thisPage);
            }
            //与前相同
            if ($p == $totalPage) {
                echo "<span class=\"ban\">></span>";
            } else {
                echo "<a href=\"$thisPage?" . $keywords . "page=" . ($p + 1) . "\" title=\"下一页\" class=\"page-item\">></a>";
            }
            echo "<span class=\"totalPage\">共" . $totalPage . "页</span>";
            echo "<div class=\"page-label-select\"><h3 class=\"pagination\">分页 <i class=\"fa fa-sort\"></i><ul class=\"select-list\">";
            for ($i = 1; $i <= $totalPage; $i++) {
                echo "<li class=\"child-item\"><a href=\"$thisPage?" . $keywords . "page=$i\" title=\"第" . $i . "页\">$i</a></li>\n";
            }
            echo "</ul>\n</h3>\n</div>\n<!-- 选择跳转分页部分 -->\n</div>\n<!-- 分页部分完结 -->";
        }
    }

//输出分页项，
//传参 为 $i当前循环序号，$p当前页号，$keywords关键字字符串 ，$thispage 这一页面的路径

    public function output_pagination($i, $p, $keywords, $thisPage)
    {
        if ($i != $p) {
            echo "<a href=\"$thisPage?" . $keywords . "page=$i\" title=\"第" . $i . "页\" class=\"page-item\">$i</a>";
        } else {
            echo "<span class=\"current\">$i</span>";
        }
    }

//输出main标签内容
    public
    function DisplayMain()
    {
        echo "<main id=\"main\">";
        $this->DisplayArticleList($this->ArticleArray);
        $this->Pagination();
        echo "</main>";
    }

    /**
     * @return mixed
     */
    public
    function getArticleSql()
    {
        return $this->ArticleSql;
    }

    /**
     * @param mixed $ArticleSql
     */
    public
    function setArticleSql($ArticleSql)
    {
        $this->ArticleSql = $ArticleSql;
    }

    /**
     * @return string
     */
    public
    function getIdSql()
    {
        return $this->IdSql;
    }

    /**
     * @param string $IdSql
     */
    public
    function setIdSql($IdSql)
    {
        $this->IdSql = $IdSql;
    }

    /**
     * @return mixed
     */
    public
    function getArticleArray()
    {
        return $this->ArticleArray;
    }

    /**
     * @param mixed $ArticleArray
     */
    public
    function setArticleArray($ArticleArray)
    {
        $this->ArticleArray = $ArticleArray;
    }

    /**
     * @return mixed
     */
    public
    function getTotalPage()
    {
        return $this->totalPage;
    }

    /**
     * @param mixed $totalPage
     */
    public
    function setTotalPage($totalPage)
    {
        $this->totalPage = $totalPage;
    }

    /**
     * @return mixed
     */
    public
    function getThisUrl()
    {
        return $this->thisUrl;
    }

    /**
     * @param mixed $thisUrl
     */
    public
    function setThisUrl($thisUrl)
    {
        $this->thisUrl = $thisUrl;
    }

    /**
     * @return int
     */
    public
    function getArticleNum()
    {
        return $this->ArticleNum;
    }

    /**
     * @param int $ArticleNum
     */
    public
    function setArticleNum($ArticleNum)
    {
        $this->ArticleNum = $ArticleNum;
    }

    /**
     * @return string
     */
    public
    function getNotice()
    {
        return $this->Notice;
    }

    /**
     * @param string $Notice
     */
    public
    function setNotice($Notice)
    {
        $this->Notice = $Notice;
    }

    /*
     * protected 属性的set get 函数集合*/

//类的大括号
}


?>