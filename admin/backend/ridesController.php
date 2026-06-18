<?php
// Start de sessie om inloggegevens te kunnen controleren en te onthouden
session_start();
// Laad het configuratiebestand (voor instellingen zoals $base_url)
require_once '../backend/config.php';

// Command: Controleer of de gebruiker NIET is ingelogd (user_id ontbreekt in de sessie)
if(!isset($_SESSION['user_id']))
{
    // Maak een waarschuwingstekst aan
    $msg = "Je moet eerst inloggen!";
    // Stuur de niet-ingelogde bezoeker direct terug naar de loginpagina met de melding
    header("Location: $base_url/admin/login.php?msg=$msg");
    // Stop direct met het uitvoeren van de rest van het PHP-script
    exit;
}

// Kijk welke actie er uitgevoerd moet worden (create, update of delete) via het verborgen formulierveld
$action = $_POST['action'];

// Command: Als de actie 'create' is (een gloednieuwe attractie aanmaken)
if($action == 'create')
{
    // --- VALIDATIE VAN DE INGEVULDE GEGEVENS ---
    // Haal de ingevulde titel op uit het formulier
    $title = $_POST['title'];
    // Als de titel leeg is gebleven, voeg dan een foutmelding toe aan de 'errors' lijst
    if(empty($title))
    {
        $errors[] = "Vul een titel in!";
    }

    // Haal het gekozen themagebied op uit het formulier
    $themeland = $_POST['themeland'];
    // Als er geen themagebied is gekozen, voeg dan een foutmelding toe
    if(empty($themeland))
    {
        $errors[] = "Vul een themagebied in!";
    }

    // OPDRACHT: Data opvangen van de nieuwe formuliervelden
    $description = $_POST['description']; // Vang de beschrijvingstekst op
    // Als de minimale lengte niet leeg is, maak er een heel getal (integer) van, anders blijft deze leeg (null)
    $min_length = !empty($_POST['min_length']) ? intval($_POST['min_length']) : null;

    // Controleer of het vinkje voor Fast Pass is aangekruist
    if(isset($_POST['fast_pass']))
    {
        $fast_pass = true; // Vinkje staat aan, dus true (ja)
    }
    else
    {
        $fast_pass = false; // Vinkje staat uit, dus false (nee)
    }

    // --- VERWERKEN VAN DE AFBEELDINGSUPLOAD ---
    // Command: Bepaal de map waar de afbeelding moet worden opgeslagen
    $target_dir = "../../img/attracties/";
    // Haal de originele bestandsnaam op van de geüploade afbeelding
    $target_file = $_FILES['img_file']['name'];
    
    // Controleer of de afbeelding per ongeluk al bestaat in de map op de server
    if(!empty($target_file) && file_exists($target_dir . $target_file))
    {
        $errors[] = "Bestand bestaat al!";
    }

    // Als er ergens hierboven fouten zijn gevonden, toon ze op het scherm en stop direct
    if(isset($errors))
    {
        var_dump($errors); // Dumpt de foutenlijst leesbaar op het scherm
        die(); // Stopt het script direct
    }

    // Plaats het tijdelijk geüploade bestand in de echte map (alleen als de gebruiker een bestand koos)
    if(!empty($target_file)) {
        // Verplaats het bestand van de tijdelijke servermap naar jouw eigen afbeeldingenmap
        move_uploaded_file($_FILES['img_file']['tmp_name'], $target_dir . $target_file);
    }

    // --- DATA OPSLAAN IN DE DATABASE ---
    // Command: Maak verbinding met de database en voeg de nieuwe rij toe
    require_once 'conn.php';
    // Maak de SQL-query klaar met placeholders (zoals :title) tegen SQL-injection (hackers)
    $query = "INSERT INTO rides (title, description, themeland, min_length, fast_pass, img_file) VALUES(:title, :description, :themeland, :min_length, :fast_pass, :img_file)";
    // Bereid de query veilig voor op de database-server
    $statement = $conn->prepare($query);
    // Voer de query uit en koppel de formulier-variabelen aan de placeholders
    $statement->execute([
        ":title" => $title,
        ":description" => $description,
        ":themeland" => $themeland,
        ":min_length" => $min_length,
        ":fast_pass" => $fast_pass,
        ":img_file" => $target_file,
    ]);

    // Stuur de gebruiker na het succesvol aanmaken terug naar de overzichtspagina
    header("Location: ../admin/attracties/index.php");
    exit;
}

// Command: Als de actie 'update' is (een bestaande attractie aanpassen)
if($action == "update")
{
    // Haal het unieke ID op van de attractie die aangepast moet worden
    $id = $_POST['id'];
    $title = $_POST['title'];
    $themeland = $_POST['themeland'];
    
    // OPDRACHT: Validatie toegevoegd bij het aanpassen van een attractie
    if(empty($title))
    {
        $errors[] = "Vul een titel in!";
    }
    if(empty($themeland))
    {
        $errors[] = "Vul een themagebied in!";
    }

    // OPDRACHT: Data opvangen van de nieuwe velden
    $description = $_POST['description'];
    $min_length = !empty($_POST['min_length']) ? intval($_POST['min_length']) : null;

    // Controleer of de Fast Pass checkbox is aangevinkt bij het aanpassen
    if(isset($_POST['fast_pass']))
    {
        $fast_pass = true;
    }
    else
    {
        $fast_pass = false;
    }

    // Command: Controleer of er GEEN nieuwe afbeelding is gekozen door de gebruiker
    if(empty($_FILES['img_file']['name']))
    {
        // Er is geen nieuwe foto gekozen; behoud de oude bestandsnaam die al in de database stond
        $target_file = $_POST['old_img'];
    }
    else
    {
        // Er is wél een gloednieuwe afbeelding gekozen; ga deze verwerken
        $target_dir = "../../img/attracties/";
        $target_file = $_FILES['img_file']['name'];
        
        // Controleer of deze nieuwe bestandsnaam niet al stiekem bestaat
        if(file_exists($target_dir . $target_file))
        {
            $errors[] = "Bestand bestaat al!";
        }

        // Verplaats de nieuwe geüploade foto naar de juiste afbeeldingenmap
        move_uploaded_file($_FILES['img_file']['tmp_name'], $target_dir . $target_file);
    }

    // FIX: Zorgt ervoor dat de validatiefouten bij het aanpassen ook echt getoond worden en het script stopt
    if(isset($errors))
    {
        var_dump($errors);
        die();
    }

    // Query - OPDRACHT: Uitgebreid met description en min_length
    // Command: Werk de gegevens van de specifieke attractie bij in de database op basis van het ID
    require_once 'conn.php';
    // Gebruik UPDATE om de bestaande rij in de tabel 'rides' te overschrijven
    $query = "UPDATE rides SET title = :title, description = :description, themeland = :themeland, min_length = :min_length, fast_pass = :fast_pass, img_file = :img_file WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":title" => $title,
        ":description" => $description,
        ":themeland" => $themeland,
        ":min_length" => $min_length,
        ":fast_pass" => $fast_pass,
        ":img_file" => $target_file,
        ":id" => $id // Zorgt ervoor dat we alleen de attractie met DIT specifieke ID aanpassen
    ]);

    // Stuur de gebruiker terug naar de overzichtspagina
    header("Location: ../admin/attracties/index.php");
    exit;
}

// Command: Als de actie 'delete' is (een attractie definitief weggooien)
if($action == "delete")
{
    // Haal het ID op van de rij die verwijderd moet worden
    $id = $_POST['id'];
    
    // Command: Verwijder de geselecteerde attractie op basis van het ID uit de database
    require_once 'conn.php';
    // DELETE FROM wist de gehele rij met dit specifieke ID uit de tabel 'rides'
    $query = "DELETE FROM rides WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":id" => $id
    ]);
    
    // Stuur de gebruiker na het wissen netjes terug naar het overzicht
    header("Location: ../admin/attracties/index.php");
    exit;
}
