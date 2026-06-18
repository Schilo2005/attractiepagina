<?php
// Start de sessie voor het controleren van de inlogstatus (veiligheid)
session_start();
// Laad het configuratiebestand (hierin staan instellingen zoals de $base_url)
require_once '../backend/config.php';

// Command: Controleer of de gebruiker NIET is ingelogd
if(!isset($_SESSION['user_id']))
{
    // Maak een waarschuwingstekst aan
    $msg = "Je moet eerst inloggen!";
    // Stuur de gebruiker direct terug naar het loginscherm
    header("Location: $base_url/admin/login.php?msg=$msg");
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
    <!-- Zorgt ervoor dat de formulieren netjes meeschalen op telefoons (responsive) -->
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

    <?php // Laad de header/menubalk in uit de mappenstructuur hierboven 
    require_once '../../header.php'; ?>
    
    <!-- De hoofdcontainer die het formulier netjes binnen de zijkanten houdt -->
    <div class="container">

        <h2>Attractie aanpassen</h2>

        <?php 
        // Command: Haal het unieke ID van de attractie op uit de URL-balk (bijv. edit.php?id=5)
        $id = $_GET['id'];
        // Maak verbinding met de database
        require_once '../backend/conn.php';
        // Command: SQL-query om de specifieke attractie met DIT ID op te zoeken in de tabel 'rides'
        $query = "SELECT * FROM rides WHERE id = :id";
        // Bereid de query veilig voor op de database-server
        $statement = $conn->prepare($query);
        // Voer de query uit en vervang de placeholder :id door het echte ID-getal
        $statement->execute([":id" => $id]);
        // Haal de gegevens van deze ene attractie op als een lijst en stop het in $ride
        $ride = $statement->fetch(PDO::FETCH_ASSOC);
        ?>

        <!-- FIX: enctype="multipart/form-data" toegevoegd zodat de file-upload (afbeelding) werkt -->
        <!-- Command: Formulier stuur alle aanpassingen via POST naar de ridesController -->
        <form action="../backend/ridesController.php" method="POST" enctype="multipart/form-data">
            
            <!-- Onzichtbare invoervelden om de actie, het ID en de oude afbeelding stiekem mee te sturen naar de controller -->
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="old_img" value="<?php echo $ride['img_file']; ?>">

            <!-- Invoerveld voor de titel -->
            <div class="form-group">
                <label for="title">Titel:</label>
                <!-- value zorgt ervoor dat de huidige titel uit de database alvast in het tekstvak staat -->
                <input type="text" name="title" id="title" class="form-input" value="<?php echo htmlentities($ride['title']); ?>">
            </div>
            
            <!-- OPDRACHT: Beschrijving (description) toegevoegd -->
            <div class="form-group">
                <label for="description">Beschrijving:</label>
                <!-- De huidige beschrijving wordt netjes tussen de <textarea> tags geplaatst -->
                <textarea name="description" id="description" class="form-input" rows="5"><?php echo htmlentities($ride['description']); ?></textarea>
            </div>

            <!-- Dropdown-menu voor het themagebied -->
            <div class="form-group">
                <label for="themeland">Themagebied:</label>
                <!-- Command: Selecteer automatisch de juiste optie die in de database staat via een korte if-check -->
                <select name="themeland" id="themeland" class="form-input">
                    <option value=""> - kies een optie - </option>
                    <!-- Als het themagebied 'familyland' is, typt PHP hier 'selected' waardoor deze optie actief staat -->
                    <option value="familyland" <?php if($ride['themeland'] == 'familyland') echo 'selected'; ?>>Familyland</option>
                    <option value="waterland" <?php if($ride['themeland'] == 'waterland') echo 'selected'; ?>>Waterland</option>
                    <option value="adventureland" <?php if($ride['themeland'] == 'adventureland') echo 'selected'; ?>>Adventureland</option>
                </select>
            </div>

            <!-- OPDRACHT: Minimale lengte (min_length) toegevoegd -->
            <div class="form-group">
                <label for="min_length">Minimale lengte (in cm):</label>
                <!-- type="number" zorgt dat je alleen getallen kunt invullen, min="0" voorkomt negatieve getallen -->
                <input type="number" name="min_length" id="min_length" class="form-input" min="0" value="<?php echo htmlentities($ride['min_length']); ?>">
            </div>

            <!-- Invoerveld voor de afbeelding -->
            <div class="form-group">
                <label for="img_file">Afbeelding:</label>
                <!-- Command: Toon een kleine voorvertoning van de huidige afbeelding die nu in de database staat -->
                <img src="<?php echo $base_url . "/img/attracties/" . $ride['img_file']; ?>" alt="attractiefoto" style="max-width: 120px; display: block; margin-bottom: 10px;">
                <!-- Knop waarmee de bezoeker een NIEUWE foto kan uitkiezen op zijn computer -->
                <input type="file" name="img_file" id="img_file" class="form-input">
            </div>
            
            <!-- Selectievakje (checkbox) voor de Fast Pass -->
            <div class="form-group">
                <label for="fast_pass">FAST PASS:</label>
                <!-- Command: Vink het selectievakje automatisch aan als fast_pass in de database 1 (true) is -->
                <input type="checkbox" name="fast_pass" id="fast_pass" value="1" <?php if($ride['fast_pass']) echo 'checked'; ?>>
                <label for="fast_pass">Voor deze attractie is een FAST PASS nodig.</label>
            </div>

            <!-- Knop om alle ingevulde wijzigingen definitief op te slaan -->
            <input type="submit" value="Attracties aanpassen">
        </form>
        
        <hr> <!-- Tekent een horizontale scheidingslijn op de pagina -->
        
        <!-- Command: Apart formulier om deze specifieke attractie volledig te verwijderen -->
        <!-- Dit staat in een los formulier zodat de knop 'Verwijderen' een eigen actie (delete) kan afvuren -->
        <form action="../backend/ridesController.php" method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <!-- De definitieve verwijderknop -->
            <input type="submit" value="Verwijderen">
        </form>

    </div>

</body>

</html>
