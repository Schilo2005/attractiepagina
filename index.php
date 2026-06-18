<?php
// Start de gebruikerssessie (onthoudt bijvoorbeeld of iemand is ingelogd)
session_start();
// Haal het configuratiebestand op (hierin staan instellingen zoals de $base_url)
require_once 'admin/backend/config.php';
?>

<!doctype html>
<!-- Geeft aan dat dit een HTML5 document is -->
<html lang="nl">
<!-- Start van het HTML-document, ingesteld op de Nederlandse taal -->

<head>
    <!-- De titel die je bovenin het tabblad van de browser ziet -->
    <title>Attractiepagina</title>
    <!-- Zorgt ervoor dat speciale tekens (zoalsë of ó) goed worden weergegeven -->
    <meta charset="utf-8">
    <!-- BELANGRIJK: Dit zorgt ervoor dat de website de breedte van het telefoonscherm herkent (voor responsive) -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Maakt alvast verbinding met de servers van Google voor de lettertypes -->
    <link rel="preconnect" href="https://gstatic.com">
    <!-- Haalt de lettertypes op van Google Fonts -->
    <link href="https://googleapis.com" rel="stylesheet">
    
    <!-- Laadt een CSS-bestand dat zorgt dat de website er in alle browsers hetzelfde uitziet -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/normalize.css">
    <!-- Laadt jouw eigen CSS-bestand voor de styling van de website -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/main.css">
    <!-- Laadt het kleine icoontje (de favicon) dat je in het tabblad van de browser ziet -->
    <link rel="icon" href="<?php echo $base_url; ?>/favicon.ico" type="image/x-icon" />
</head>

<body>

    <?php // Laad de menubalk/header in vanaf een los bestand (zodat je dit niet op elke pagina opnieuw hoeft te typen)
    require_once 'header.php'; ?>
    
    <!-- De hoofdcontainer die de zijbalk en de attracties netjes bij elkaar houdt -->
    <div class="container content flex-layout">
        
        <!-- aside wordt gebruikt voor een zijbalk (sidebar) met extra informatie of filters -->
        <aside class="sidebar-filters">
            <!-- Start van het formulier. GET betekent dat de filters in de URL-balk komen te staan -->
            <form action="" method="GET">
                
                <!-- Filter 1: Een dropdown-menu (select) om een themagebied te kiezen -->
                <div class="filter-group">
                    <select name="themagebied">
                        <option value="">Themagebied...</option>
                        <option value="familyland">Familyland</option>
                        <option value="adventureland">Adventureland</option>
                        <option value="waterland">Waterland</option>
                    </select>
                </div>

                <!-- Filter 2: Een dropdown-menu (select) om te filteren op Fast Pass -->
                <div class="filter-group">
                    <select name="fastpass">
                        <option value="">Fast Pass...</option>
                        <option value="1">Ja</option>
                        <option value="0">Nee</option>
                    </select>
                </div>

                <!-- Filter 3: Een tekstvak (input) waarin de bezoeker zelf een zoekwoord kan typen -->
                <div class="filter-group search-box">
                    <input type="text" name="search" placeholder="Zoeken...">
                    <!-- De knop met het vergrootglas om de zoekopdracht te versturen -->
                    <button type="submit" class="search-btn">🔍</button>
                </div>
                
                <!-- Een normale link om alle filters te wissen en de pagina te verversen -->
                <div class="filter-group">
                    <a href="index.php" class="clear-filters-btn">Filters wissen</a>
                </div>

            </form>
        </aside>

        <!-- main geeft aan dat dit de belangrijkste inhoud (de hoofdtekst) van de pagina is -->
        <main class="main-content">
            <!-- Een container waar alle losse attractie-kaartjes in zitten -->
            <div class="attracties">

                <!-- ATTRACTIE 1: CAROUSSEL -->
                <!-- Dit is de box (kaartje) voor de eerste attractie -->
                <div class="attractie-card">
                    <!-- De box waar de afbeelding in zit -->
                    <div class="card-image">
                        <!-- De afbeelding van de caroussel. alt is de tekst als de afbeelding niet laadt -->
                        <img src="img/attracties/alex-kalinin-6gYjwD4s9xk-unsplash.jpg" alt="Caroussel">
                    </div>
                    <!-- De box waar alle tekst van de attractie in staat -->
                    <div class="card-body">
                        <p class="ride-area">FAMILYLAND</p>
                        <h2 class="ride-title">Caroussel</h2>
                        <p class="ride-description">Voor de allerkleinsten: maak een rondje in de antieke draaimolen.</p>
                        <p class="length">minimale lengte</p>
                    </div>
                </div>

                <!-- ATTRACTIE 2: GOUDVISSEN -->
                <div class="attractie-card">
                    <div class="card-image">
                        <img src="img/attracties/adger-kang-oiyzr-SgjBY-unsplash.jpg" alt="Goudvissen">
                    </div>
                    <div class="card-body">
                        <p class="ride-area">WATERLAND</p>
                        <h2 class="ride-title">Goudvissen</h2>
                        <p class="ride-description">Alleen open bij mooi weer. U kunt nat worden (of gebeten door een goudvis).</p>
                        <p class="length">90cm minimale lengte</p>
                    </div>
                </div>

                <!-- ATTRACTIE 3: HOUTEN ACHTBAAN -->
                <div class="attractie-card">
                    <div class="card-image">
                        <img src="img/attracties/brandon-hoogenboom-P0MX2XCqbFc-unsplash.jpg" alt="Houten achtbaan">
                    </div>
                    <div class="card-body">
                        <p class="ride-area">ADVENTURELAND</p>
                        <h2 class="ride-title">Houten achtbaan</h2>
                        <p class="ride-description">De houten achtbaan is gesloten voor renovatie.</p>
                        <p class="length">90cm minimale lengte</p>
                    </div>
                </div>

                <!-- ATTRACTIE 4: IRVIN'S PRESENT -->
                <div class="attractie-card">
                    <div class="card-image">
                        <img src="img/attracties/david-murcia-HbYniDwjbVE-unsplash.jpg" alt="Irvin's Present">
                    </div>
                    <div class="card-body">
                        <p class="ride-area">FAMILYLAND</p>
                        <h2 class="ride-title">Irvin's Present</h2>
                        <p class="ride-description">Win de mooiste prizes bij Irvin (en betaal direct 85% administratiekosten).</p>
                        <p class="length">minimale lengte</p>
                    </div>
                </div>

                <!-- ATTRACTIE 5: KINDERACHTBAAN -->
                <div class="attractie-card">
                    <div class="card-image">
                        <img src="img/attracties/chris-slupski-QLqIqIhMiNs-unsplash.jpg" alt="Kinderachtbaan">
                    </div>
                    <div class="card-body">
                        <p class="ride-area">FAMILYLAND</p>
                        <h2 class="ride-title">Kinderachtbaan</h2>
                        <p class="ride-description">Spanning en sensatie speciaal voor de kleintjes.</p>
                        <p class="length">90cm minimale lengte</p>
                    </div>
                </div>

                <!-- ATTRACTIE 6: NITRO -->
                <div class="attractie-card">
                    <div class="card-image">
                        <img src="img/attracties/frenjamin-benklin-fiDVCWI9IUI-unsplash.jpg" alt="Nitro">
                    </div>
                    <div class="card-body">
                        <p class="ride-area">ADVENTURELAND</p>
                        <h2 class="ride-title">Nitro</h2>
                        <p class="ride-description">Nitro is tijdelijk gesloten op last van de politie wegens een ongeval.</p>
                        <p class="length">90cm minimale lengte</p>
                        <!-- Een extra label (badge) dat specifiek bij deze attractie laat zien dat er een Fast Pass is -->
                        <div class="badge fast-pass">🎟️ FAST PASS</div>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>

</html>
