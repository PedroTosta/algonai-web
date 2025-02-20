<?php ob_start(); 

    if (!isset($_SESSION)) session_start();
    // Verifica se não há a variável da sessão que identifica o usuário
    
    if($_SESSION['login'] != true){
        header('Location: algonai.php'); exit;
    }
    
    if($_SESSION['usernivel'] != "superior"){
        header('Location: algonai.php'); exit;
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
                <li><a href="#">Perfil (em breve)</a></li>
                <li><a href="#">Estatísticas (em breve)</a></li>
                <li><a href="sobre.php">Sobre e Feedbacks</a></li>
                <li><a href="../controller/deslogar.php">Deslogar</a></li>
              </ul>
            </nav> 
          </div>
          
          <div class="menu-bg" id="menu-bg"></div>
        
        <div class="header" style="margin-top: 140px">
            <div class="textos">
                <div class="titulo">Criar pergunta</div>
            </div>
            <form method="POST">
                <div class="formulario">
                    <select name="select" class="input">
                      <option value="Iniciante" selected>Iniciante</option>
                      <option value="Intermediario">Intermediário</option>
                      <option value="Dificil">Difícil</option>
                    </select>
                    <input type="text" name="pergunta" style="width: 93%" placeholder="Pergunta" required="" autocomplete="off">
                    <input type="text" name="alternativa1" style="width: 93%" placeholder="Alternativa 1" required="" autocomplete="off">
                    <input type="text" name="alternativa2" style="width: 93%" placeholder="Alternativa 2" required="" autocomplete="off">
                    <input type="text" name="alternativa3" style="width: 93%" placeholder="Alternativa 3" required="" autocomplete="off">
                    <input type="text" name="resposta" style="width: 93%" placeholder="Resposta" required="" autocomplete="off">
                    <textarea name="codigo" class="input" placeholder="Código" autocomplete="off"></textarea>
                    <div class="buttons">
                        <button class="button2" type="submit" name="salvar">Salvar</button>
                        <a href="algonai.php" class="abtn">
                            Voltar
                        </a>
                    </div>
                </div>
            </form>
            <div id="snackbar">Pergunta cadastrada com sucesso!</div>        
        </div>
    </div>
    

    <script>
        function menuOnClick() {
            document.getElementById("menu-bar").classList.toggle("change");
            document.getElementById("nav").classList.toggle("change");
            document.getElementById("menu-bg").classList.toggle("change-bg");
        }
        
        function showToast() {
            // Get the snackbar DIV
            var x = document.getElementById("snackbar");
            
            // Add the "show" class to DIV
            x.className = "show";
            
            // After 3 seconds, remove the show class from DIV
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
    </script>


<?php
    include_once('../config/conexao.php');
    if(isset($_POST['salvar'])){
            
        $pergunta = $_POST['pergunta'];
        $resposta = $_POST['resposta'];
        $alternativa1 = $_POST['alternativa1'];
        $alternativa2 = $_POST['alternativa2'];
        $alternativa3 = $_POST['alternativa3'];
        $dificuldade = $_POST['select'];
        $codigo = $_POST['codigo'];
        
        
        try {
            $stmt = $pdo->prepare('INSERT INTO pergunta(pergunta, resposta, alternativa1, alternativa2, alternativa3, codigo, dificuldade) VALUES(:pergunta, :resposta, :alternativa1, :alternativa2, :alternativa3, :codigo, :dificuldade);');
            
            //$codigo = mysqli_real_escape_string($codigo);
            
            $stmt->execute(array(
                ':pergunta' => $pergunta,
                ':resposta' => $resposta,                
                ':alternativa1' => $alternativa1,
                ':alternativa2' => $alternativa2,
                ':alternativa3' => $alternativa3,
                ':codigo' => $codigo,
                ':dificuldade' => $dificuldade)); 
                
            echo '<script>showToast()</script>';
    	}catch(PDOException $e) {
    		echo 'Error: ' . $e->getMessage();
        }  
    }
?>


    
    
    

    
    
</body>
</html>

<?php
    
?>
