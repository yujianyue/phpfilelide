<?php
 include "./inc/conn.php";

//本文件首次使用：以后建议更名为只有自己知道的名称；或直接删除

foreach ($pubs as $ti=>$val) $$ti = $val; //调用
function dobiao($conn, $sqlu){
$resu = mysqli_query($conn, $sqlu);
if (!$resu){ 
$ersms = mysqli_error($conn); $smser = "创建表出错：";
if(stristr("@".$ersms,"@Duplicate entry")){ $smser = "表已存在：";}
echo "<p>{$smser}$ersms</p>";
}else{
echo "<p>创建表成功</p>";
}
}

$blist = "CREATE TABLE `{$dbbiao}` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`filedoma` varchar(32) COMMENT '个性域名' NOT NULL DEFAULT '',
`filename` varchar(64) COMMENT '文件名称' NOT NULL DEFAULT '',
`filepath` varchar(64) COMMENT '存储路径' NOT NULL DEFAULT '',
`filemimi` varchar(64) COMMENT '文件hash' NOT NULL DEFAULT '',
`filemama` varchar(32) COMMENT '访问密码' NOT NULL DEFAULT '',
`filesize` varchar(32) COMMENT '文件大小' DEFAULT '',
`fileipip` varchar(128) COMMENT '提交IP' DEFAULT '',
`chacheck` int(2) COMMENT '查询状态' NOT NULL DEFAULT '1',
`timeupup` datetime COMMENT '上传时间' DEFAULT CURRENT_TIMESTAMP,
UNIQUE KEY filedoma (`filedoma`),
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000001 DEFAULT CHARSET=utf8;";

$conn = cenn(); 
dobiao($conn, $blist);
?>