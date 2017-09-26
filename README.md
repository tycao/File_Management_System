# File_Management_System
This is App is powered by PHP

git remote add opencv2 git@github.com:tycao/File_Management_System.git
------------------------------------------------------------------------

### 作品：PHP实现的文件管理系统
### 作者：tycao
### 时间：2017-09-26

PHP实现的文件管理系统
===========
首先，这是一个非常简单的文件管理系统：它是由PHP实现的。
-----------
### 整个项目就是由四个PHP文件组成，相当简单：
![fs_tycao_02](https://github.com/tycao/File_Management_System/blob/master/src/file_system_02.png "fs_tycao_02")
### 项目的主页面是这个样子的：
![fs_tycao_01](https://github.com/tycao/File_Management_System/blob/master/src/file_system_01.png "fs_tycao_01")
### 接下来，逐个讲解这4个PHP文件的作用：
#### index.php:
```php
<?php
include './functions.php';
$path = empty($_GET['path'])?"./":$_GET['path'];
$path = rtrim($path,'/');
//创建目录
if(!empty($_POST['createDir'])){
	//var_dump($_POST);
	//var_dump($path);
	//先判断相应的目录是否已经存在
	if(file_exists($_POST['path']."/".$_POST['dirname'])){
		//不能创建
		msg("目录已存在！","index.php?path={$_POST['path']}");
	}else{
		//可以创建
		mkdir($_POST['path']."/".$_POST['dirname']);
		msg("目录创建成功！","index.php?path={$_POST['path']}");
	}
}
//创建文件
if(!empty($_POST['createFile'])){
	if(!file_exists($_POST['path'].'/'.$_POST['filename'])){
		//创建文件
		$fp = fopen($_POST['path'].'/'.$_POST['filename'],"w");
		fclose($fp);
		msg("文件创建成功","index.php?path={$_POST['path']}");
	}else{
		//提示文件已经存在
		msg("文件已存在","index.php?path={$_POST['path']}");
	}
}
//删除文件
if(!empty($_GET['delfile'])){
	unlink($path.'/'.$_GET['delfile']);
	msg("文件删除成功","./index.php?path={$_GET['path']}");
}

//删除文件夹(目录)
if(!empty($_GET['deldir'])){
	delDir($_GET['path'].'/'.$_GET['deldir']);
	msg('目录删除成功',"./index.php?path={$_GET['path']}");
}


//读取当前指定目录的内容
$files = scandir($path);
//去除.和..
array_shift($files);
array_shift($files);

?>

<html>
	<head>
		<meta charset='utf-8'/>
		<title>文件管理系统</title>
		<style type='text/css'>
		.currentDir{ color: red}
		h1{text-align:center}
		div#logo
		{
			position: relative;
			margin-left: auto;
			margin-right: auto;
			text-align: center;
		}
		body
		{
			background-image: url("./images/background.jpg");
			background-size: cover;
		}
		</style>
	</head>
	<body>
		<div id='logo'>
			<img src='images/mega.png' width='160px' height='160px'>
		</div>
		<h1>文件管理系统</h1>
		<p>当前目录: <span class="currentDir"><?php echo $path;?></span></p>
		<form action="" method="post">
			<!--通过表单提交记录当前操作的目录的路径-->
			<input type="hidden" name="path" value="<?php echo $path;?>" />
			<input type="text" name="dirname" />
			<input type="submit" name="createDir" value="创建目录" />
		</form>
		<form action="" method="post">
			<!--通过表单提交记录当前操作的目录的路径-->
			<input type="hidden" name="path" value="<?php echo $path;?>" />
			<input type="text" name="filename" />
			<input type="submit" name="createFile" value="创建文件" />
		</form>
		<hr />
		<?php
		//返回上级目录
		if($path!='.'&&$path!='./'){
			$result = explode('/',$path);
			array_pop($result);
			$prevPath = implode('/',$result);
			echo "<a href='./index.php?path={$prevPath}'>返回上级目录</a>";
		}

		?>
		<hr />
		
		<table cellspacing="1" bgcolor="#CCCCCC" width="100%" align="center">
			<thead>
				<tr bgcolor="#EEEEEE">
					<th>文件名称</th><th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($files as $v){
						//若是为文件
						if(is_file($path.'/'.$v)){
				?>
					<tr bgcolor="#FFFFFF">
						<td><?php echo $v;?></td><td><a href="./rename.php?path=<?php echo $path;?>&oldname=<?php echo $v;?>">重命名</a><a href="./index.php?path=<?php echo $path;?>&delfile=<?php echo $v;?>">删除</a><a href="./edit.php?path=<?php echo $path;?>&editfile=<?php echo $v;?>">修改</a></td>
					</tr>
				
				
				<?php    }else{
					   //若是为目录
				?>
					<tr bgcolor="#FFFFFF">
						<td><a href="./index.php?path=<?php echo $path.'/'.$v;?>"><?php echo $v;?></a></td><td><a href="./rename.php?path=<?php echo $path;?>&oldname=<?php echo $v;?>">重命名</a><a href="./index.php?path=<?php echo $path;?>&deldir=<?php echo $v;?>">删除</a></td>
					</tr>
					
				<?php
				}
					}
				?>
		
			</tbody>
			
			
			
			
		</table>
		
			
		
		
		
		
		
		
	</body>
</html>
```

### functions.php
```php
<?php
header('Content-Type:text/html;charset=utf-8');
function msg($content,$url){
	echo "<script>";
	echo "alert('{$content}');location.href='{$url}';";
	echo "</script>";
}
function delDir($delPath){
	$list = scandir($delPath);
	array_shift($list);
	array_shift($list);
	foreach($list as $v){
		if(is_file($delPath.'/'.$v)){
			unlink($delPath.'/'.$v);
		}else if(is_dir($delPath.'/'.$v)){
			delDir($delPath.'/'.$v);
		}
	}
	rmdir($delPath);
}

?>
```

### rename.php:
```php
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
```

### edit.php
```php
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
```