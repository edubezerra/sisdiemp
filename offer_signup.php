<?php
	if(!isset($_COOKIE["login"]))
		echo("<script>window.location.href='login.html';</script>");
	else{
		include_once("dbfunctions.php");
		include_once("conection.php");

		$permission = mysqli_query($c, "SELECT isAdmin FROM usuarios WHERE login = '$_COOKIE[login]'") or die("erro ao selecionar");

		if (!$permission) {
		    echo "Não foi possível executar a consulta ($sql) no banco de dados: " . mysqli_error();
		    exit;
		}

		if (mysqli_num_rows($permission) <= 0) {
			echo "Não foram encontradas linhas, nada para mostrar, assim eu estou saindo";
		    exit;
		}

		$row = mysqli_fetch_assoc($permission);
		$isAdmin = $row["isAdmin"];

		if($isAdmin == 0){
			echo"<script language='javascript' type='text/javascript'>window.location.href='index_aluno.php';</script>";
		}
	}
	$valor = "teste";
?>
<html>
<head>
<title>Cadastro de Oferta</title>
<link href="diempStyle.css" rel="Stylesheet" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="jquery.timepicker.css" />

<meta charset="UTF-8">

<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="jquery.timepicker.js"></script>
		
<script type="text/javascript">
	$(function procura(){ 
			$('#search').click(function(){
				//escrevendo valores no input
					//var test = "Testando";
					//$('#nome').val(test);
					//$('#email').val(test);

				var cnpj = $('#cnpj').val();
				if (cnpj != '') {
					
					//Dividindo uma variavel
					//var str = "test | outro test";
					//str_2 = str.split("|");
					//$('#nome').val(str_2[0]);
					//$('#email').val(str_2[1]);

					//testando se pegou o nome corretamente do input
					$.post('ajax.php',$('input[name="cnpj"]'),function(data){
					
						var str = data;
						dados = str.split("|");
						$('#nome').val(dados[1]);
						$('#email').val(dados[2]);
					},'html')	
					
				}
				else{
					alert('Preencha o campo CNPJ');
				};
			});
		});
	$(function() {

    	$( "#tecPopUp" ).dialog({resizable: false,title:"Selecionar Técnico",width:505,draggable:false,}).dialog('widget').position({ my: 'right', at: 'left', of: $('#tecButton') });
    	$( "#tecPopUp" ).prev(".ui-dialog-titlebar").css("background-image","linear-gradient(to bottom, #00A0FF, #0077BE)");
    	$("#ui-id-1").css("color","#fff");
    	$('#tecPopUp').parent().css('top',$('#tecButton').position().top+50);
    	$('#tecPopUp').parent().css('left',$('#tecButton').position().left+50);
    	$("#tecPopUp").dialog('close');

    	$(".campo:nth-of-type(8)").timepicker({ 'timeFormat': 'H:i:s', 'step':'10' });
    	$(".campo:nth-of-type(9)").timepicker({ 'timeFormat': 'H:i:s', 'step':'10' });
    	//background-image: linear-gradient(to bottom, #cf2b4f, #980021);
  	});

  	function formataCampo(campo, Mascara, evento) { 
        var boleanoMascara; 

        var Digitato = evento.keyCode;
        exp = /\-|\.|\/|\(|\)| /g
        campoSoNumeros = campo.value.toString().replace( exp, "" ); 

        var posicaoCampo = 0;    
        var NovoValorCampo="";
        var TamanhoMascara = campoSoNumeros.length;; 

        if (Digitato != 8) { // backspace 
                for(i=0; i<= TamanhoMascara; i++) { 
                        boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                                                                || (Mascara.charAt(i) == "/")) 
                        boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(") 
                                                                || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " ")) 
                        if (boleanoMascara) { 
                                NovoValorCampo += Mascara.charAt(i); 
                                  TamanhoMascara++;
                        }else { 
                                NovoValorCampo += campoSoNumeros.charAt(posicaoCampo); 
                                posicaoCampo++; 
                          }              
                  }      
                campo.value = NovoValorCampo;
                  return true; 
        }else { 
                return true; 
        }
	}

	function fillUnits(){
		$.post("search.php",{what:"units"},function(data){
			$("#Unidade").append(data);
		});
	}
	function fillCourses(chosenUnit){
		$.post("search.php",{what:"courses", unit:chosenUnit},function(data){
			$("#Curso").html("<option>Selecione o Curso...</option>");
			$("#Curso").append(data);
		});
	}

	function insertTec(){
		var unidade=$("#Unidade").val();
		var curso=$("#Curso").val();
		if(unidade == "Selecione a Unidade...")
			alert("Escolha uma unidade!");
		else if(curso == "Selecione o Curso...")
			alert("Escolha um curso!");
		
		if(unidade!="Selecione a Unidade..." && curso!="Selecione o Curso..." && $('.campo.txtarea').val().indexOf($('#Curso').val())==-1 ){
			$('.campo.txtarea').append($('#Curso').val() + '\n\n');
			$('#Curso').html('<option>Selecione o Curso...</option>');
			$('#Unidade').val("Selecione a Unidade...");
			$("#tecPopUp").dialog('close');
		}else{
			alert("Técnico já selecionado!");
		}
	}

	function gainFocusCNPJ (obj) {
		$('#tooltip').css('display','block');
	}

	function lostFocusCNPJ (obj) {
		if(validarCNPJ(obj.value)){
			receiveName(obj.value);
			$('#tooltip').text('Carregando nome da empresa....');
		}
		else{
			name = '';
			$('#tooltip').text('CNPJ inválido!');
		}

		window.setInterval(function(){
			if(name!='')
				$('#tooltip').text(name);
			else if($('#tooltip').text()!='CNPJ inválido!'){
				$('#tooltip').text('Empresa não existe!');
			}
		},250);

	}

	function validarCNPJ(cnpj) {
	 
	    cnpj = cnpj.replace(/[^\d]+/g,'');
	 
	    if(cnpj == '') return false;
	     
	    if (cnpj.length != 14)
	        return false;
	 
	    // Elimina CNPJs invalidos conhecidos para acelerar o processo
	    if (cnpj == "00000000000000" || 
	        cnpj == "11111111111111" || 
	        cnpj == "22222222222222" || 
	        cnpj == "33333333333333" || 
	        cnpj == "44444444444444" || 
	        cnpj == "55555555555555" || 
	        cnpj == "66666666666666" || 
	        cnpj == "77777777777777" || 
	        cnpj == "88888888888888" || 
	        cnpj == "99999999999999")
	        return false;
	         
	    // Valida DVs
	    tamanho = cnpj.length - 2
	    numeros = cnpj.substring(0,tamanho);
	    digitos = cnpj.substring(tamanho);
	    soma = 0;
	    pos = tamanho - 7;
	    for (i = tamanho; i >= 1; i--) {
	      soma += numeros.charAt(tamanho - i) * pos--;
	      if (pos < 2)
	            pos = 9;
	    }
	    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	    if (resultado != digitos.charAt(0))
	        return false;
	         
	    tamanho = tamanho + 1;
	    numeros = cnpj.substring(0,tamanho);
	    soma = 0;
	    pos = tamanho - 7;
	    for (i = tamanho; i >= 1; i--) {
	      soma += numeros.charAt(tamanho - i) * pos--;
	      if (pos < 2)
	            pos = 9;
	    }
	    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	    if (resultado != digitos.charAt(1))
	          return false;
	           
	    return true;
	    
	}

	//var numItems = $('.yourclass').length

	 function showResults(){
		var cnpj=$(".campo:nth-of-type(1)").val();
		alert(cnpj);
		var nome=$(".campo:nth-of-type(2)").val();
		//alert(nome);
		var email=$(".campo:nth-of-type(4)").val();
		//alert("email:"+email);
		var tecnicos=$('.campo.txtarea').val();
		//alert("tecnico:"+tecnicos);
		var funcao=$(".campo:nth-of-type(6)").val();
		//alert("Funcao:"+funcao);
		var salario=$(".campo:nth-of-type(7)").val();
		//alert("Salario:"+salario);
		var dataPublicacao=$(".campo:nth-of-type(11)").val();
		//alert("Data de puplicacao:"+dataPublicacao);
		var dataVigencia=$(".campo:nth-of-type(12)").val();
		//alert("Data vigencia:"+dataVigencia);
		var horarioInicio=$(".campo:nth-of-type(8)").val();
		//alert("Hora de Inicio:"+horarioInicio);
		var horarioFim=$(".campo:nth-of-type(9)").val();
		//alert("Horario de Fim:"+horarioFim);
		var beneficios=$("#beneficios").val();
		//alert("Beneficios:"+beneficios);
		var local=$("#local").val();
		//alert("Local:"+local);
		var horas = $("#hora").val();
		//alert("Horas:"+horas);
	
		//alert somente se as variaveis estão vazias!
		var info={cnpj: cnpj, nome: nome, email: email, tecnicos: tecnicos, funcao: funcao, salario: salario, dataVigencia: dataVigencia, dataPublicacao:dataPublicacao, horarioInicio: horarioInicio, horarioFim: horarioFim, beneficios: beneficios, local: local, horas: horas};
		if(!cnpj)
			alert("Cadastro não efetuado! \n É necessário inserir o cnpj da empresa.");
		else if (!nome)
			alert("Cadastro não efetuado! \n É necessário inserir o nome da empresa.");
		else if (!email)
			alert("Cadastro não efetuado! \n É necessário inserir o email da empresa.");
		else if(!tecnicos)
			alert("Cadastro não efetuado! \n É necessário inserir os cursos técnicos almejados pela empresa.");
		else if(!funcao)
			alert("Cadastro não efetuado! \n É necessário inserir a função que o estagiário efetuará.");
		else if(!salario)
			alert("Cadastro não efetuado! \n É necessário inserir o salário a ser pago.");
		else if(!dataVigencia)
			alert("Cadastro não efetuado! \n É necessário inserir a data de vigência.");
		else if(!dataPublicacao)
			alert("Cadastro não efetuado! \n É necessário inserir a data de publicação.");
		else if(!horarioInicio)
			alert("Cadastro não efetuado! \n É necessário inserir o horário de estágio.");
		else if(!horarioFim)
			alert("Cadastro não efetuado! \n É necessário inserir o horário de estágio.");
		else if(!beneficios)
			alert("Cadastro não efetuado! \n É necessário inserir os benefícios.");
		else if(!local)
			alert("Cadastro não efetuado! \n É necessário inserir o local de trabalho.");
		else if(!horas)
			alert("Cadastro não efetuado! \n É necessário inserir as horas diárias.");
		else
		$.post("signup_offer.php",info,function(data){
			$(".box").append(data);
			/*if(data.search('sucesso')!=-1){

				//$(".campo:nth-of-type(1)").val('');
				//$(".campo:nth-of-type(2)").val('');
				//$(".campo:nth-of-type(4)").val('');
				//$(".campo:nth-of-type(5)").val('');
				//$(".campo:nth-of-type(6)").val('');
				//$(".campo:nth-of-type(7)").val('');
				//$(".campo:nth-of-type(8)").val('');
				//$(".campo:nth-of-type(9)").val('');
				//$('.campo.txtarea').val('');
				//$("#beneficios").val('');
				//$("#local").val('');
			}*/
		});	
	} 
	
	function isNumberKey(evt) { 
         var charCode = (evt.charCode) ? evt.which : event.keyCode


         if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46) 
             return false; 
         else { 
             var len = document.getElementById("txtChar").value.length; 
             var index = document.getElementById("txtChar").value.indexOf('.'); 

             if (index > 0 && charCode == 46) { 
                 return false; 
             } 
             if (index >0 || index==0) { 
                 var CharAfterdot = (len + 1) - index; 
                 if (CharAfterdot > 2) { 

                     return false; 
                 } 

        }

    if (charCode == 46 && input.split('.').length >1) {
        return false;
        }


         } 
         return true; 
    }

    function isHourKey(evt,obj) { 
         var charCode = (evt.charCode) ? evt.which : event.keyCode


         if (charCode > 31 && (charCode < 48 || charCode > 58) ) 
             return false; 
         else { 
         
         	return true;

         } 
    }

    function isCNPJKey(evt,obj) { 
         var charCode = (evt.charCode) ? evt.which : event.keyCode


         if (charCode > 31 && (charCode < 48 || charCode > 57) ) 
             return false; 
         else { 
         	return true;

         } 
    }

    function checkDate (obj) {
    	if(obj.placeholder == "Data de Publicação"){
    		var today = new Date();
    		var data = new Date(obj.value);
    		data = new Date (data.getTime() + 25*60*60*1000 + 59*60*1000 + 59*1000); //Corrigindo problema de fuso
    		if(data < today){
    			alert("A data deve ser maior que o dia atual!");
    			obj.value = '';
    		}
    	}else if (obj.placeholder == "Data de Vigência"){
    		var today = new Date();
    		var data1 = new Date(obj.value);
    		var data2 = new Date($(".campo:nth-of-type(6)").val());
    		data1 = new Date (data1.getTime() + 25*60*60*1000 + 59*60*1000 + 59*1000);
    		data2 = new Date (data2.getTime() + 25*60*60*1000 + 59*60*1000 + 59*1000);

    		if(data1 < data2){
    			alert("A data deve ser maior que a data de publicação!");
    			obj.value = '';
    		}

    	}
    }

	function moeda(valor){
		var v = $('#salario').val();
		v=v.replace(/\D/g,"") // permite digitar apenas numero
		v=v.replace(/(\d{1})(\d{14})$/,"$1.$2") // coloca ponto antes dos ultimos digitos
		v=v.replace(/(\d{1})(\d{11})$/,"$1.$2") // coloca ponto antes dos ultimos 11 digitos
		v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") // coloca ponto antes dos ultimos 8 digitos
		v=v.replace(/(\d{1})(\d{5})$/,"$1.$2") // coloca ponto antes dos ultimos 5 digitos
		v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2") // coloca virgula antes dos ultimos 2 digitos
		$('#salario').val(v);
	}



</script>
</head>

<body onload="fillUnits();">
<center>
	<div class="main">
		<a href="index.php">
		<div class="logo">
			<img id="cefetimg" src="logoCefet.gif" alt="LogoCefet">
		</div>
		</a>
		Sistema Diemp
		<div><a style=" color:white; width: 45px; margin-top:-25px; float: right; display: initial;" href="sair.php">Sair</a></div>
	</div>
	<div class="box">
		<div class="stdIntro">
			<span id="welcome">
				Cadastro de Ofertas de Estágio
			</span>
			<p><p><p>
			<div id="eu">

				<form class="form-wrapper">
					<h5>
					<!--
						<div id="tooltip" style="display:none;">
							Carregando nome da empresa...
						</div> -->
					</h5>
					<label style="padding-left: 10px"> CNPJ </label> <br>
					<input type="text" name="cnpj" id="cnpj" class="campo" maxlength="18" style="width: 350px; text-align: center" placeholder="CNPJ da Empresa" onblur="lostFocusCNPJ(this)" onfocus="gainFocusCNPJ(this)" onkeypress="return isCNPJKey(this,event);" onkeydown="formataCampo(this, '00.000.000/0000-00', event);" required> 
					<input type="image" class="button" src="pesquisar.png" style="float: left; margin-left:5px; width: 30px; height: 30px; text-align:center; fonte-size: 8px; margin-top:2px;" id="search"> 
					<p id="return" style="display: none;">Nada foi encontrado!</p> <br>
					<label id="show" style="padding-left: 10px ">Nome da empresa </label> 
					<label id="show" style=" padding-left: 185px">Email da empresa</label> <br>
					<input type="text" id="nome" name="nome" class="campo" style="width: 310px; text-align: center" placeholder=" nome da empresa" readonly required> 
					<input type="text" id="email" name="email" class="campo" style="width: 310px; text-align: center" placeholder="Email da Empresa" readonly required> <br>
					
					
					<label style="padding-left: 10px">Técnico </label> <br>
					<textarea class="campo txtarea" name="tecnicos" style="width: 475px;height:70px; text-align: center;resize:none ;font-size:12; padding-left: 10px;" placeholder="Técnico Desejado" disabled required id="tecnico"></textarea>
					<input type="button" class="submit" style="  float: left; margin-left:5px;width:45px;height:70px;text-align:center;font-size:18px" value=">" onclick="$('#tecPopUp').dialog('open');$('#tecPopUp').parent().css('top',$('#tecButton').position().top+50);$('#tecPopUp').parent().css('left',$('#tecButton').position().left+50);" id="tecButton"> <br>
					
					<label style="padding-left: 10px">Função </label>
					<label style="padding-left: 170px">Remuneração </label><br>
					<input type="text" class="campo" name="funcao" style="width: 200px; text-align: center; margin-right: 10px" placeholder="Função" required>
					<input type="text" id="salario" name="salario" class="campo" style="width: 200px; text-align: center; margin-right: 10px " onkeypress="return isNumberKey(event)" placeholder="Salário" onblur="moeda();" required><br>
					
					
					<label class="hora" style="padding-left: 10px">Horário de inicio</label>
					<label class="hora" style="padding-left: 95px"> Horário de termino</label>
					<label style="padding-left: 60px; float: left"> Horas</label><br>
					<input type="text" maxlength="8" class="campo" name="horarioInicio" style="width: 200px; text-align: center;margin-right:10px;" onkeypress="return isHourKey(event)" placeholder="Horário de Início" required>
					<input type="text" maxlength="8" class="campo" name="horarioFim" style="width: 200px; text-align: center" onkeypress="return isHourKey(event,this)" placeholder="Horário de Fim" required>
					<input type="text" class="campo" name="horas" id="hora" style="width: 100px; text-align: center" placeholder="Horas" required><br>
				
					<label class="hora" style="padding-left: 10px"> Data de publicação</label>
					<label class="hora" style="padding-left: 75px">  Data de vigência </label> <br>
					<input type="text" class="campo" name="dataPublicacao" style="width: 200px; text-align: center;margin-right:10px;" onfocus="(this.type='date')" onchange="checkDate(this)" placeholder="Data de Publicação" required>
					<input type="text" class="campo" name="dataVigencia" style="width: 200px; text-align: center" onfocus="(this.type='date')" onchange="checkDate(this)" placeholder="Data de Vigência" required> <br>
					
					<label for="beneficios" style="padding-left: 15px">Benefícios </label><br>
					<textarea id="beneficios" class="campo" name="beneficios" style="width: 650px;height:110px;resize: none; text-align: center" maxlength="511" placeholder="Benefícios"  required></textarea> <br>
					<label style="padding-left: 15px"> Local </label> <br>
					<textarea id="local" class="campo" name="local" style="width: 650px;height:110px;resize: none; text-align: center" maxlength="127" placeholder="Local"  required></textarea> <br>
					
					
					<input onclick="showResults();" value="Cadastrar" style="text-align: center; width: 350px; font-size: 16px;" class="submit" readonly> <br> <br>
				</form>
				<br/>
				<br/>
			</div>
			<br/>
		</div>
		<a href='javascript:window.history.go(-1)'><---Voltar  </a>	<br>
	</div>	

	<div id="tecPopUp" >
		<form class="form-wrapper" style="width:450px">
			<select onchange="fillCourses(this.value)" class="campo" style="width: 450px; text-align: center" id="Unidade" required>
				<option>Selecione a Unidade...</option>
			</select><br> 
			<select class="campo" style="width: 450px; text-align: center" id="Curso" required>
				<option>Selecione o Curso...</option>
			</select> <br>
			<input onclick="insertTec();" value="Inserir" style="width: 450px; font-size: 16px;" class="submit"> <br><br>
		</form>
	</div>


</center>
</body>
</html>