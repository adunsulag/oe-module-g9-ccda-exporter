# OpenEMR G9 CCD Exporter Project
This is a sample module project that developers can use to see an example SMART on FHIR application that uses some of the FHIR apis.
This sample application demonstrates the (g)(9) ONC Data Export requirements for generating or retrieving a CCD for a selected patient.
It uses the smart client javascript library to communication with the OpenEMR server and generate a Clinical Summary of  Care Document (CCD).

To use this module you'll need to enable the menu option in the global settings.  Instructions for registering a client application are in the
Modules -> G9 CCDA Exporter -> Registration Instructions.

Once you've registered your app with the appropriate scopes, you'll need to set the client_id and secret_key in the Globals -> G9 CCDA Exporter Module settings.


### Installing Module Via Composer
There are two ways to install your module via composer.
#### Public Module
We highly encourage you to share your created modules with the OpenEMR community.  To ensure that other developers / users can install
your packages please register your module on [https://packagist.org/](https://packagist.org/).  Once your module has been registered
users can install your package by doing a `composer require "<namespace>/<your-package-name>`
#### Private Module
If your module is a private module you can still tell composer where to find your module by setting it up to use a private repository.
You can do it with the following command:
```
composer config repositories.repo-name vcs https://github.com/<organization or user name>/<repository name>
```
For example to install this skeleton as a module you can run the following
```
composer config repositories.repo-name vcs https://github.com/adunsulag/oe-module-g9-ccda-exporter
```

At that point you can run the install command
```
composer require adunsulag/oe-module-custom-skeleton
```

### Installing Module via filesystem
If you copy your module into the installation directory you will need to copy your module's composer.json "psr-4" property into your OpenEMR's psr-4 settings.
You will also need to run a ```composer dump-autoload``` wherever your openemr composer.json file is located in order to get your namespace properties setup properly
to include your module.

### Activating Your Module
Install your module using either composer (recommended) or by placing your module in the *<openemr_installation_directory>//interface/modules/custom_modules/*.

Once your module is installed in OpenEMR custom_modules folder you can activate your module in OpenEMR by doing the following.

  1. Login to your OpenEMR installation as an administrator
  2. Go to your menu and select Modules -> Manage Modules
  3. Click on the Unregistered tab in your modules list
  4. Find your module and click the *Register* button.  This will reload the page and put your module in the Registered list tab of your modules
  5. Now click the *Install* button next your module name.
  6. Finally click the *Enable* button for your module.

## Contributing
If you would like to help in improving this module just post an issue on Github or send a pull request.
