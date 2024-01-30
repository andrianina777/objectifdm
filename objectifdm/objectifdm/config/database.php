<?php
	// $host = 'localhost';
	// $dbname = 'objectifdm';
	// $username = 'postgres';
	// $password = 'root';
	// $port ='5432';

	// $db = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";
	// $conn = null;

	// try{
	// 	$conn = new PDO($db);

	// } catch (PDOException $e){
	// 	echo 'Non connecter' . $e->getMessage();
	// 	die;
	// }

    $host = '192.168.130.223';
    $dbname = 'postgres';
    $username = 'postgres';
    $password = '123s0l31l';
    $port ='5432';

    $db = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";
    
    //$conn = null;

    try{
        $conn = new PDO($db);
        $conn->exec('SET search_path TO objectifdm');
    } catch (PDOException $e){
        echo 'Non connecter' . $e->getMessage();
        die;
    }	