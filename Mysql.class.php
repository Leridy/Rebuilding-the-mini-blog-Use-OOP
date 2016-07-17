<?php
require_once 'config.php';
/**
 * define the Mysql class,it just for mysql
 */
class TouchSql {
	//数据库链接的回执
	private $LinkKey;
	//数据库才查询的结果
	private $SqlResult;
	//查询结果的数量
	private $SqlResultNum;
	//格式化完全后的结果转换为数组的结果
	public $data;
	//链接上mysql服务器
	public function LinkDatabase() {
		if (!($this->LinkKey = mysqli_connect(HOST, USERNAME, PASSWORD,'b_article'))) {
			echo mysqli_error($this->LinkKey);
		}
/*		if (!mysqli_select_db($this->LinkKey,'b_article')) {
			echo mysqli_error();
		}*/
		if (!mysqli_query($this->LinkKey,'set names utf8')) {
			echo mysqli_error($this->LinkKey);
		}
	}
	//释放数据库连接
	public function DropDatabase() {
		mysqli_close($this->LinkKey);
	}
	//查询Mysql
	public function SelectSql($sql) {
		//echo $sql."<br/>";
		$this->SqlResult = mysqli_query($this->LinkKey,$sql);
		//echo $this->SqlResult."<br>";
		@$this->SqlResultNum = mysqli_num_rows($this->SqlResult);
	}
	//获取查询返回值并生成数组
	public function HandleResult() {
		unset($this->data);
		if ($this->SqlResult && $this->SqlResultNum) {
			while ($row = mysqli_fetch_assoc($this->SqlResult)) {
				$this->data[] = $row;
				//var_dump($this->data);
			}
		} else {
			$this->data = null;
			//echo $this->data."11<br>";
		}
	}

	//构造函数
	function __construct() {
		# code...
	}

	function __set($name, $value) {
		$this->$name = $value;
	}

	/**
	 * @return mixed
	 */
	public function getSqlResultNum() {
		return $this->SqlResultNum;
	}

}
?>