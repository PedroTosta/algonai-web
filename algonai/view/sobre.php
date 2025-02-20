<?php ob_start(); ?>

<?php 
    
    if (!isset($_SESSION)) session_start();
    // Verifica se não há a variável da sessão que identifica o usuário

    include_once('../config/conexao.php');

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="shortcut icon" href="../img/algonai_icon.png" /> 
    <title>Algonai - Sobre</title>
</head>
<body>
    <div class="container">
        <div class="header" style="margin-top: 30px">
            <div class="textos">
                <img src="../img/algonai_logo.png" alt="Algonai logo" style="padding-right: 15px">
            </div>
            <div class="tSobre">
                Este projeto visa auxiliar alunos nas matérias de Algoritmo e Lógica de Programação, reduzindo as taxas de evasão escolar.<br/><br/>
                Desenvolvido por alunos do IFMT - Campus Rondonópolis.<br/><br/>
                GIT HUB:
                <a href="https://github.com/PedroTosta/algonai-web" style="color: blue; font-weight: bold" target="_blank">CLIQUE AQUI</a>
            </div>
            
                <form method="POST">
                    <div class="formularioQ">
                        
                        <?php
                          
                            if($_SESSION['login'] == true){
                                echo '<input type="text" placeholder="Digite aqui o que achou ou seu feedback" name="feedback" maxlength="500" autocomplete="off" required>';
                            }
                        ?>
                        
                    </div>
                    <div class="buttons">
                        
                        <?php
                        
                            if($_SESSION['login'] == true){
                                echo '<button class="button2">Enviar feedback</button>';
                            }
                            
                        ?>
                        
                        <a href="login.php" class="abtn" style="background-color: red">
                            Voltar para o sistema
                        </a>
                        
                    </div>
                    
                </form>

        <div id="snackbar">Feedback enviado com sucesso!</div>
        
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
</body>
</html>


<?php

    
    if(isset($_POST['feedback']) && isset($_SESSION['userid'])){
        
    	try {
            $stmt = $pdo->prepare('INSERT INTO feedback(id_usuario, feedback) VALUES(:id_usuario,:feedback);');
            $stmt->execute(array(
                ':feedback' => $_POST['feedback'],
                ':id_usuario' => $_SESSION['userid']));
                
            echo '<script>showToast()</script>';
    	}catch(PDOException $e) {
    		echo 'Error: ' . $e->getMessage();
        }  
        
    }

?>