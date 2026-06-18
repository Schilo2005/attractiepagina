<?php
// Start de sessie om inloggegevens te kunnen opslaan
session_start();
// Command: Vang de ingevulde gebruikersnaam en het wachtwoord op uit het formulier
$username = $_POST['username'];
$password = $_POST['password'];

// Maak verbinding met de database
require_once 'conn.php';
// Command: Zoek de gebruiker op in de database op basis van de gebruikersnaam
$query = "SELECT * FROM users WHERE username = :username";
$statement = $conn->prepare($query);
$statement->execute([":username" => $username]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

// Command: Controleer of de gebruikersnaam überhaupt is gevonden in de database
if($statement->rowCount() < 1)
{
    $msg = "Account bestaat niet!";
    // Stuur de bezoeker terug naar de loginpagina met een foutmelding
    header("Location: ../login.php?msg=$msg");
    exit;
}

// Command: Controleer of het ingevulde wachtwoord klopt met het beveiligde wachtwoord uit de database
if(!password_verify($password, $user['password']))
{
    $msg = "Wachtwoord niet juist!";
    // Stuur de bezoeker terug naar de loginpagina met een foutmelding
    header("Location: ../login.php?msg=$msg");
    exit;
}

// Command: Sla de ID en naam van de ingelogde gebruiker op in de sessie
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];

// Stuur de succesvol ingelogde gebruiker door naar de hoofdpagina van de admin
header("Location: ../index.php");
