<header>
    <div class="container header">
        <!-- Toon het grote logo van de website -->
        <img src="<?php echo $base_url; ?>/img/logo-big-v4.png" alt="logo" class="logo">
        <h1>Attracties</h1>
        <nav>
            <!-- Links voor de navigatie naar de hoofdpagina en het adminpaneel -->
            <a href="<?php echo $base_url; ?>/index.php">Attracties</a> |
            <a href="<?php echo $base_url; ?>/admin/index.php">Admin</a>
            
            <?php // Command: Controleer of de gebruiker is ingelogd ?>
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php // Command: Als de gebruiker is ingelogd, toon de uitlogknop ?>
                | <a href="<?php echo $base_url; ?>/admin/logout.php">Uitloggen</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
