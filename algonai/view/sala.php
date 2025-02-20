<?php ob_start(); ?>

<?php
    
    if (!isset($_SESSION)) session_start();
    // Verifica se não há a variável da sessão que identifica o usuário
    if($_SESSION['login'] != true){
        header("Location: login.php"); exit;
    }
    
    $codigo = 0;
    $dificuldade = "";
    
    if($_POST['select']){
        //INSERE A SALA NO BANCO DE DADOS
        include_once('../config/conexao.php');
        $codigo = (int) filter_var($_POST['codigo'], FILTER_SANITIZE_NUMBER_INT);
    	try {
    	    //PUXA AS PERGUNTAS PARA SALA
    		$consulta = $pdo->query("SELECT `id`,`pergunta`,`resposta`,`alternativa1`,`alternativa2`, `alternativa3`, `dificuldade`, `codigo` FROM pergunta ORDER BY RAND() LIMIT 2;");
    		$linhas = $consulta->rowCount();
    		if ($linhas != 2) {
    			echo '<div class="box_erro_login"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp;ERRO</div>';	
    		}else{
    		    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    		    $q1 = $resultado['id'];
    		    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    		    $q2 = $resultado['id'];
                $stmt = $pdo->prepare('INSERT INTO sala(codigo, dificuldade, dono, q1, q2) VALUES(:codigo,:dificuldade,:dono,:q1,:q2);');
                $stmt->execute(array(
                    ':codigo' => $codigo,
                    ':dificuldade' => $_POST['select'],
                    ':dono' => $_SESSION['userid'],
                    ':q1' => $q1,
                    ':q2' => $q2));
                $dificuldade = $_POST['select'];
    		}
    	}catch(PDOException $e) {
    		//echo 'Error: ' . $e->getMessage();
        }  
    }else{
        if($_POST['codigo']){
            //AÇÃO APOS O USUARIO ENTRAR EM UMA SALA PELO CÓDIGO
            include_once('../config/conexao.php');
        	try {
        	    $consulta = $pdo->query("SELECT `id`,`codigo`,`dificuldade`, `dono` FROM sala WHERE (`codigo` = '".$_POST['codigo']."');");  
    		    
    		    $linhas = $consulta->rowCount();
    		    if ($linhas > 0) {
    		        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    		        $dificuldade = $resultado['dificuldade'];
    		        $codigo = $resultado['codigo'];
    		        $dono = $resultado['dono'];
    		    }else{			
                    $_SESSION['mensagem'] = "Código de sala inexistente";
                    header("Location: algonai.php"); exit;
    		    }
        	}catch(PDOException $e) {
        		//echo 'Error: ' . $e->getMessage();
            }  
        }else{
            header("Location: algonai.php"); exit;
        }
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="shortcut icon" href="../img/algonai_icon.png" /> 
    <title>Algonai - Sala</title>
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


        <div class="header">
            <div class="textos">
                <div class="textos">
                    <div class="titulo">Sala - <?php echo ''.$codigo; ?></div>
                    <div class="subtitulo">aguarde o início do questionário</div>
                </div>
            </div>
            <div class="formulario">
                
                    <input type="text" value="<?php echo 'Código da sala: '.$codigo; ?>" name="codigosala" readonly="readonly">
                    <input type="text" value="<?php echo 'Dificuldade: '.$dificuldade; ?>" name="dificuldade" readonly="readonly">
                    <form method="POST" action="responder.php?q=1">
                        <?php
                            $_SESSION['codigosala'] = $codigo;
                            if($_SESSION['userid'] == $dono){
                                //echo '<a href="responder.php">';
                                echo '<button class="button3" type="submit" style="background-color: #0085AD;">Começar</button>';
                                //echo '</a>';
                            }
                        ?>
                    </form>
                <a href="algonai.php">
                    <button class="button3">Sair</button>
                </a>
            </div>
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