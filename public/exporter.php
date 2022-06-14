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
        <?php Header::setupHeader(['datetime-picker']); ?>
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
        <div class="row">
            <div class="col">
                <h4><?php echo xlt("Current Patient"); ?>
                <span class="patient-name-title d-none"></span></h4>
                <div id="patient"><?php echo xlt("Loading"); ?>...</div>
                </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="start">
                    <?php echo xlt("Start"); ?>:
                </label>
                <input class="form-control datepicker" type='text' id='start' value="" />
            </div>
            <div class="col-4">
                <label for="end">
                    <?php echo xlt("End"); ?>:
                </label>
                    <input class="form-control datepicker" type='text' id='end' value="" />
            </div>
            <div class="col-4">
                <button class="btn btn-primary" disabled="disabled" id='ccda'><?php echo xlt("Generate CCDA"); ?></button>
                <p id="progress" class='d-none'>Generating...</p>
            </div>
        </div>
        <div id="ccda-contents-container" class="d-none row">
            <div class="col">
                <button id='download' class="btn btn-download"><?php echo xlt("Download"); ?></button>
                <textarea id='ccda-contents'></textarea>
            </div>
        </div>
        <script>
            $(function () {
                // special case to deal with static and dynamic datepicker items
                $(document).on('mouseover', '.datepicker', function () {
                    $(this).datetimepicker({
                        <?php $datetimepicker_timepicker = false; ?>
                        <?php $datetimepicker_showseconds = false; ?>
                        <?php $datetimepicker_formatInput = false; ?>
                        <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
                        <?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
                    });
                });
            });
        </script>
        <script src="assets/js/exporter.js" type="text/javascript"></script>
    </body>
</html>
