<?php
 include "./inc/conn.php";

foreach ($pubs as $ti=>$val) $$ti = $val; //调用

$pagesize=10;
$maxp = 20;
$title = "无名查询系统后台管理";

$b = array();
$b[$dbbiao]["name"]= "查询列表";
$b[$dbbiao]["id"] = "id"; //ID唯一自增字段
$b[$dbbiao]["duan"]= "filedoma,filename,filesize,filepath,fileipip,chacheck,timeupup";
$b[$dbbiao]["bgai"]= "filemimi,filesize,filepath,fileipip,timeupup"; //不改
$b[$dbbiao]["sox"] = "filedoma,filename";

$c[$dbbiao]["chacheck"] = "0`不可下载|1`默认状态|2`可以下载";

$biao = (isset($_GET['biao']))?addslashes($_GET['biao']):$dbbiao;
$acts = (isset($_GET['Act']))?addslashes($_GET['Act']):"";

function doxuan($tdb,$mname,$mvals){
if(!stristr($tdb,"`") || !stristr($tdb,"|")) return "<option value=\"\">无效参数</option>";
$t1db = explode("|",$tdb);
$dox="<select name=\"$mname\" id=\"$mname\" class=\"txtu\">\r\n";
foreach($t1db as $t2db){
if(stristr($t2db,"`")){
$t3db = explode("`",$t2db); $t4d = $t3db[0]; $t5d = $t3db[1];
if("s".$mvals=="s".$t4d){$sled = " selected";}else{$sled = "";}
$dox.="<option value=\"{$t4d}\"{$sled}>[{$t4d}]$t5d</option>\r\n";
}
}
return $dox."</select>\r\n";
}
function readbiao($biao,$idas,$ids){
$conn = cenn();
$sqlc = "select * from `{$biao}` Where `$idas`='{$ids}' LIMIT 1";
$resu = mysqli_query($conn, $sqlc);
while($row = mysqli_fetch_assoc($resu)){ return $row;}
return null;
}
if($acts != ""){
$idas = $b[$dbbiao]["id"]; $bgai = $b[$dbbiao]["bgai"];
$biao = (isset($_POST['biao']))?addslashes($_POST['biao']):$dbbiao;
$search = (isset($_POST["rame"]))?addslashes($_POST["rame"]):'';
$sort = (isset($_POST['sort']))?addslashes($_POST['sort']):$idas;
$order = (isset($_POST['orda']))?addslashes($_POST['orda']):"desc";
$duan = (isset($_POST['duan']))?addslashes($_POST['duan']):"All";
$ider = (isset($_POST['id']))?addslashes($_POST['id']):"";
if(!stristr("--","-$acts-")){ //不需要密码操作判断
$pasword = (isset($_COOKIE["limi"]))?addslashes($_COOKIE["limi"]):'';
if("^$search^" == "^$pasx^"){
 setcookie('limi',md5("^$domas@$pasx@$domas^"),time()+60*60*24*1,"/"); 
 header('x-power-id: shua');
 exit("鉴权成功:可以继续输入查询了!");
}elseif(md5("^$domas@$pasx@$domas^") != $pasword){
 exit("请先登录(右上角进入)!");
}elseif("^$search^" == "^logout^"){
 setcookie('limi',md5("^$domas@$ttam@$domas^"),-time()+60*60*24*1,"/"); 
 header('x-power-id: shua');
 exit("退出成功!");
}elseif("^$search^" == "^^"){
 //exit("请输入关键词!");
}else{ 
}
}

switch ($acts) {
case "more": //详情
if(!is_numeric($ider)) exit("ID无效");
$conn = cenn();  $infe=""; $jjj=0;
$sqlc = "select * from `{$biao}` Where `$idas`={$ider} LIMIT 1";
$resu = mysqli_query($conn, $sqlc);
while($info = mysqli_fetch_assoc($resu)){ $infe = $info;}
if($infe=="") exit("读取ID{$id}信息失败");
echo "<!--tips--><table cellspacing=\"0\" class=\"taba\">";
    echo "<caption><input name=\"S\" type=\"submit\" value=\"刷新\" onclick=\"more($ider,'more');\"></caption>";
$jjj=0;
foreach($infe as $ti=>$zi){
$mu = $ti; $jjj++; $ii = $infe[$idas]; $ix = $infe[$idas]."_".$jjj;
echo "<tr><td>$mu</td><td>{$tp[$mu]}</td><td align=\"left\" id=\"a{$ix}_2\">$zi</td><td>";
if(!stristr(",$idas,$bgai,",",{$ti},")){
echo "<a href='#' onclick='adit(\"{$ix}\")' id=\"a{$ix}_5\"><b>修改</b></a>";
}
echo "</td><td id=\"add{$ix}\" style=\"display:none;\">\r\n";
if(!stristr(",$idas,$bgai,",",{$ti},")){
echo "<table cellspacing=\"0\" class=\"table\"> \r\n";
echo "<tr><td class=\"r\" id=\"a{$ix}_3\">输入{$mu}</td>";
echo "<td class=\"l tttt\" id=\"a{$ix}_4\"><input name=\"nval\" type=\"text\" class=\"txtr\" id=\"nval{$ix}\" value=\"{$zi}\" placeholder=\"请输入{$mu}\" />";
echo "<input name=\"oval\" id=\"oval{$ix}\" type=\"hidden\" value=\"{$zi}\" />";
echo "<input name=\"duan\" id=\"duan{$ix}\" type=\"hidden\" value=\"{$ti}\" />";
echo "<input name=\"idid\" id=\"idid{$ix}\" type=\"hidden\" value=\"{$ii}\" />";
echo "<input name=\"S\" type=\"submit\" value=\"提交\" onclick=\"duan('dgai','$ix')\"></td>";
echo "</tr></table>\r\n";
}
echo "</td></tr>\r\n";
$ix++;
}
echo "</table>";
break;

case "dgai": //修改内容
$po = $_POST;
foreach($po as $ti=>$val){
if(stristr("@$ti","@idid")) $idid = addslashes($val); //id
if(stristr("@$ti","@duan")) $duan = addslashes($val); //字段
if(stristr("@$ti","@oval")) $oval = addslashes($val); //旧内容
if(stristr("@$ti","@nval")) $nval = addslashes($val); //新内容内容
}
if($oval == $nval){exit("未修改，两次值未变化! ");}
if(stristr(",$idas,$bgai,",",{$duan},")){ exit("该字段不可修改($bgai)!");}
$sqlc = "UPDATE `$biao` SET `$duan`='{$nval}' WHERE `$idas`={$idid}";
$conn = cenn();
$resu = mysqli_query($conn, $sqlc);
if (!$resu){
echo "更新失败：".mysqli_error($conn);
}else{
 header('x-power-id: cha');
echo "更新字段{$duan}成功!";
}
break;

case "down":
webdown($file,$mima="88888888");
break;

case "sare": //分享
if(!is_numeric($ider)) exit("ID无效");
$conn = cenn();  $infe=""; $jjj=0;
$sqlc = "select * from `{$biao}` Where `$idas`={$ider} LIMIT 1";
$resu = mysqli_query($conn, $sqlc);
while($info = mysqli_fetch_assoc($resu)){ $infe = $info;}
if($infe=="") exit("读取{$idas}:{$id}信息失败");
echo "<h3>分享内容(未伪静态)</h3>";
echo "<textarea>下载网址:{$ihosts}?cx={$infe["filedoma"]}\r\n提取文件名:{$infe["filedoma"]}\r\n提取密码:{$infe["filemama"]}</textarea>";
echo "<h3>分享内容(已伪静态)</h3>";
echo "<textarea>下载网址:{$ihosts}{$infe["filedoma"]}\r\n提取文件名:{$infe["filedoma"]}\r\n提取密码:{$infe["filemama"]}</textarea>";
echo "<h3>直接路径(别防下载)</h3>";
$rurl = rtrim($ihosts,"/")."".ltrim($infe["filepath"],".");
echo "<textarea>下载网址:{$rurl}\r\n提取文件名:{$infe["filedoma"]}\r\n提取密码:{$infe["filemama"]}</textarea>";
echo "<h3>Nginx伪静态设置(前一段网址伪静态、后一段文件夹下防下载)</h3>";
echo "<textarea>$iwei</textarea>";
break;

case "dels": //删除+删文件
if(!is_numeric($ider)) exit("ID无效");
$conn = cenn();  $infe=""; $jjj=0;
$sqlc = "select * from `{$biao}` Where `$idas`={$ider} LIMIT 1";
$resu = mysqli_query($conn, $sqlc);
while($info = mysqli_fetch_assoc($resu)){ $infe = $info;}
if($infe=="") exit("删除失败：ID{$id}信息不存在!");
if(file_exists($info["filepath"])){ @unlink($info["filepath"]); echo "@"; }
$sqlc = "DELETE FROM `{$biao}` WHERE `$idas`={$ider}";
$resu = mysqli_query($conn, $sqlc);
if (!$resu){
echo "删除出错：".mysqli_error($conn);
}else{
header('x-power-id: cha');
echo "单删{$ider}成功!";
}
break;

case "ztai": //修改状态
$ids =(isset($_POST["id"]))?addslashes($_POST["id"]):'';
if($ids=="" || !is_numeric($ids)) exit("ID传递失败无效");
$dus =(isset($_POST["duen"]))?addslashes($_POST["duen"]):'';
$row = readbiao("chalide_share",$idas,$ids);
if(!$row) exit("读取{$biao}:{$ids}信息失败!");
$domas = $row["filedoma"]; $check = $row["chacheck"];
if($c[$biao][$dus]){
$ival = doxuan($c[$biao][$dus],"nval".$ids,$check);
}else{
$ival ="<input name=\"nval{$ids}\" type=\"text\" id=\"nval{$ids}\" value=\"{$check}\" />";
}
echo <<<EOT
<input type="hidden" id="idid{$ids}" value="{$ids}" />
<input type="hidden" id="oval{$ids}" value="{$check}" />
<input type="hidden" id="duan{$ids}" value="{$dus}" />
<table cellspacing="0" class="taba">
<caption>$domas</caption>
<tr><td width='80'>当前</td><td>$check</td></tr>
<tr><td>修改为</td><td>$ival</td></tr>
<tr><td>&nbsp;</td><td><input value="提交" type="submit" class="txtt"  onclick="duan('dgai','$ids')" />
<input name="S" type="submit" value="刷新" onclick="ztai($ids,'ztai','$dus');">
</td></tr>
</table>
<div id="tone"></div>
EOT;
break;

case "cha":
 $iduan = $b[$biao]["duan"]; $sox = $b[$biao]["sox"];
 $duanx=explode(",", $iduan);
 $duans = "`$idas`, `".join("`,`",$duanx)."`";
 $soxs=explode(",", $sox);
if (!stristr("-desc-asc-","-$order-")) $order = "DESC";
if (!stristr(",$iduan,","-$sort-")) $sort=$soxs[0]; 
$conn = cenn();
$sql = "SELECT $duans FROM `{$biao}` ";
$tips = "字段[{$duan}]";
$sqlw = "WHERE `{$duan}` LIKE '%$search%' ";
$sql .= "$sqlw ORDER BY $sort $order ";
$sqc = "SELECT COUNT(*) AS count FROM {$biao} $sqlw ";
$result = $conn->query($sqc);
$row = $result->fetch_assoc();
$count = $row["count"];
if($count<1) exit("查 表[$biao] => $tips => 关键词[$search]无结果");
$pagecount = ceil($count / $pagesize);
$page = 1;
if (isset($_POST["page"])) { $page = $_POST["page"];}
if ($page < 1) { $page = 1;}
if ($page > $maxp) { exit("[Most <b>$maxp</b> Page]");}
if ($page > $pagecount) { $page = $pagecount;}
if ($pagecount > $maxp) { $pagecount = $maxp;}
$start = ($page - 1) * $pagesize;
$end = $start + $pagesize;
$sql .= " LIMIT $start, $pagesize";
$result = $conn->query($sql);
if (!$result) exit("连接失败信息:".mysqli_error($conn));
echo "<table cellspacing=\"0\">";
$guanli = "";
foreach ($result as $i=>$row) {
$liid = $row[$idas]; //得有ID字段
echo "\r\n<!--".$row["filepath"]."-->\r\n";
$row["guanli"] = "<a href='#' onclick=\"more($liid,'more');\">改</a>&nbsp;";
$row["guanli"] .= "<a href='#' onclick=\"more($liid,'dels','alert');\">删</a>&nbsp;";
$row["guanli"] .= "<a href='#' onclick=\"more($liid,'sare');\">下</a>";
$row["chacheck"] = $row["chacheck"]."<br><button onclick=\"ztai($liid,'ztai','chacheck');\">选</button>";
if(file_exists($row["filepath"])){$row["filepath"]="OK"; }else{$row["filepath"]="不存在";}
if(!$isti){
echo "<tr class='tt'>\r\n<th>".join("</th>\r\n<th>",array_keys($row))."</th>\r\n</tr>\r\n";
$isti="Y";
}
 echo "<tr>\r\n<td>".join("</td>\r\n<td>",$row)."</td>\r\n</tr>\r\n";
}
echo "</table>";
echo "<p>结果: $count, 页数: $pagecount \r\n";
if ($page > 1) { echo "<a href='#' onclick=\"show(1,'');\">首页</a> ";}
for ($i = 1; $i <= $pagecount; $i++) {
 if($i == $page){ echo "$i ";}else{ echo "<a href='#' onclick=\"show($i,'');\">$i</a> ";}
}
if ($page < $pagecount) { echo "<a href='#' onclick=\"show($pagecount,'');\">尾页</a> ";}
if($count> $maxp*$pagesize) echo "结果{$count}较多:推荐优化输入!";
echo "</p>";
$conn->close();
break;

default:
echo "[{$acts}]你想干嘛呢?";
}

exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Arial,sans-serif;font-size:14px;line-height:1.5;background-color:#eee}
header{display:flex;justify-content:space-between;align-items:center;background-color:#333;color:#fff;padding:5px 10px;}
.logo{font-size:16px;}
a {text-decoration:none;}
p{color:green;} b{color:blue;}
nav ul{display:flex;}
nav li{list-style:none;margin-left:10px;}
nav a{color:#fff;text-decoration:none;padding:5px;}
nav a:hover{background-color:#fff;color:#333}
.search{display:flex;justify-content:space-between;align-items:center;background-color:#fff;padding:10px;margin:10px 0;}
.search select{flex:1;padding:4px;}
.search input{flex:5;padding:5px;border:1px solid #ccc;margin-right:5px;}
.captcha{flex:2;display:flex;border:1px solid #ccc;align-items:center;margin-right:5px;}
.captcha input{border:0;padding:5px;margin-right:0px;}
.captcha img{height:22px;}
button{flex:1;background-color:#333;color:#fff;border:none;padding:4px 6px;cursor:pointer;}
button:hover{background-color:green;color:white;}
.content{background-color:#fff;padding:10px;min-height:360px;margin-bottom:88px;overflow-x:auto;}
input[type=text]{margin:1px 0;height:28px;width:calc(99% - 80px);border:1px solid #ccc;}
input[type=submit]{margin:1px 0;padding:1px 2px;height:28px;color:white;background:#0180CF;}
  select{margin:1px 0;height:28px;width:calc(99% - 80px);border:1px solid #ccc;}
.description{font-weight:bold;margin-bottom:10px;border-radius:3px;}
table{width:100%;border-collapse:collapse;}
table td,table th{padding:5px 0;border:1px solid #ccc;}
table th{background-color:#ddd;font-weight:bold;}
footer{display:flex;justify-content:space-between;font-size:12px;align-items:center;background-color:#333;color:#fff;padding:5px;position:fixed;bottom:0;width:100%;}
.footer div{margin-right:20px;}
.right a{color:#fff;text-decoration:none;}
.right a:hover{text-decoration:underline;}
textarea{width:calc(99.7% - 20px);height:8vh;}
.modal{display:none;margin:0 auto;padding-top:40px;position:fixed;top:0px;width:100%;height:100%;}
.modal{z-index:3;overflow:auto;background-color:rgba(0,0,0,0.4);}
.mainc{display:none;width:calc(99.7% - 20px);border-radius:3px;margin:0 auto;background-color:#fff;}
.mainc{position:fixed;left:10px;top:10px;min-height:79vh;z-index:8;}
#tiper{margin:0 auto;width:calc(99.7% - 20px);border-radius:3px;min-width:299px;min-height:77vh;overflow:auto;padding:8px;}
.close{text-decoration:none;float:right;font-size:24px;background-color:red;color:white;}
.close:hover,.close:focus{cursor:pointer;}
@media screen and (max-width:656px){.search select,.search input,.search captcha,.search button{display:block;width:99.9%;}
}
</style>
</head>
<body>
  <header>
    <div class="logo"><?php echo $title; ?></div>
    <nav>
      <ul>
<?php
foreach ($b as $tt=>$vvv) {
echo "\t\t<li><a href=\"?biao=$tt\">{$vvv["name"]}</a></li>\r\n";
}
//echo "\t\t<li><a href=\"?Act=logs\">登录</a></li>\r\n";
?>
      </ul>
    </nav>
  </header>
  <div class="search">
<select name="duan" id="duan" onchange="show(1,'');">
<?php
$sox = $b[$biao]["sox"];
$soxs=explode(",", $sox); $ia = count($soxs);
for($ii=0; $ii<$ia; $ii++){
$duen=$soxs[$ii]; echo "<option value=\"$duen\">$duen</option>\r\n";
}
?>
</select>
    <input type="text" id="rame" placeholder="输入关键词" onfocus="this.select();">
    <button onclick="show(1,'');">立即查找</button>
  </div>
<div class="set" style="display:none;">
  <input type="hidden" id="biao" value="<?php echo $biao; ?>">
  <input type="hidden" id="page" value="1">
  <input type="hidden" id="sort" value="id">
  <input type="hidden" id="orda" value="DESC">
  <input type="hidden" id="Act" value="cha">
</div>
<div class="mainc" id="mainc">
 <span onclick="closeDiv()" class="close">&times;</span>
 <div id="tiper"></div>
</div>
  <div class="content">
  <div class="description">查询结果</div>
  <div id="UpTip"></div>
  </div>
  <footer>
    <div class="left">版权所有 © 2021</div>
    <div class="mid">备案号：123456789</div>
    <div class="right"><a href="#">返回顶部</a></div>
  </footer>
</body>
<script>
// 返回顶部按钮
var btn = document.querySelector('.right a');
btn.addEventListener('click', function() {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});
</script>
<script>
function $(objId){ return document.getElementById(objId);}
var timer = null;  //延时1秒自动查，延时与中文输入节能
var Inputs = document.querySelector('#rame');
Inputs.addEventListener('input', function(e) {
 var keyword = e.target.value;
  if (timer) { clearTimeout(timer);}
  timer = setTimeout(function() { show(1,keyword); }, 1000);
});
const thList = document.querySelectorAll('.set');
thList.forEach((th, index) => {
 console.log(th, index);
 th.addEventListener('onChange', () => { show(1,""); });
});
function tips(iir) {
$('mainc').style.display='block';
$('bg').style.display='block';
}
function closeDiv(){
$("tiper").innerHTML = "";
$('mainc').style.display='none';
$('bg').style.display='none';
}

function ztai(id,key,duan){
var fd = new FormData();
fd.append('id',id);
fd.append('biao',$("biao").value);
fd.append('duen',duan);
post(key, fd, 'tiper');
}
function duan(key,id){
if($("oval"+id).value==$("nval"+id).value){
alert("未提交：提交值无变动!"); return false;
}
var fd = new FormData();
fd.append('oval',$("oval"+id).value);
fd.append('nval',$("nval"+id).value);
fd.append('duan',$("duan"+id).value);
fd.append('idid',$("idid"+id).value);
fd.append('biao',$("biao").value);
post(key, fd, 'alert');
}
function more(id,key,tper="tiper"){
var fd = new FormData();
fd.append('id',id);
var act = key; 
post(act, fd, tper);
//tips();
}
function adit(iir) {
$("a"+iir+"_2").innerHTML = $("a"+iir+"_4").innerHTML;
}
function duan(key,id){
if($("oval"+id).value==$("nval"+id).value){
 alert("未提交：提交值无变动!"); return false;
}
var fd = new FormData();
fd.append('oval',$("oval"+id).value);
fd.append('nval',$("nval"+id).value);
fd.append('duan',$("duan"+id).value);
fd.append('idid',$("idid"+id).value);
var act = key; 
post(act, fd, 'alert');
show(1,'');
}
function show(page,key){
if(page!= "") $("page").value = page;
if(key != "") $("rame").value = key;
var fd = new FormData();
fd.append('rame',$("rame").value);
fd.append('biao',$("biao").value);
fd.append('orda',$("orda").value);
fd.append('page',$("page").value);
fd.append('sort',$("sort").value);
fd.append('duan',$("duan").value);
fd.append('Act',$("Act").value);
var act = $("Act").value;
post(act,fd,'UpTip');
}
function post(act,fd,hid){
var cType = "";
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(){
if(xhr.readyState == 4){
if(xhr.status == 200){
cType = xhr.getResponseHeader('x-power-id');
if(hid == "alert"){ alert(xhr.responseText);}else{$(hid).innerHTML=xhr.responseText;}
if(cType == "cha"){ show("","");}
if(cType == "shua"){window.location.replace("?t="+Math.random());}
}
}
};
if(hid == "tiper"){ tips();}

xhr.open('POST','?Act='+ act + '&vi='+Math.random(),true);
xhr.send(fd);
}
</script>
<div id="bg" class="modal" onclick="closeDiv()"></div>
</html>
