<?php
//error_reporting(0); //打开报错:去行首双斜杠

/*
保留版权信息前提下可以二次分享、商用、二开
作者联系方式: 15058593138@qq.com (手机号可加微)
*/

$pubs = array();
$pubs["dbhost"] = "localhost";		//数据库地址本地localhost
$pubs["dbuser"] = "file_chalide_cn";	//数据库账号
$pubs["dbpass"] = "TnaadfhzmSj887MPi";	//数据库密码
$pubs["dbname"] = "file_chalide_cn";	//数据库名称
$pubs["dbport"] = "3306";		//数据库端口号
$pubs["dbcode"] = "UTF8";		//数据库编码  UTF8 GB2312
$pubs["dbbiao"] = "chalide_share";	//数据表

$zhanname = "个人自用文件上传分享系统";
$pasx="chalidemima"; //admin.php操作密码(搜索框输入)

$tp=[];
$tp["filedoma"]="个性域名";
$tp["filename"]="文件名称";
$tp["filepath"]="存储路径";
$tp["filemimi"]="文件hash";
$tp["filemama"]="下载密码";
$tp["filesize"]="文件大小";
$tp["fileipip"]="提交IP";
$tp["chacheck"]="文件状态";
$tp["timeupup"]="上传时间";


$isupi = ".jpg,.png,.zip,.rar";		//demo:.jpg,.png 逗号隔开
$lenxi = "4096";			//单位kb,demo:1024
$imgdir= "./data/";			//建议只改英文部分data为你的存放文件夹名称,检查读写权限
$iback = "filedoma-filename-timeupup-filemama"; //

$iport = $_SERVER['SERVER_PORT'];
$indes = $_SERVER['SCRIPT_NAME'];
$inder = dirname($_SERVER['PHP_SELF']);
$ihost = $_SERVER['HTTP_HOST'];
if(stristr("-443-","-$iport-")){
$ihosts = "https://$ihost{$inder}";
}elseif(stristr("-80-","-$iport-")){
$ihosts = "http://$ihost{$inder}";
}else{
$ihosts = "http://$ihost:{$iport}{$inder}";
}
$ihosts = Rtrim($ihosts,"/")."/";
$iimg = Trim($imgdir,".");
$iwei = "location / {
rewrite ^$inder/([a-zA-Z0-9_\-]+)\.([a-zA-Z0-9_\-]+)$ $inder/?cx=$1.$2 last;
}

location ~ ^$inder$iimg
{
return 404;
}
";
$iwei = str_replace('//', '/', $iwei);
function cenn(){
global $pubs;
foreach ($pubs as $ti=>$val) $$ti = $val; //调用
if (!$dbhost && !$dbuser){ exit("请先修改数据库信息!"); }
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport);
if (!$conn){ die("连接失败(请检查数据库配置信息): " . mysqli_connect_error()); }
return $conn;
}

function doconn($domas,$daconn){
global $dbbiao; $conn = cenn(); 
$sqlc = "select * from `$dbbiao` Where `filedoma`='{$domas}' LIMIT 1";
$resu = mysqli_query($conn, $sqlc);
while($row = mysqli_fetch_assoc($resu)){
//file_put_contents($daconn.".inc", json_encode($row,JSON_PRETTY_PRINT));
return $row["filemama"];
}
return null;
}

function webtable($Key,$tima=""){
$html ="<table cellspacing=\"0\" class=\"taba\">\r\n<tbody>";
$html.="<tr><td data-label=\"{$tima}\"><div class='l'>$Key</div></td></tr>";
$html.="</tbody></table>";
echo $html;
}

function webdown($file,$mima="88888888"){
global $imgdir; 
$dadirs = $imgdir.substr($file,0,6)."/".$file;
if(!file_exists($dadirs)){ header("HTTP/1.1 404 Not Found");exit;}
$mamar = doconn($file,$dadirs);
if($mamar!=$mima && $mamar!=null){header('HTTP/1.1 403 Forbidden'); exit;}
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Length: ' . filesize($dadirs));
readfile($dadirs);
exit();
}