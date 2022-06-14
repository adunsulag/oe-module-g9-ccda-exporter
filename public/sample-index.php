<?php

use OpenEMR\Core\Header;
use OpenEMR\Modules\G9CcdaExporter\Bootstrap;
use OpenEMR\FHIR\Config\ServerConfig;

require_once "../../../../globals.php";

// Note we have to grab the event dispatcher from the globals kernel which is instantiated in globals.php
$bootstrap = new Bootstrap($GLOBALS['kernel']->getEventDispatcher());
$globalConfig = $bootstrap->getGlobalConfig();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php Header::setupHeader(); ?>
        <meta charset="UTF-8" />
        <title><?php echo text($globalConfig->getModuleTitle()); ?></title>
        <script src="https://cdn.jsdelivr.net/npm/fhirclient/build/fhir-client.js"></script>
        <link href="assets/css/exporter.css" media="screen" rel="stylesheet" />
    </head>
    <body class="container-fluid">
        <div class="row">
            <div class="col">
                <h1><?php echo text($globalConfig->getModuleTitle()); ?></h1>
            </div>
        </div>

        <ul class="nav flex-column">
            <?php if ($globalConfig->isConfigured()) : ?>
            <li class="nav-item"><a class="nav-link" href="launch.php">Launch CCDA Exporter</a></li>
            <?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="register-app.php">Registration Instructions</a></li>
        </ul>
    </body>
</html>
