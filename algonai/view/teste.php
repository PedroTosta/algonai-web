<?php ob_start(); ?>

<?php

    $pergunta = "Pergunta teste qual resultado do código abaixo na linguagem Java";
	$alternativa1 = "esse é a alternativa numero 01";
	$alternativa2 = "esse é a alternativa numero 02";
	$alternativa3 = "esse é a alternativa numero 03";
	$resposta = "esse é a alternativa resposta";
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="shortcut icon" href="../img/algonai_icon.png" /> 
    <title>Algonai</title>
</head>
<body>
    <div class="container">
        <div id="menu">
            <div id="menu-bar" onclick="menuOnClick()">
              <div id="bar1" class="bar"></div>
              <div id="bar2" class="bar"></div>
              <div id="bar3" class="bar"></div>
            </div>
            <nav class="nav" id="nav">
              <ul>
                <li><a href="#">Perfil (em breve)</a></li>
                <li><a href="#">Estatísticas (em breve)</a></li>
                <li><a href="sobre.php">Sobre e Feedbacks</a></li>
                <li><a href="../controller/deslogar.php">Deslogar</a></li>
              </ul>
            </nav> 
          </div>
          
          <div class="menu-bg" id="menu-bg"></div>


        <div class="header2">
            <form method="POST" class="">
                <div class="">
                    <div class="textoResultado">Resultado</div>
                    
                    
                    <div class="resultadoBox">
                        <div class="textoBox">
                            Acertos: 2/2<br/>
                            Dificuldade: Intermediário
                        </div>    
                    </div>
                    <button class="button3" style="margin-top: 20px">SAIR</button>
                </div>
            </form>
        </div>
        
    </div>
    <script>
        function menuOnClick() {
            document.getElementById("menu-bar").classList.toggle("change");
            document.getElementById("nav").classList.toggle("change");
            document.getElementById("menu-bg").classList.toggle("change-bg");
        }
    </script>
</body>
</html>