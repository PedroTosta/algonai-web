<?php ob_start(); ?>

<?php
    if (!isset($_SESSION)) session_start();
    // Verifica se não há a variável da sessão que identifica o usuário
    
    if($_SESSION['login'] != true){
        Header("Location: login.php"); exit;
    }
    
    
    if(isset($_GET['q'])){
        $questao = $_GET['q'];
        include_once('../config/conexao.php');
        $n = 0;
        if($questao == 1){
            //Puxar a questão atual pelo método GET e buscar o ID da primeira questão da sala
            try {
                $codigo = (int) filter_var($_SESSION['codigosala'], FILTER_SANITIZE_NUMBER_INT);
        		$consulta = $pdo->query("SELECT `id`,`codigo`,`dificuldade`, `dono`, `q1`, `q2` FROM sala WHERE codigo = '".$codigo."';");  
    		    $linhas = $consulta->rowCount();
        		if ($linhas != 1) {
        			echo '<div class="box_erro_login"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp;ERRO BUSCANDO OS DADOS DA SALA</div>';	
        		}else{			
        		    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['codigosala'] = $codigo;
    				$_SESSION['q1'] = $resultado['q1'];
    				$_SESSION['q2'] = $resultado['q2'];
        		}
            } catch(PDOException $e) {
    	    	echo 'Error: ' . $e->getMessage();
    	    }
    	    
        }
        
        if($questao == 2){
            $_SESSION['q1-tentativa'] = $_POST['alternativa'];
        }
        
        
        
        //PUXAR QUESTÃO
	    try {
	        if($questao == 1){
	            $n = $_SESSION['q1'];
	        }
	        if($questao == 2){
	            $n = $_SESSION['q2'];
	        }
	        
    		$consulta = $pdo->query("SELECT id,pergunta,resposta,alternativa1,alternativa2, alternativa3, dificuldade, codigo FROM pergunta WHERE id = '".$n."';");
    		$linhas = $consulta->rowCount();
    		if ($linhas != 1) {
    			echo '<div class="box_erro_login"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp;ERRO BUSCANDO QUESTÃO</div>';	
    		}else{			
                    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                    
                    $pergunta = $resultado['pergunta'];
                    $alternativa1 = $resultado['alternativa1'];
                    $alternativa2 = $resultado['alternativa2'];
                    $alternativa3 = $resultado['alternativa3'];
                    $alternativa4 = $resultado['resposta'];
                    $codigo = $resultado['codigo'];
                    
                     
                    $array = [];
                    $certo = false;
                    
                    //RANDOMIZAR ALTERNATIVAS
                    for($i = 0; $i < 4; $i++){
                        $n = rand(0,3);
                        while($certo == false){
                            if($array[$n] == null){
                                $certo = true;
                                if($i == 0){
                                    $array[$n] = $alternativa1;
                                }
                                if($i == 1){
                                    $array[$n] = $alternativa2;
                                }
                                if($i == 2){
                                    $array[$n] = $alternativa3;
                                }
                                if($i == 3){
                                    $array[$n] = $alternativa4;
                                }
                            }else{
                                $n = rand(0,3);
                            }
                        }
                        $certo = false;
                    }
    			}
	    } catch(PDOException $e) {
	    	echo 'Error: ' . $e->getMessage();
	    }
	    
    
        
    }else{
        header("Location: algonai.php"); exit();
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
                <li><a href="algonai.php">Sair</a></li>
                <li><a href="../controller/deslogar.php">Deslogar</a></li>
              </ul>
            </nav> 
          </div>
          
          <div class="menu-bg" id="menu-bg"></div>


        <div class="header2">
            <?php
                //echo '<form method="GET" action="responder.php?q='.($questao+1).'">';
                if($questao == 1){
                    echo '<form method="POST" action="responder.php?q=2"><br/>';
                }else if($questao == 2){
                    echo '<form method="POST" action="resultado.php"><br/>';
                }
            ?>
                <div class="areaPergunta">
                    <div class="textoPergunta">
                        <?php 
                            echo '0'.$questao.'. ';
                            echo $pergunta;
                        ?>
                        </div>
                        <?php
                            if(strlen($codigo) > 2){
                                echo '
                                <div class="perguntaBox">
                                    <div class="textoBox">
                                        '.nl2br($codigo).'
                                    </div>    
                                </div>         
                                ';
                            }
                        ?>
                    
                    <button type="submit" class="button4" name="alternativa" value="<?php echo $array[0] ?>"><?php echo $array[0] ?></button>
                    <button type="submit" class="button4" name="alternativa" value="<?php echo $array[1] ?>"><?php echo $array[1] ?></button>
                    <button type="submit" class="button4" name="alternativa" value="<?php echo $array[2] ?>"><?php echo $array[2] ?></button>
                    <button type="submit" class="button4" name="alternativa" value="<?php echo $array[3] ?>"><?php echo $array[3] ?></button>
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