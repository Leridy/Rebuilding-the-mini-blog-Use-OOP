<?php
require_once("page.class.php");
/**
 * Created by PhpStorm.
 * User: LERIDY
 * Date: 2016/5/28
 * Time: 18:24
 */
class notFound extends basePage
{
    public $title = "404 Not Found";
    public $description = "你所寻找的页面没有找到";

    /**
     * notFound constructor.
     */
    public function __construct()
    {
    }


    public function DisplayMain(){
        echo "<main id=\"main\">";
        $this->Display404();
        echo "</main>";
    }

    public function Display404(){
        ?>
        <header id="search-page-header" class="main-header">
            <h1 class="s-p-h-keywords main-title">ERROR : 404</h1>
        </header>
        <div class="card-box not-found-page">
            <h1 class="nfp-notice">
                ('_')? 抱歉您所请求的页面不存在
            </h1>
            <a href="<?php echo $GLOBALS['location'] ?>index.php" class="nfp-link link">返回首页</a>
        </div>
        <?php
    }


}