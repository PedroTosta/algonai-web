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
    <title>Algonai - Login</title>
</head>
<body>
    <div class="container">
        <div class="header" style="margin-top: 20px">
            <div class="textos">
                <div class="titulo">Entre sua conta</div>
                <div class="subtitulo">Bem vindo, ao Algonai</div>
            </div>
            <form method="POST">
                <div class="formulario">    
                    <input type="email" placeholder="E-mail" name="email" required>
                    <input type="password" placeholder="Senha" name="senha" required>
                    <button class="button1" type="submit">Logar</button>
                
                </div>
            </form>
            <div class="footer">
                Não tem uma conta? <a href="registro.php" style="color: #0085AD;"><b>Criar</b></a>
            </div>
            
            <a href="sobre.php">
                <button class="button3" style="background-color: #0085AD; margin-top: 50px">Sobre e feedbacks</button>
            </a>
            
        </div>
    </div>
</body>
</html>


<?php 
	if ($_POST['email'] && $_POST['senha']){
    	include_once('../config/conexao.php');
    	try {
    		$email = $_POST['email'];
    		$senha = md5($_POST['senha']);
    
    		$consulta = $pdo->query("SELECT `id`,`email`,`nome`,`senha`,`tipoUsuario` FROM usuario WHERE (`email` = '".$email ."') AND (`senha` = '". $senha."') ;");  
    		
    		$linhas = $consulta->rowCount();
    		if ($linhas != 1) {
    			echo '<div class="box_erro_login"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp;E-mail ou senha inválidos</div>';	
    		}else{			
    			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
					//session_start();
					// Salva os dados encontrados na sessão
					$_SESSION['login'] = true; //Se for true então o usuário pode ficar logado.
					$_SESSION['userid'] = $resultado['id'];
					$_SESSION['UsuarioNome'] = $resultado['nome'];
					$_SESSION['usernivel'] = $resultado['tipoUsuario'];
					// Redireciona o visitante
					Header("Location: algonai.php"); exit;
    			}
	    } catch(PDOException $e) {
		    echo 'Error: ' . $e->getMessage();
	    }
    }
?>
