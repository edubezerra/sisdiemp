<?php
	setcookie("login","",time()-1);
	echo("<script>window.location.href='login.html';</script>");
?>