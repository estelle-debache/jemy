<?php
// Connexion à la BDD (PDO)
$pdo = new PDO('mysql:host=localhost;dbname=tchat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// Déclaration de variable
$content = '';

// Ouverture de session
session_start(); // Création de la session

// Fonction age
function age($naiss)
{
	list($y,$m,$d) = explode('-', $naiss);
	if(($m = (date('m') - $m)) < 0)
		$y++;
	elseif($m == 0 && date('d') - $d < 0)
		$y++;
	return date('Y') - $y;
}
