<?php
require_once "../../../../globals.php";
use OpenEMR\Modules\G9CcdaExporter\Bootstrap;
use OpenEMR\FHIR\Config\ServerConfig;

// Note we have to grab the event dispatcher from the globals kernel which is instantiated in globals.php
$bootstrap = new Bootstrap($GLOBALS['kernel']->getEventDispatcher());
$globalsConfig = $bootstrap->getGlobalConfig();

$clientId = $globalsConfig->getClientId();
$fhirUrl = (new ServerConfig())->getFhirUrl();
$redirectUri = "exporter.php";
$scopes = $globalsConfig->getRequiredAppScopes();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php echo xlt("Launch"); ?> <?php echo text($globalsConfig->getModuleTitle()); ?></title>
        <script src="https://cdn.jsdelivr.net/npm/fhirclient/build/fhir-client.js"></script>
    </head>
    <body>
        <script>
            FHIR.oauth2.authorize({

              // The client_id that you should have obtained after registering a client at
              // the EHR.
              clientId: <?php echo js_escape($clientId); ?>,
              iss: <?php echo js_escape($fhirUrl); ?>,

              // The scopes that you request from the EHR. In this case we want to:
              // launch            - Get the launch context
              // openid & fhirUser - Get the current user
              // patient/*.read    - Read patient data
              scope: <?php echo js_escape($scopes); ?>,

              // Typically, if your redirectUri points to the root of the current directory
              // (where the launchUri is), you can omit this option because the default value is
              // ".". However, some servers do not support directory indexes so "." and "./"
              // will not automatically map to the "index.html" file in that directory.
              redirectUri: "exporter.php"
            });
        </script>
    </body>
</html>
