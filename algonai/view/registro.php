<?php ob_start(); 

    if (!isset($_SESSION)) session_start();
    // Verifica se não há a variável da sessão que identifica o usuário
    
    if($_SESSION['login'] == true){
        header('Location: algonai.php');
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
        <div class="header">
            <div class="textos">
                <div class="titulo">Crie sua conta</div>
                <div class="subtitulo">Bem vindo, ao Algonai</div>
            </div>
            <form method="POST">
                <div class="formulario">
                    <input type="text" placeholder="Nome completo" name="nome" maxlength="100" required>
                    <input type="email" placeholder="E-mail" name="email" maxlength="100" required>
                    <input type="password" placeholder="Senha" name="senha1" maxlength="32" id="senha1" oninput="verifica()" required>
                    <input type="password" placeholder="Confirmação senha" name="senha2" maxlength="32" id="senha2" oninput="verifica()" required>
                    <div class="aviso" id="aviso">Senhas não conferem</div>
                    <button class="button1">Criar</button>
                </div>
            </form>
            <div class="footer">
                Já tem uma conta? <a href="login.php"><b>Entrar</b></a>
            </div>
        </div>
    </div>
    <script>
        function verifica(){
            const senha1 = document.getElementById("senha1").value;
            const senha2 = document.getElementById("senha2").value;
            const aviso = document.getElementById("aviso");
            if(senha1 != senha2){
                aviso.style.display = "block";
            }else{
                aviso.style.display = "none";
            }
        }
    </script>
</body>
</html>

<?php
    if($_POST['nome'] && $_POST['email'] && $_POST['senha1'] && $_POST['senha2']){
    	include_once('../config/conexao.php');
    	try {
    	    $consulta = $pdo->query("SELECT `id`,`email`,`nome`,`senha`,`tipoUsuario` FROM usuario WHERE (`email` = '".$_POST['email']."');");  
		    
		    $linhas = $consulta->rowCount();
		    if ($linhas > 0) {
			    echo '<div class="erro">E-mail já cadastrado</div>';
		    }else{			
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $pass1 = md5($_POST['senha1']);
                $pass2 = md5($_POST['senha2']);
                if($pass1 != $pass2){
                    echo '<div class="erro">As senhas não conferem</div>';
                }else{
                    $stmt = $pdo->prepare('INSERT INTO usuario(nome, email, senha, tipoUsuario) VALUES(:nome,:email,:senha,:tipoUsuario);');
                    $stmt->execute(array(
                        ':nome' => $nome,
                        ':email' => $email,                
                        ':senha' => $pass1,
                        ':tipoUsuario' => 'normal')); 
                    header("Location: login.php"); exit;
                }
		    }
    	}catch(PDOException $e) {
    		echo 'Error: ' . $e->getMessage();
        }  
    }
?>
