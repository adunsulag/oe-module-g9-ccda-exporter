<?php

/**
 * Global configuration for the module
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 *
 * @author    Stephen Nielson <stephen@nielson.org>
 * @copyright Copyright (c) 2021 Stephen Nielson <stephen@nielson.org>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

namespace OpenEMR\Modules\G9CcdaExporter;

use OpenEMR\Common\Crypto\CryptoGen;
use OpenEMR\Services\Globals\GlobalSetting;

class GlobalConfig
{
    const CONFIG_CLIENT_ID = 'oe_g9_ccda_exporter_client_id';
    const CONFIG_CLIENT_SECRET = 'oe_g9_ccda_exporter_client_secret';

    private $globalsArray;

    /**
     * @var CryptoGen
     */
    private $cryptoGen;

    public function __construct(array &$globalsArray)
    {
        $this->globalsArray = $globalsArray;
        $this->cryptoGen = new CryptoGen();
    }

    /**
     * Returns true if all of the settings have been configured.  Otherwise it returns false.
     * @return bool
     */
    public function isConfigured()
    {
        $keys = [self::CONFIG_CLIENT_ID, self::CONFIG_CLIENT_SECRET];
        foreach ($keys as $key) {
            $value = $this->getGlobalSetting($key);
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }

    public function getModuleTitle() {
        return xl("(g)(9) Data Export - $docRef CCDA Exporter");
    }

    public function getRequiredAppScopes() {
        return 'launch/patient openid fhirUser patient/Patient.read patient/MedicationRequest.read patient/DocumentReference.read patient/DocumentReference.$docref patient/Document.read';
    }

    public function getClientId()
    {
        return $this->getGlobalSetting(self::CONFIG_CLIENT_ID);
    }

    /**
     * Returns our decrypted value if we have one, or false if the value could not be decrypted or is empty.
     * @return bool|string
     */
    public function getClientSecret()
    {
        $encryptedValue = $this->getGlobalSetting(self::CONFIG_CLIENT_SECRET);
        return $this->cryptoGen->decryptStandard($encryptedValue);
    }

    public function getGlobalSetting($settingKey)
    {
        return $this->globalsArray[$settingKey] ?? null;
    }

    public function getGlobalSettingSectionConfiguration()
    {
        $settings = [
            self::CONFIG_CLIENT_ID => [
                'title' => 'SMART App client id'
                ,'description' => 'Public client_id of the registered ccda exporter client application'
                ,'type' => GlobalSetting::DATA_TYPE_TEXT
                ,'default' => ''
            ]
            ,self::CONFIG_CLIENT_SECRET => [
                'title' => 'SMART App Private Key (Encrypted)'
                ,'description' => 'Private secret_key of the registered ccda exporter client application'
                ,'type' => GlobalSetting::DATA_TYPE_ENCRYPTED
                ,'default' => ''
            ]
        ];
        return $settings;
    }
}
