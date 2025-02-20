<?php ob_start(); ?>
<?php   
    $username = '';
    $password = '';
    try{
		$pdo = new PDO('mysql:host=127.0.0.1:3306;dbname=',$username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Funcionando";
    }catch(Exception $e){
        echo "Erro: ".$e;
    }
?>