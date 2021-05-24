<?php

require_once 'config.php';

try {
    
	$dsn = "pgsql:host=$host;port=5432;dbname=$db;";

	// Realiza a conexão com o banco
	$pdo = new PDO(
		$dsn,
		$user,
		$password,
		[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
	);


} catch (PDOException $e) {

	die($e->getMessage());

}