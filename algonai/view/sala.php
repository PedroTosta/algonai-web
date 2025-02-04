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
        include_once('../config/conexao.php');
        $codigo = (int) filter_var($_POST['codigo'], FILTER_SANITIZE_NUMBER_INT);
    	try {
            $stmt = $pdo->prepare('INSERT INTO sala(codigo, dificuldade) VALUES(:codigo,:dificuldade);');
            $stmt->execute(array(
                ':codigo' => $codigo,
                ':dificuldade' => $_POST['select']));
            $dificuldade = $_POST['select'];
    	}catch(PDOException $e) {
    		//echo 'Error: ' . $e->getMessage();
        }  
    }else{
        if($_POST['codigo']){
            include_once('../config/conexao.php');
        	try {
        	    $consulta = $pdo->query("SELECT `id`,`codigo`,`dificuldade` FROM sala WHERE (`codigo` = '".$_POST['codigo']."');");  
    		    
    		    $linhas = $consulta->rowCount();
    		    if ($linhas > 0) {
    		        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    		        $dificuldade = $resultado['dificuldade'];
    		        $codigo = $resultado['codigo'];
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
                <li><a href="#">Perfil</a></li>
                <li><a href="#">Estatísticas</a></li>
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
            <form method="POST">
                <div class="formulario">
                    <input type="text" value="<?php echo 'Código da sala: '.$codigo; ?>" name="codigosala" readonly="readonly">
                    <input type="text" value="<?php echo 'Dificuldade: '.$dificuldade; ?>" name="dificuldade" readonly="readonly">
                    <button class="button3">Sair</button>
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