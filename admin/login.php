<?php
// Start de sessie voor het inloggen (zorgt dat de server onthoudt wie je bent)
session_start();
// Laad het configuratiebestand (hierin staan instellingen zoals de $base_url)
require_once 'backend/config.php';
?>

<!doctype html>
<!-- Geeft aan dat dit een modern HTML5 document is -->
<html lang="nl">
<!-- Start van het HTML-document, ingesteld op de Nederlandse taal -->

<head>
    <!-- De titel die je bovenin het tabblad van de browser ziet -->
    <title>Attractiepagina / Admin</title>
    <!-- Zorgt ervoor dat speciale tekens zoals ë of wachtwoordtekens goed laden -->
    <meta charset="utf-8">
    <!-- Zorgt ervoor dat de inlogpagina goed meeschaalt op telefoons (responsive) -->
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

    <?php // Laad de header/menubalk in uit de map die één niveau hoger ligt (vandaar ../)
    require_once '../header.php'; ?>
    
    <!-- De hoofdcontainer die het inlogformulier netjes uitlijnt op het scherm -->
    <div class="container">

        <?php
        // Command: Controleer of er een melding (zoals een foutmelding) in de URL staat
        if(isset($_GET['msg']))
        {
            // Command: Toon de melding op het scherm in een div-blok met de groene/rode CSS-styling
            echo "<div class='msg'>" . $_GET['msg'] . "</div>";
        }
        ?>

        <!-- Command: Formulier stuurt de logingegevens veilig via POST naar de loginController -->
        <form action="backend/loginController.php" method="POST">
            
            <!-- Groepje voor het invoerveld van de gebruikersnaam -->
            <div class="form-group">
                <!-- Het tekstlabel dat voor het invoerveld staat -->
                <label for="username">Gebruikersnaam:</label>
                <!-- Het invulveld waar de gebruiker zijn naam typt. placeholder is de lichte hulptekst -->
                <input type="text" name="username" id="username" placeholder="user1 t/m 3">
            </div>
            
            <!-- Groepje voor het invoerveld van het wachtwoord -->
            <div class="form-group">
                <!-- Het tekstlabel dat voor het wachtwoordveld staat -->
                <label for="password">Wachtwoord:</label>
                <!-- type="password" zorgt ervoor dat de letters veranderen in stipjes of sterretjes -->
                <input type="password" name="password" id="password" placeholder="pass1 t/m 3">
            </div>
            
            <!-- De definitieve inlogknop om het formulier en de gegevens te verzenden -->
            <input type="submit" value="Login">
            
        </form>
    </div>

</body>

</html>
