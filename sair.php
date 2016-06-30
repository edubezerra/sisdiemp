<?php
	setcookie("login","",time()-1);
	setcookie("tipo","",time()-1);
	if($_COOKIE["tipo"] == '0'){
    	echo"<script language='javascript' type='text/javascript'>window.location.href='login.html';</script>";
	}else{
    	echo"<script language='javascript' type='text/javascript'>window.location.href='diemp/index.html';</script>";
	}
?>