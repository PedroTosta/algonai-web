<?php ob_start(); ?>

<?php
    
    if (!isset($_SESSION)) session_start();
    // Verifica se não há a variável da sessão que identifica o usuário
    
    if($_SESSION['login'] != true){
        header("Location: login.php"); exit;
    }
    
    if(!isset($_POST['alternativa'])){
        header("Location: algonai.php"); exit;
    }
    
?>


<?php
    include_once('../config/conexao.php');
    $respostaq2 = $_POST['alternativa'];
    
    //echo 'TESTE: '.$_SESSION['q1-tentativa'];
    
    $acertos = 0;
    //PUXAR QUESTAO
    try {
        //VERIFICANDO QUESTÃO 1
		$consulta = $pdo->query("SELECT id,pergunta,resposta,alternativa1,alternativa2,alternativa3, dificuldade,codigo FROM pergunta WHERE id = '".$_SESSION['q1']."';");
		$linhas = $consulta->rowCount();
		if ($linhas != 1) {
			echo '<div class="box_erro_login"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp;ERRO BUSCANDO QUESTÃO</div>';	
		}else{			
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            if($_SESSION['q1-tentativa'] === $resultado['resposta']){
                $acertos++;
            }
        }
        
    } catch(PDOException $e) {
    	echo 'Error: ' . $e->getMessage();
    }
    
    
    try {
        //VERIFICANDO QUESTÃO 2
		$consulta = $pdo->query("SELECT id,pergunta,resposta,alternativa1,alternativa2,alternativa3, dificuldade,codigo FROM pergunta WHERE id = '".$_SESSION['q2']."';");
		$linhas = $consulta->rowCount();
		if ($linhas != 1) {
			echo '<div class="box_erro_login"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp;ERRO BUSCANDO QUESTÃO</div>';	
		}else{			
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            if($respostaq2 === $resultado['resposta']){
                $acertos++;
            }
        }
    } catch(PDOException $e) {
    	echo 'Error: ' . $e->getMessage();
    }
    
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
                            Acertos: <?php echo $acertos; ?>/2<br/>
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