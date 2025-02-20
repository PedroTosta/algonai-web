<?php ob_start(); ?>

<?php
    if (!isset($_SESSION)) session_start();
    // Verifica se não há a variável da sessão que identifica o usuário
    
    if($_SESSION['login'] != true){
        Header("Location: login.php"); exit;
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


        <div class="header">
            <div class="textos">
                <img src="../img/algonai_logo.png" alt="Algonai logo" style="padding-right: 15px">
            </div>
            <form method="POST" action="sala.php">
                <div class="formularioQ">
                    <input type="text" placeholder="Código do questionário" name="codigo" required>
                    <button class="seta" name="btnSeta" type="submit">
                        <img src="../img/seta-direita.png" alt="Seta direita" class="" width="38px" height="38px">
                    </button>
                </div>
            </form>
            <?php
            
                if($_SESSION['mensagem']){
                    echo "<div class='erro'>".$_SESSION['mensagem']."</div>";
                    unset($_SESSION["mensagem"]);
                }
            
            ?>
            <div class="buttons">
                <a href="criarSala.php">
                    <button class="button2">Criar Questionário</button>
                </a>
                <?php
                    
                    if($_SESSION['usernivel'] == 'superior'){
                        echo '<a href="criarPergunta.php">';
                        echo '<button class="button2">Criar Perguntas</button>';
                        echo '</a>';
                    }
                
                ?>
                
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