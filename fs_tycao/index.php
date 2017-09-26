<?php
include "functions.php";
$path = empty($_GET['path'])?"./":$_GET['path'];
$path = rtrim($path,"/");
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
if(!empty($_GET['delname'])){
	unlink($path."/".$_GET['delname']);
	msg("删除文件成功","index.php?path={$path}");
}

//删除文件夹
if(!empty($_GET['deldir'])){
	delDir($path."/".$_GET['deldir']);
	msg("删除文件夹成功","index.php?path={$path}");
}
//读取当前指定目录的内容
$files = scandir($path);
//去除.和..
array_shift($files);
array_shift($files);
?>
<html>
	<head>
		<meta charset="utf-8" />
		<title>文件管理系统</title>
		<style type="text/css">
		.currentDir{
			color:red;
		}
		h1{text-align:center}
		</style>
	</head>
	<body>
		<h1>文件管理系统</h1>
		<p>当前目录:<span class="currentDir"><?php echo $path;?></span></p>
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
		//返回上一级目录
		if($path!='.'&&$path!='./'){
			$result = explode("/",$path);
			array_pop($result);
			$prevPath = implode("/",$result);
			echo "<a href='index.php?path={$prevPath}'>返回上一级目录</a>";
		}
		?>
		
		<hr />
		<table cellspacing="1" bgcolor="#CCCCCC" width="100%" align="center">
			<thead>
				<tr bgcolor="#EEEEEE">
					<th>名称</th><th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($files as $v){
				if(is_file($path."/".$v)){
					//文件
			?>
				<tr bgcolor="#FFFFFF">
					<td><?php echo $v;?></td><td><a href="rename.php?path=<?php echo $path;?>&oldname=<?php echo $v;?>">重命名</a> <a href="index.php?delname=<?php echo $v;?>&path=<?php echo $path;?>">删除</a> <a href="edit.php?path=<?php echo $path;?>&filename=<?php echo $v;?>">修改</a></td>
				</tr>
			<?php
				}else{
					//文件夹
				?>
				<tr bgcolor="#FFFFFF">
					<td><a href="index.php?path=<?php echo $path."/".$v;?>"><?php echo $v;?></a></td><td><a href="rename.php?path=<?php echo $path;?>&oldname=<?php echo $v;?>">重命名</a> <a href="index.php?deldir=<?php echo $v;?>&path=<?php echo $path;?>">删除</a></td>
				</tr>
				<?php
				}
			}
			?>
				
				
			</tbody>
		</table>
		
		
		
		
		
		
		
		
		
		
		
		
	</body>
</html>