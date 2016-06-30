<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");

?>
<html>
<head>
<title>Importação de estudantes</title>
<link href="diempStyle.css" rel="Stylesheet" type="text/css" />
<meta charset="UTF-8">
</head>
<body>
	<center>
	<div class="main">
			<a id="linkIni" href="index.php">
			<div class="logo">
				<img id="cefetimg" src="logoCefet.gif" alt="LogoCefet">
			</div>
			</a>
			Sistema Diemp
			<div><a style=" color:white; width: 45px; margin-top:-25px; float: right; display: initial;" href="sair.php">Sair</a></div>
		</div>
	
	<div class="box">
	  <div class="intro">
		<span id="welcome">
			Importação de alunos no banco
		</span>
		
	  </div>
	
	  <div class="optionsDiv">
			<div class="optionTitle">importar Arquivo .csv</div>
				<form method="post" enctype="multipart/form-data" action="upload_csv.php">
					<input type="hidden" name="MAX_FILE_SIZE" value="20000000">
					<input style="background:white; color:#0077be; font:italic bold 15px Georgia, sans-serif; padding: 10px 0 10px 10px" 
						name="arquivo" type="file" id="userfile"> 
					<input name="upload" type="submit" class="submit" 
						style="width:200px; float:none; align:center; margin: 10px 0 -10px 0" 
						id="upload" value=" Upload ">
				</form>
	  </div>
	
	  
	  <br><br>
	</div>
	
	</center>
</body>

</html>