<?php
include "./inc/conn.php";
foreach ($pubs as $ti=>$val) $$ti = $val; //调用
//作者联系方式: 15058593138@qq.com (手机号可加微)
$daynow = date("Y-m-d");
$shinow = date("H:i:s");
$fire = (isset($_GET['cx']))?addslashes($_GET['cx']):'';
if($_GET['act']=="do"){
$file = (isset($_POST['file']))?addslashes($_POST['file']):$fire;
$mima = (isset($_POST['mima']))?addslashes($_POST['mima']):'';
webdown($file,$mima);
}

if($_GET['act']=="up"){
if($_POST["id"]){
$pimg = (isset($_POST['id']))?addslashes($_POST['id']):'';
$ptps = (isset($_POST['tp']))?addslashes($_POST['tp']):'';
$filex = $_FILES['file'];
if ($filex["error"] > 0){
echo "<h3>上传失败：</h3>,错误原因:".$filex['error'];
}else{
$info = pathinfo($filex["name"]); $tape = $info['extension'];
if(!stristr(",{$isupi},",",.{$tape},")){exit("<h3>上传失败</h3>后缀[.{$tape}]不支持!");}
if($filex["size"]>$lenxi*1024){ exit("<h3>上传失败：</h3>文件大小超过允许值{$lenx}KB!");}
$fileName = $imgdir.date("Ym")."/".date("Ymd")."_".uniqid().".".$tape;
//自动创建文件夹
$foldw = dirname($fileName);
if(!is_dir($foldw)){ @mkdir($foldw, 0755, true);}

move_uploaded_file($filex["tmp_name"], $fileName);
if (!file_exists($fileName)){ exit("<h3>转存失败</h3>请检查文件夹读写权限！");}

$filemama = rand(11110000,99998888);
$sx = [];
$sx["filedoma"]=basename($fileName);//个性域名:见于网址
$sx["filename"]=$filex["name"];//文件名称:上传时候文件名
$sx["filepath"]=$fileName;//存储路径
$sx["filemimi"]=sha1_file($fileName);//文件hash
$sx["filemama"]=$filemama;//文件hash
$sx["filesize"]=filesize($fileName);//文件大小
$sx["fileipip"]=$_SERVER['REMOTE_ADDR'];//提交IP
$tis = ""; $vals = "";
foreach($sx as $ti=>$val){
$tis .= "`{$ti}`,"; $vals .= "'".addslashes($val)."',";
}
$tis = Trim($tis,","); $vals = Trim($vals,",");
echo "<h3>上传成功</h3>";
$conn = cenn();
$sqlu = "INSERT IGNORE INTO `{$dbbiao}` ($tis) VALUES ({$vals})";
$resu = mysqli_query($conn, $sqlu);
if (!$resu){ $ersms = mysqli_error($conn); echo "上传入库失败!".$ersms;}
$sz = []; //以下网址1/2自己2选1
$sz['下载网址1'] = $ihosts."".$sx["filedoma"];
$sz['下载网址2'] = $ihosts."?cx=".$sx["filedoma"];
$sz['下载密码'] = $filemama;
$sz['文件名称'] = $sx["filename"];
foreach($sz as $ti=>$val){ echo "<p>{$ti} -> <b>$val</b></p>";}
}
}
exit();
}

$isupx = str_replace(",", "|", $isupi);
$ihtml = date("Ymd");
?>
<!DOCTYPE html>
<html>
<head>
 <title><?php echo $zhanname;?></title>
 <style type="text/css">
  body {
   font-family: Arial, sans-serif;
   font-size: 14px;
   background-color: #f2f2f2;
  }
  h3{
   margin: 0;
   font-size: 18px;
   line-height: 1.8;
  }
  p{
   margin: 0;
   font-size: 14px;
   line-height: 1.5;
  }
 .container {
   margin: 50px auto;
   padding: 20px 20px 50px 20px;
   background-color: #fff;
   border-radius: 5px;
   box-shadow: 0 0 10px rgba(0,0,0,0.3);
   max-width: 678px;
  }
  #mask{
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background-color: rgba(0,0,0,0.5);
   display: none;
  }
  #dialog{
   position: fixed;
   top: 50%;
   left: 50%;
   min-width: 300px;
   transform: translate(-50%,-50%);
   background-color: #fff;
   padding: 20px;
   border-radius: 5px;
   box-shadow: 0 0 10px rgba(0,0,0,0.5);
   display: none;
  }
  #dialog .btn, .bts{
   display: flex;
   float: left;
   padding: 5px 8px;
   background-color: #007bff;
   color: #fff;
   border-radius: 3px;
   cursor: pointer;
   margin: 10px 10px 10px 0;
  }
  #dialog .btn:hover, .bts:hover{
   background-color: #0069d9;
  }
  #dialog #file,#dialog #mima{
   line-height: 30px;
   width: 78%;
   min-width: 280px;
  }
  #dialog .btn:last-child{
   margin-right: 0;
  }
  #rest{
   color: red;
  }
 </style>
</head>
<body>
<div class="container">
 <h3>自用版文件上传分享功能</h3>
 <p>上传文件后得到下载网址及密码,将这些内容分享给他人下载!</p>
 <p>技巧：多文件可压缩包上传!</p>
  <div style="margin-bottom:20px;display:block;">
 <button onclick="upfile('<?php echo $ihtml;?>')" class="bts">上传</button>
 <button onclick="dofile()" id="dxia" class="bts">下载</button>
 </div>
<input type="hidden" id="id" value="101">
<input type="hidden" id="tp" value="zip">
<input type="file" id="file<?php echo $ihtml;?>" accept="<?php echo $isupi; ?>" onchange="selfile('<?php echo $ihtml;?>');" style="display:none;">
<div id="downx" style="display:none;">
 <button class="btn" id="ok" onclick="godown()">确定</button>
 <button class="btn" id="cancel" onclick="hideDialog()">取消</button>
</div>
<div id="downy" style="display:none;">
 <button class="btn" id="ok" onclick="hideDialog()">确定</button>
</div>
<textarea id="downz" style="display:none;">
<p><input type="text" id="file" placeholder="请输文件名" value="<?php echo $fire; ?>" ></p>
<p><input type="password" id="mima" placeholder="请输入提取码" value="" autocomplete="off"></p>
<p id="rest"></p>
</textarea>
</div>
 <div id="mask"></div>
 <div id="dialog">
  <div id="content"></div>
  <div id="buts"></div>
 </div>
 <script type="text/javascript">
  function $(objId){
   return document.getElementById(objId);
  }
  var mask = $('mask');
  function showDialog(){
   mask.style.display = 'block';
   dialog.style.display = 'block';
  }
  function hideDialog(){
   mask.style.display = 'none';
   dialog.style.display = 'none';
  }
  function dufile(){
   $('content').innerHTML = '开始上传...';
   $('buts').innerHTML = $('downy').innerHTML;
   showDialog();
  }
  function dofile(){
   $('content').innerHTML= $('downz').value;
   $('buts').innerHTML = $('downx').innerHTML;
   showDialog();
  }
function upfile(id) {
if ($("file"+id)!=null){
 $("file"+id).value=""; $("file"+id).click(); 
 }else{
 alert("file"+id+"项不存在！");
 }
}
function godown(){
if ($("file")==null || $("file").value==""){
 alert("请输入提供的文件名!"); return false;
}
if ($("mima")==null || !$("mima").value.match(/^[0-9]{8}$/) ){
 alert("请输入提取密码（8位数字）!"); return false;
}
var fd = new FormData();
fd.append('file',$('file').value); fd.append('mima',$('mima').value);
var xhr = new XMLHttpRequest();
 xhr.responseType = 'blob';
 xhr.onload = function() {
if(xhr.readyState == 4){
if(xhr.status == 404){ $('rest').innerHTML="文件不存在(无此文件)"; }
if(xhr.status == 403){ $('rest').innerHTML="无权限下载(提取码错误)"; }
if(xhr.status == 200){ 
 var blob = new Blob([this.response], { type: 'application/octet-stream' });
 var url = URL.createObjectURL(blob);
 var a = document.createElement('a');
  a.href = url;
  a.download = $('file').value;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
 }
 }
};
xhr.open('POST','./?act=do',true);
xhr.send(fd);
}
function selfile(id){
var file = $('file'+id).files[0]; dufile();
if(!file){  $('content').innerHTML = '<h3>未上传：</h3>请先选择文件'; return false;}
console.log(file.name);
if (!/(<?php echo $isupx; ?>)$/.test(file.name)){
$('content').innerHTML += "<h3>未上传</h3>仅支持后缀格式（<?php echo $isupi;?>）!";
 return false;
}
if (file.size > <?php echo $lenxi;?> * 1024) {
$("content").innerHTML += "<h3>未上传</h3>文件大小("+parseInt(file.size /1024)+")KB超<?php echo $lenxi;?>kB限制!"; return false;
}
var fd = new FormData();
fd.append('file',file); 
fd.append('id',$('id').value); fd.append('tp',$('tp').value);
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(){
if(xhr.readyState == 4){
if(xhr.status == 200){ $('content').innerHTML=xhr.responseText; }
}
};
xhr.onloadstart = function(){ console.log("开始上传"); };
xhr.onloadend = function(){ console.log("上传结束"); };
xhr.ontimeout = function(){ console.log("上传超时"); };
xhr.onerror = function(){ console.log("上传失败"); };
xhr.onload = function(){ console.log("上传完成"); };
xhr.open('POST','./?act=up',true);
xhr.upload.onprogress = function(ev){
if(ev.lengthComputable){
var percent = 100 * ev.loaded/ev.total;//计算上传的百分比
console.log("进度:", percent+'%');//更改上传进度
 }
}
xhr.send(fd);
}
<?php
$dadirs = $imgdir.substr($fire,0,6)."/".$fire;
if($fire!="" && file_exists($dadirs)){
echo "\r\n\r\n$(\"dxia\").click();\r\n";
}
?>
</script>
<!-- 作者联系方式: 15058593138@qq.com (手机号可加微) -->
 </body>
</html>