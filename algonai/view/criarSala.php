<?php ob_start(); 

    if (!isset($_SESSION)) session_start();
    // Verifica se não há a variável da sessão que identifica o usuário
    
    if($_SESSION['login'] != true){
        header('Location: algonai.php'); exit;
    }
    
    if($_SESSION['usernivel'] != "superior"){
        header('Location: algonai.php'); exit;
    }

    $certo = false;
    while($certo != true){
        $codigo = rand(1,1000000);    
        include_once('../config/conexao.php');
    	try {
    	    $consulta = $pdo->query("SELECT `id`,`codigo`,`dificuldade` FROM sala WHERE (`codigo` = '".$codigo."');");  
		    
		    $linhas = $consulta->rowCount();
		    if ($linhas == 0) {
		        $certo = true;
		    }
    	}catch(PDOException $e) {
    		echo 'Error: ' . $e->getMessage();
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
    <title>Algonai - Registro</title>
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
                <div class="titulo">Sala</div>
                <div class="subtitulo">crie sua sala</div>
            </div>
            <form method="POST" action="sala.php">
                <div class="formulario">
                    <input type="text" value="<?php echo 'Código da sala: '.$codigo; ?>" name="codigo" maxlength="20" style="width: 93%" readonly="readonly">
                    <select name="select" class="input">
                      <option value="Iniciante" selected>Iniciante</option>
                      <option value="Intermediario">Intermediário</option>
                      <option value="Dificil">Difícil</option>
                    </select>
                    <button class="button1">Criar</button>
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

<?php
    
?>
