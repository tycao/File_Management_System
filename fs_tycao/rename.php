<?php
header('Content-Type:text/html;charset=utf-8');
if(!empty($_POST['sub'])){
	include './functions.php';
	rename($_POST['path'].'/'.$_POST['oldname'],$_POST['path'].'/'.$_POST['newname']);
	msg('重命名成功',"./index.php?path={$_POST['path']}");
	exit();
}



?>

<html>
	<head>
		<meta charset='utf-8' />
		<title>重命名文件</title>
	</head>
	<body>
		<form action='' method='post'>
			将<?php echo $_GET['path'].'/'.$_GET['oldname'];?>重命名成<input type='text' name='newname' >
			<input type='hidden' name='path' value="<?php echo $_GET['path'];?>" >
			<input type='hidden' name='oldname' value="<?php echo $_GET['oldname'];?>" >
			<input type='submit' name='sub' value='重命名' >
		</form>
	</body>
	
</html>