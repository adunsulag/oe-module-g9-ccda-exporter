<?php
require_once "../../../../globals.php";
use OpenEMR\Modules\G9CcdaExporter\Bootstrap;
use OpenEMR\FHIR\Config\ServerConfig;

// Note we have to grab the event dispatcher from the globals kernel which is instantiated in globals.php
$bootstrap = new Bootstrap($GLOBALS['kernel']->getEventDispatcher());
$globalsConfig = $bootstrap->getGlobalConfig();

$clientId = $globalsConfig->getClientId() ?? "";
$redirectUri = $GLOBALS['site_addr_oath'] . $bootstrap->getPublicUrl("exporter.php");
$launchUri = $GLOBALS['site_addr_oath'] . $bootstrap->getPublicUrl("launch.php");
$scopes = $globalsConfig->getRequiredAppScopes();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php echo xlt("Launch Registration"); ?> - <?php echo text($globalsConfig->getModuleTitle()); ?></title>
        <script src="https://cdn.jsdelivr.net/npm/fhirclient/build/fhir-client.js"></script>
    </head>
    <body>
        <?php if ($globalsConfig->isConfigured()) : ?>
        <p><?php echo xlt("Current registered application"); ?>-<?php echo text($clientId); ?></p>
        <?php endif; ?>
        <p>
            <?php echo xlt("You must register a new smart app with the following settings"); ?>:
        </p>
        <ul>
                <li><?php echo xlt("Redirect URI"); ?>: <?php echo text($redirectUri); ?></li>
                <li><?php echo xlt("Launch URI"); ?>: <?php echo text($launchUri); ?></li>
                <li><?php echo xlt("Scopes"); ?>: <?php echo text($scopes); ?></li>
            </ul>
        <a href="/interface/smart/register-app.php"><?php echo xlt("Register Application Here"); ?></a>
        <?php
        /*
            <!-- eventually we will auto register an application -->
        <!-- <form method="POST">
            <input type="text" name="csrf" value="<?php attr(CsrfUtils::collectCsrfToken()); ?>" />
            <input type="submit" name='register' value="<?php echo xlt("Register New Exporter App"); ?>" />
        </form> -->
        */
        ?>
    </body>
</html>
