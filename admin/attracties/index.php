<?php
// Start de sessie voor het controleren van de inlogstatus (zodat onbevoegden niet op deze pagina kunnen)
session_start();
// Laad het configuratiebestand (hierin staan instellingen zoals de $base_url)
require_once '../backend/config.php';

// Command: Controleer of de gebruiker NIET is ingelogd (user_id ontbreekt in de sessie)
if(!isset($_SESSION['user_id']))
{
    // Maak een waarschuwingstekst aan
    $msg = "Je moet eerst inloggen!";
    // Stuur de gebruiker direct terug naar het loginscherm en geef de melding mee
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
    <!-- De titel die je bovenin het tabblad van de browser ziet -->
    <title>Attractiepagina / Admin</title>
    <!-- Zorgt ervoor dat speciale tekens (zoals cm of namen met accenten) goed laden -->
    <meta charset="utf-8">
    <!-- Zorgt ervoor dat deze overzichtstabel netjes meeschaalt op schermen (responsive) -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Maakt alvast verbinding met de servers van Google voor de lettertypes -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- Haalt de specifieke lettertypes Oxanium en Roboto op van Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;600;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Laadt het CSS-bestand dat zorgt dat de tabel er in alle browsers hetzelfde uitziet -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/normalize.css">
    <!-- Laadt jouw eigen CSS-bestand voor de styling van de tabelrijen en linkjes -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/main.css">
    <!-- Laadt het kleine icoontje (de favicon) dat je in het tabblad van de browser ziet -->
    <link rel="icon" href="<?php echo $base_url; ?>/favicon.ico" type="image/x-icon" />
</head>

<body>

    <?php // Laad de header/menubalk in uit de mappenstructuur (twee niveaus hoger, vandaar ../../)
    require_once '../../header.php'; ?>
    
    <!-- De hoofdcontainer die de tabel en de knoppen netjes binnen de margins houdt -->
    <div class="container">

        <!-- Een normale tekstlink naar de pagina waar je een nieuwe attractie kunt toevoegen -->
        <a href="create.php">Nieuwe attractie maken &gt;</a>

        <?php
        // Maak verbinding met de database (haalt de database-connectie $conn op)
        require_once '../backend/conn.php';
        
        // OPDRACHT: Sorteren op titel toegevoegd (ORDER BY title ASC)
        // Command: SQL-query die alle kolommen (*) uit de tabel 'rides' pakt en alfabetisch (ASC) op titel zet
        $query = "SELECT * FROM rides ORDER BY title ASC";
        // Bereid de query veilig voor op de database-server
        $statement = $conn->prepare($query);
        // Voer de query uit op de database
        $statement->execute();
        // Haal alle gevonden rijen op en stop ze als een lijst (array) in de variabele $rides
        $rides = $statement->fetchAll(PDO::FETCH_ASSOC);

        // OPDRACHT: Tel het aantal attracties voor de teller
        // Command: Tel hoeveel database-rijen (attracties) er in de $rides lijst zitten
        $aantal_attracties = count($rides);
        ?>

        <!-- OPDRACHT: Teller bovenaan de tabel geplaatst -->
        <!-- Command: Toon het totale getal van de teller dikgedrukt op het scherm via PHP echo -->
        <p><strong>De lijst bevat <?php echo $aantal_attracties; ?> attracties.</strong></p>

        <!-- Start van de HTML-tabel -->
        <table>
            <!-- De bovenste rij van de tabel met alle kolomkoppen (th = table header) -->
            <tr>
                <th>Titel</th>
                <th>Themagebied</th>
                <th>Min. lengte</th>
                <th>Fastpass</th>
                <th>Acties</th>
            </tr>
            
            <?php // Command: Start een foreach-loop om elke losse attractie uit de lijst één voor één te verwerken ?>
            <?php foreach($rides as $ride): ?>
                <!-- Voor elke attractie maken we een nieuwe rij (tr = table row) aan -->
                <tr>
                    <!-- Toon de titel. htmlentities() zorgt ervoor dat kwaadaardige code (XSS-hacks) onschadelijk wordt gemaakt -->
                    <td><?php echo htmlentities($ride['title']); ?></td>
                    
                    <!-- AANPASSING: Eerste letter een hoofdletter via ucfirst() -->
                    <!-- De CSS-klasse 'themagebied' maakt de tekst in deze cel iets lichter groen/grijs -->
                    <td class="themagebied"><?php echo htmlentities(ucfirst($ride['themeland'])); ?></td>
                    
                    <!-- AANPASSING: Eenheid cm erachter geplakt (als er een lengte is ingevuld) -->
                    <td class="lengte">
                        <?php 
                        // Command: Controleer of de kolom 'min_length' in de database niet leeg is
                        if(!empty($ride['min_length'])) {
                            // Er is een lengte, dus toon het getal en plak er handmatig " cm" achter
                            echo htmlentities($ride['min_length']) . " cm"; 
                        } else {
                            // De lengte is leeg/null in de database, toon een liggend streepje
                            echo "-";
                        }
                        ?>
                    </td>
                    
                    <!-- AANPASSING: 1 of 0 omzetten naar Ja of Nee -->
                    <!-- Command: Korte IF-check. Als fast_pass gelijk is aan 1, echo 'Ja', anders echo 'Nee' -->
                    <td><?php echo ($ride['fast_pass'] == 1) ? 'Ja' : 'Nee'; ?></td>
                    
                    <!-- Een linkje naar de edit.php pagina. Het unieke ?id= getal wordt via PHP achter de URL geplakt -->
                    <td><a href="edit.php?id=<?php echo $ride['id']; ?>">aanpassen</a></td>
                </tr>
            <?php endforeach; /* Einde van de foreach-loop. De tabel stopt nu met het genereren van rijen */ ?>
        </table>

    </div>

</body>

</html>
