<?php
$GLOBALS['location'] = "http://" . $_SERVER['HTTP_HOST'] . "/Large-software-design-homework/rebuild htmls/";
//引入MySQL 的类文件
require 'Mysql.class.php';
/**
 * define the mini blog page class
this class is the base class of all pages
 */

class basePage {

	//网页标题和描述
	public $title;
	public $description;
	//导航栏的项目
	public $navs = array(
		"首页" => "index.php",
		"关于" => "#",
		"留言板" => "#",
		"友链" => "friendlink.php",
	);
	//MySql的查询语句
	public $Sql;
	//构造函数
	function __construct($title, $description) {
		$this->title = $title;
		$this->description = $description;
	}

	public function DisplayHtml() {
		echo "<!DOCTYPE html>\n<html lang=\"zh-cn\">";
		$this->DisplayHead();
		$this->DisplayBody();
		echo "\n</html>";

	}
	//输出网页的head所有部分
	public function DisplayHead() {
		?>
		<head>
		    <meta charset="UTF-8">
		    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1">
		    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		    <meta name="keywords" content="完全是为了应付作业">
		    <meta name="description" content="<?php echo $this->description ?>" />
		    <title><?php echo $this->title . "|" . $this->description ?></title>
		    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['location']; ?>addtionalFonts/css/font-awesome.min.css">
		    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['location']; ?>css/style.css">
		</head>
		<?php
}
	//输出网页body
	public function DisplayBody() {
		echo "<body id=\"body-wrap\">";
		$this->DisplayHeader();
		echo "<div id=\"container\">";
		$this->DisplayMain();
		$this->DisplayAside();
		$this->DisplayFooter();
		echo "</div>\n</body>";
	}
	//输出网页的header标签
	public function DisplayHeader() {
		echo "
		<header class=\"page-header\">
		<span class=\"h-banner hd-l\"><img src=\"" . $GLOBALS['location'] . "images/logo.jpeg\" class=\"h-logo\"> <a href=\"#\">个人部落格 </a> —— 想写就写</span>";
		$this->DisplayNavs($this->navs);
		echo "</ul></nav>";
		$this->DisplayHeaderSearch();
		$this->DisplayHeaderSocial();
		echo "</header>";
	}
	//输出header标签中的导航列表
	public function DisplayNavs($nav) {
		echo "<nav class=\"page-nav\"><ul class=\"nav-ls\">\n";
		foreach ($nav as $name => $url) {
			$this->DisplayANav($name, $url, !$this->IsURLCurrentPage($url));
		}
	}

	//输出导航列表中的项目
	public function DisplayANav($name, $url, $active = true) {
		if ($active) {

			echo "<li class=\"nav-item\"><a href=\"" . $GLOBALS['location'] . $url . "\" title=\"" . $name . "\" class=\"active\" >" . $name . "</a></li>";
		} else {
			echo "<li class=\"nav-item\"><a href=\"" . $GLOBALS['location'] . $url . "\" title=\"" . $name . "\">" . $name . "</a></li>";
		}
	}
	//判断导航标签是否输出的是否是本页
	public function IsURLCurrentPage($url) {
		if (strpos($_SERVER['PHP_SELF'], $url) == true) {
			return 0;
		} else {
			return 1;
		}
	}
	//输出header标签中的搜索表单
	public function DisplayHeaderSearch() {
		?>
		    <form method="GET" action="search.php" class="post-search">
            	<label for="s" class="fa fa-search s-lab"></label>
            	<input type="text" class="search-inpt" name="keywords" placeholder=" 请输入你的关键词" id="s" AutoComplete="off">
            </form>
		<?php
}

	//输出header中的社交部分
	public function DisplayHeaderSocial() {
		?>
		<ul class="social-icon hd-r">
            <span class="flm">关注我：</span>
            <li class="s-icon">
                <a href="#" title="weibo" class="fa fa-weibo"></a>
            </li>
            <li class="s-icon">
                <a href="#" title="github" class="fa fa-github"></a>
            </li>
            <li class="s-icon">
                <a href="#" title="facebook" class="fa fa-facebook-official"></a>
            </li>
            <li class="s-icon">
                <a href="#" title="twitter" class="fa fa-twitter"></a>
            </li>
            <li class="s-icon">
                <a href="#" title="google plus" class="fa fa-google-plus"></a>
            </li>
        </ul>
		<?php
}
	//输出main标签内的内容
	public function DisplayMain() {
		echo "<main id=\"main\">";
		//$this->DisplayMainContent();
		echo "</main>";

	}
	//输出边栏
	public function DisplayAside() {
		echo "<div id=\"sidebar\">";
		?>
		 	<aside class="widget widget-webmaster-info">
                <header class="widget-h">博主信息 </header>
                <div class="ms-info-bx">
                    <img src="./images/logo.jpeg" alt="博主头像" class="ms-info-logo">
                    <span class="ms-info">笔名：乐余地</span>
                    <span class="ms-info">职业：前端狗</span>
                    <span class="ms-info">格言：不要怕难</span>
                    <span class="ms-info">邮箱：admin@leridy.pw</span>
                    <span class="ms-info">博客：www.leridy.pw/blog</span>
                </div>
            </aside>
            <aside class="widget widget-tag">
                <header class="widget-h">标签</header>
                <div class="w-tag-grp">
                    <a href="#" class="w-tag">今日新闻</a>
                    <a href="#" class="w-tag">做博客</a>
                    <a href="#" class="w-tag">真好玩</a>
                    <a href="#" class="w-tag">长知识</a>
                    <a href="#" class="w-tag">9524</a>
                    <a href="#" class="w-tag">公益</a>
                    <a href="#" class="w-tag">前端知识</a>
                    <a href="#" class="w-tag">末日谣言</a>
                    <a href="#" class="w-tag">跑男</a>
                    <a href="#" class="w-tag">离南京</a>
                    <a href="#" class="w-tag">西更饿</a>
                    <a href="#" class="w-tag">明天加油</a>
                    <a href="#" class="w-tag">今日新闻</a>
                    <a href="#" class="w-tag">做博客</a>
                    <a href="#" class="w-tag">真好玩</a>
                    <a href="#" class="w-tag">长知识</a>
                    <a href="#" class="w-tag">9524</a>
                    <a href="#" class="w-tag">公益</a>
                    <a href="#" class="w-tag">前端知识</a>
                    <a href="#" class="w-tag">末日谣言</a>
                    <a href="#" class="w-tag">跑男</a>
                    <a href="#" class="w-tag">离南京</a>
                    <a href="#" class="w-tag">西更饿</a>
                    <a href="#" class="w-tag">明天加油</a>
                    <a href="#" class="w-tag">今日新闻</a>
                    <a href="#" class="w-tag">做博客</a>
                    <a href="#" class="w-tag">真好玩</a>
                    <a href="#" class="w-tag">长知识</a>
                    <a href="#" class="w-tag">9524</a>
                </div>
            </aside>
            <aside class="widget widget-random-post">
                <header class="widget-h">随机推荐</header>
                <ul class="w-rpost">
                    <li class="w-rpost-item"><a href="#" title="1">占位文章标题</a></li>
                    <li class="w-rpost-item"><a href="#" title="2">占位文章标题</a></li>
                    <li class="w-rpost-item"><a href="#" title="3">占位文章标题</a></li>
                    <li class="w-rpost-item"><a href="#" title="4">占位文章标题</a></li>
                    <li class="w-rpost-item"><a href="#" title="5">占位文章标题</a></li>
                    <li class="w-rpost-item"><a href="#" title="6">占位文章标题</a></li>
                </ul>
            </aside>
            <aside class="widget widget-donate">
                <header class="widget-h">捐赠博主</header>
                <img src="<?php echo $GLOBALS['location'] ?>images/zhbewm.png" class="w-zhbewm">
                <span class="w-note">你的资助将会让博客建设的更加完善</span>
            </aside>
		<?php
echo "</div>";
	}
	//__CALL函数的定义
	/*	public function __call($method, $data) {
		if ($method == "DisplayMainContent") {
			if (is_array($data)) {
				$this->DisplayArticle($data);
			} elseif ($data = null) {
				$this->DisplayMainStaticContent();
			}
		}
	}*/
	//获取数据库操作的对象
	public function touchDatabase() {
		return new TouchSql;
	}

	public function DisplayFooter() {
		echo "
        <!--这是自动输出的底部-->
        <footer id=\"footer\">
            <nav class=\"ft-links\">
                <a href=\"#\" class=\"ft-link\">版权声明 </a> ||
                <a href=\"#\" class=\"ft-link\"> 友情链接 </a> ||
                <a href=\"http://www.leridy.pw/blog\" class=\"ft-link\"> LERIDY'S BLOG</a> ||
                <a href=\"http://www.cys.pw\">MARCUS BLOG</a>
            </nav>
            <div class=\"copyright\">
                <span class=\"ft-note\">&copy;2016, <a href=\"http://www.leridy.pw/blog\"> Leridy.pw </a> ALL RIGHTS RESERVED</span>
                <span class=\"ft-note\">POWER BY <i class=\"fa fa-cogs\"></i> LERIDY_LEI,DESIGN BY LERIDY_LEI</span>
            </div>
        </footer>";
	}
//类的大括号
}

?>