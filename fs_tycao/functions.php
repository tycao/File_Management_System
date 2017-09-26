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