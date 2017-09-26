<?php
include './functions.php';
$path = empty($_GET['path'])?"./":$_GET['path'];
$path = rtrim($path,'/');
//创建目录
if(!empty($_POST['createDir'])){
	if(file_exists($_POST['path'].'/'.$_POST['dirname'])){
		msg('目录已存在',"./index.php?path={$_POST['path']}");
		exit();
	}else{
		//创建目录
		mkdir($_POST['path'].'/'.$_POST['dirname'],0777);
		msg("目录成功创建","./index.php?path={$_POST['path']}");
		exit();
	}
}
//创建文件
if(!empty($_POST['createFile'])){
	if(file_exists($_POST['path'].'/'.$_POST['filename'])){
		msg('文件已存在',"./index.php?path={$_POST['path']}");
		exit();
	}else{
		//创建文件
		$fh = fopen($_POST['path'].'/'.$_POST['filename'],"w");
		fclose($fh);
		msg("文件已创建","./index.php?path={$_POST['path']}");
		exit();
	}
}
//删除文件
if(!empty($_GET['delfile'])){
	unlink($path.'/'.$_GET['delfile']);
	msg("文件删除成功",$_GET['path']);
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
			h1{text-align:center}
			body
			{
				background-image: url("./images/background.jpg");
				background-size: cover;
			}
			div#logo
			{
				position: relative;
				margin-left: auto;
				margin-right: auto;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div id="logo">
			<img src="./images/mega.png" width="160px" height="160px">
		</div>
		<h1>文件管理系统</h1>
		<p>当前目录: <?php echo $path;?></p>
		<form action='' method='post'>
			<input type='hidden' name='path' value='<?php echo $path;?>' />
			<input type='text' name='dirname' />
			<input type='submit' name='createDir' value='创建目录' />
		</form>
		<form action='' method='post' >
			<input type='hidden' name='path' value='<?php echo $path;?>' />
			<input type='text' name='filename' />
			<input type='submit' name='createFile' value='创建文件' />
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
		
		<table cellspacing="1" bgcolor="#CCCCEC" width="100%" align="center">
			<thead>
				<tr bgcolor="#EEEEEE">
					<th>文件名称</th><th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($files as $v){
						//若是为文件
						if(is_file($v)){
				?>
					<tr bgcolor="#FFFFFF">
						<td><?php echo $v;?></td><td><a href="./rename.php?path=<?php echo $path;?>&oldname=<?php echo $v;?>"> 重命名 </a><a href="./index.php?path=<?php echo $path;?>&delfile=<?php echo $v;?>"> 删除 </a><a href="./edit.php?path=<?php echo $path;?>&editfile=<?php echo $v;?>">修改</a></td>
					</tr>
				
				
				<?php    }else{
					   //若是为目录
				?>
					<tr bgcolor="#FFFFFF">
						<td><a href="./index.php?path=<?php echo $path.'/'.$v;?>"><?php echo $v;?></a></td><td><a href="./rename.php?path=<?php echo $path;?>&oldname=<?php echo $v;?>"> 重命名 </a><a href="./index.php?path=<?php echo $path;?>&deldir=<?php echo $v;?>"> 删除 </a></td>
					</tr>
					
				<?php
				}
					}
				?>
		
			</tbody>
		</table>		
	</body>
</html>