<?php
header("Content-Type:text/html;charset=utf-8");
if(!empty($_POST['sub'])){
$fs = fopen($_POST['path'].'/'.$_POST['editfile'],"w");
fwrite($fs,$_POST['content']);
fclose($fs);
include './functions.php';
msg('文件内容修改成功',"./index.php?path={$_POST['path']}");
exit();
}
$content = '';
$fs = fopen($_GET['path'].'/'.$_GET['editfile'],'r');
while(!feof($fs)){
	$content.= fread($fs,1024);
}
fclose($fs);



?>

<html>
	<head>
		<meta charset='utf-8' />
		<title>修改文件</title>
	</head>
	<body>
		<form action='' method='post'>
			将<?php echo $_GET['path'].'/'.$_GET['editfile']?>内容修改为<textarea name="content"><?php echo $content;?></textarea>
			<input type='hidden' name='editfile' value="<?php echo $_GET['editfile'];?>" >
			<input type='hidden' name='path' value="<?php echo $_GET['path'];?>" >
			<input type='submit' name='sub' value='修改' >
		</form>
	</body>
</html>