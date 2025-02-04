<?php ob_start(); ?>
<?php   
    $username = 'u954442326_usuarioalgonai';
    $password = '?g*eMG^pK8';
    try{
		$pdo = new PDO('mysql:host=127.0.0.1:3306;dbname=u954442326_algonai',$username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Funcionando";
    }catch(Exception $e){
        echo "Erro: ".$e;
    }
?>