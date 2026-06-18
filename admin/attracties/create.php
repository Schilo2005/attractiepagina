<?php
session_start();
require_once '../backend/config.php';
if(!isset($_SESSION['user_id']))
{
    $msg = "Je moet eerst inloggen!";
    header("Location: $base_url/admin/login.php?msg=$msg");
    exit;
}
?>

<!doctype html>
<html lang="nl">

<head>
    <title>Attractiepagina / Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;600;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/main.css">
    <link rel="icon" href="<?php echo $base_url; ?>/favicon.ico" type="image/x-icon" />
</head>

<body>

    <?php require_once '../../header.php'; ?>
    <div class="container">

        <h2>Nieuwe attractie</h2><?php
// Start de sessie voor het controleren van de inlogstatus (zorgt dat alleen ingelogde admins hierbij kunnen)
session_start();
// Laad het configuratiebestand (hierin staan instellingen zoals de $base_url)
require_once '../backend/config.php';

// Command: Controleer of de gebruiker NIET is ingelogd (user_id ontbreekt in de sessie)
if(!isset($_SESSION['user_id']))
{
    // Maak een waarschuwingstekst aan
    $msg = "Je moet eerst inloggen!";
    // Stuur de bezoeker direct terug naar het loginscherm en geef de melding mee
    header("Location: $base_url/admin/login.php?msg=$msg");
    // Stop direct met het uitvoeren van de rest van dit PHP-script
    exit;
}
?>

<!doctype html>
<!-- Geeft aan dat dit een HTML5 document is -->
<html lang="nl">
<!-- Start van het HTML-document, ingesteld op de Nederlandse taal -->

<head>
    <!-- De titel bovenin het tabblad van de browser -->
    <title>Attractiepagina / Admin</title>
    <!-- Zorgt ervoor dat letters met accenten of speciale tekens goed laden -->
    <meta charset="utf-8">
    <!-- Zorgt ervoor dat het formulier netjes meeschaalt op telefoons (responsive) -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Maakt alvast verbinding met de servers van Google voor de lettertypes -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- Haalt de specifieke lettertypes Oxanium en Roboto op van Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;600;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Laadt het CSS-bestand dat zorgt dat de website er in alle browsers hetzelfde uitziet -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/normalize.css">
    <!-- Laadt jouw eigen CSS-bestand voor de styling van de formulieren en knoppen -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/main.css">
    <!-- Laadt het kleine icoontje (de favicon) dat je in het tabblad van de browser ziet -->
    <link rel="icon" href="<?php echo $base_url; ?>/favicon.ico" type="image/x-icon" />
</head>

<body>

    <?php // Laad de header/menubalk in uit de mappenstructuur hierboven (twee niveaus hoger, vandaar ../../)
    require_once '../../header.php'; ?>
    
    <!-- De hoofdcontainer die het formulier netjes binnen de zijkanten houdt -->
    <div class="container">

        <h2>Nieuwe attractie</h2>

        <!-- Command: Formulier voor het aanmaken van een nieuwe attractie inclusief afbeeldingen via multipart/form-data -->
        <!-- multipart/form-data is verplicht zodra je een bestand (file-upload) wilt meesturen via een formulier -->
        <form action="../backend/ridesController.php" method="POST" enctype="multipart/form-data">
            
            <!-- Onzichtbaar veld om aan de ridesController te vertellen dat we de actie 'create' willen uitvoeren -->
            <input type="hidden" name="action" value="create">
        
            <!-- Invoerveld voor de titel -->
            <div class="form-group">
                <label for="title">Titel:</label>
                <input type="text" name="title" id="title" class="form-input">
            </div>

            <!-- OPDRACHT: Beschrijving (description) toegevoegd -->
            <div class="form-group">
                <label for="description">Beschrijving:</label>
                <!-- textarea zorgt voor een groot tekstvak met meerdere regels. rows="5" bepaalt de starthoogte -->
                <textarea name="description" id="description" class="form-input" rows="5"></textarea>
            </div>

            <!-- Dropdown-menu voor het kiezen van het themagebied -->
            <div class="form-group">
                <label for="themeland">Themagebied:</label>
                <select name="themeland" id="themeland" class="form-input">
                    <!-- De eerste optie is leeg en dwingt de gebruiker om een bewuste keuze te maken -->
                    <option value=""> - kies een optie - </option>
                    <option value="familyland">Familyland</option>
                    <option value="waterland">Waterland</option>
                    <option value="adventureland">Adventureland</option>
                </select>
            </div>

            <!-- OPDRACHT: Minimale lengte (min_length) toegevoegd -->
            <div class="form-group">
                <label for="min_length">Minimale lengte (in cm):</label>
                <!-- type="number" zorgt dat je alleen getallen kunt invullen, min="0" voorkomt negatieve getallen -->
                <input type="number" name="min_length" id="min_length" class="form-input" min="0">
            </div>

            <!-- Invoerveld voor de afbeelding van de attractie -->
            <div class="form-group">
                <label for="img_file">Afbeelding:</label>
                <!-- type="file" opent het venster op je computer om een afbeelding te selecteren -->
                <input type="file" name="img_file" id="img_file" class="form-input">
            </div>
            
            <!-- Selectievakje (checkbox) voor de Fast Pass status -->
            <div class="form-group">
                <label for="fast_pass">FAST PASS:</label>
                <!-- value="1" stuurt de waarde 1 mee naar de controller als de checkbox is aangevinkt -->
                <input type="checkbox" name="fast_pass" id="fast_pass" value="1">
                <label for="fast_pass">Voor deze attractie is een FAST PASS nodig.</label>
            </div>

            <!-- Knop om alle ingevulde gegevens definitief te verzenden naar de ridesController -->
            <input type="submit" value="Attractie aanmaken">
        </form>

    </div>

</body>

</html>


        <form action="../backend/ridesController.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create">
        
            <div class="form-group">
                <label for="title">Titel:</label>
                <input type="text" name="title" id="title" class="form-input">
            </div>
            <div class="form-group">
                <label for="themeland">Themagebied:</label>
                <select name="themeland" id="themeland" class="form-input">
                    <option value=""> - kies een optie - </option>
                    <option value="familyland">Familyland</option>
                    <option value="waterland">Waterland</option>
                    <option value="adventureland">Adventureland</option>
                </select>
            </div>
            <div class="form-group">
                <label for="img_file">Afbeelding:</label>
                <input type="file" name="img_file" id="img_file" class="form-input">
            </div>
            <div class="form-group">
                <label for="fast_pass">FAST PASS:</label>
                <input type="checkbox" name="fast_pass" id="fast_pass">
                <label for="fast_pass">Voor deze attractie is een FAST PASS nodig.</label>
            </div>

            <input type="submit" value="Attractie aanmaken">


    </div>

</body>

</html>
