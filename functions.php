<?php
//functions.php
//alustan sessiooni, et saaks kasutada $_SESSIONS muutujaid
session_start();
/*function sum ($x, $y) {
	return $x + $y;
}
echo sum (2555556556,6565498451);
echo "<br>";

$answer = sum (10,15);
echo $answer;
echo "<br>";
function hello ($firstname, $lastname) {
	return "Tere tulemast ".$firstname." ".$lastname."!";
		
	}
	
	echo sum(5476567567,234234234);
	echo "<br>";
	$answer = sum(10,15);
	echo $answer;
	echo "<br>";
	echo hello ("Geithy", "Plakk.");*/
	
	$database = "if16_geithy";
	function signup ($email, $password) {
		
		
		//ühendus
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
	$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		//asendan küsimärgi väärtustega
		//iga muutuja kohta 1 täht, mis tüüpi muutuja on
		// s - string
		// i - integer
		// d - double/float
		$stmt->bind_param("ss", $email, $password); //seal tuleb ära muuta $signupemail - emailiks)
		
		if ($stmt->execute()) {
				
			echo "salvestamine õnnestus";
	   } else {
		   echo "ERROR ".$stmt->error;
	   
	}
	}
	
		
	function login($email, $password) {
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO ClothingOnTheCampus (gender, color) VALUES (?, ?)");
		echo $mysqli->error;
	
		
		//asendan küsimärgi
		$stmt->bind_param("ss", $gender, $color);
		
		//määran tupladele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//küsin rea andmeid
		if($stmt->fetch()) {
			//oli rida
		
			// võrdlen paroole
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				
				echo "kasutaja ".$id." logis sisse";
				
				$_SESSION["userID"] = $id;
				$_SESSION["email"] = $emailFromDb;
				//et suunaks uuele lehele
				header("Location: data.php");
				
			} else {
				$error = "parool vale";
			}
			
		
		} else {
			//ei olnud 
			
			$error = "sellise emailiga ".$email." kasutajat ei olnud";
		}
		return $error;
		
		}
?>