<?php namespace Appliance\Namirial;

/**
 *  Developers (C) 2019 MwSpace s.r.l <https://mwspace.com>
 *
 *  Copyright © 2018 Namirial S.p.A. <http://www.firmacerta.it/>
 *
 *  This file is part of namirial-php.
 *
 * You should have received a copy of the GNU General Public License
 * along with namirial-php.  If not, see <http://www.gnu.org/licenses/>.
 *
 * To work without composer autoload, include manually all class */

require_once __DIR__ . '/assets/SignIntegrationService.php';

/**
 * SignIntegrationService
 *
 * @package Appliance\Namirial
 */

/**
 * Class Service
 * @package Appliance\Namirial
 */
final class Service
{
    /**
     * @var $client
     * @var $response
     */
    private $client;
    private $response;

    /**
     * Saty constructor.
     * @param string $address
     * @param bool $trace
     */
    public function __construct(string $ipaddress = null)
    {

        $location = 'http://' . $ipaddress . ':8080/SignEngineWeb/services';

        $options = array(
            "location" => $location,
            "exceptions" => true,
            "trace" => true,
            "cache_wsdl" => WSDL_CACHE_NONE,
            "keep_alive" => false
        );

        $this->client = new \SignIntegrationService($location . '?WSDL', $options);

    }

    /**
     * @return SatyClientDebug
     */
    public function debug()
    {
        $this->debug = new \stdClass;

        $this->debug->__getLastRequest = $this->client->__getLastRequest();
        $this->debug->__getLastRequestHeaders = $this->client->__getLastRequestHeaders();

        $this->debug->__getLastResponse = $this->client->__getLastResponse();
        $this->debug->__getLastResponseHeaders = $this->client->__getLastResponseHeaders();

        $this->debug->__getFunctions = $this->client->__getFunctions();
        $this->debug->__getTypes = $this->client->__getTypes();

        return $this->debug;
    }

    /**
     * @param string $username
     * @param string $password
     * @param string|null $securityCode
     * @param int $idOtp
     * @param string|null $opt
     * @return \stdClass
     */
    public function setAgent(string $username, string $password, string $securityCode = null, int $idOtp = null, string $otp = null)
    {
        $this->credentials = new \credentials;
        $this->credentials->username = $username;
        $this->credentials->password = $password;

        $this->credentials->securityCode = $securityCode;
        $this->credentials->idOtp = $idOtp;
        $this->credentials->otp = $otp;

        /**
         * Create Client Helper
         */
        $this->client->credentials = $this->credentials;

        return $this->credentials;

    }

    /**
     * @param bool $withTimestamp
     * @return $this
     */
    private function PDFsetPreference(bool $withTimestamp = false)
    {
        $this->signPreferences = new \pAdESPreferences;
        $this->client->signPreference = 'PAdES';

        return $this->signPreferences;
    }

    /**
     * @param bool $withTimestamp
     * @return \PAdEsPreferences
     */
    private function PAdEsPreferences(bool $withTimestamp = false)
    {
        $this->signPreferences = new \pAdESPreferences;
        $this->client->signPreference = 'PAdES';

        return $this->signPreferences;
    }

    /**
     * @param bool $withTimestamp
     * @return $this
     */
    private function XMLsetPreference(bool $withTimestamp = false)
    {
        $this->signPreferences = new \xAdESPreferences;
        $this->client->signPreference = 'XAdES';

        return $this->signPreferences;
    }

    /**
     * @param bool $withTimestamp
     * @return \xAdESPreferences
     */
    private function XAdESPreferences(bool $withTimestamp = false)
    {
        $this->signPreferences = new \xAdESPreferences;
        $this->client->signPreference = 'XAdES';

        return $this->signPreferences;
    }

    /**
     * @param bool $withTimestamp
     * @return $this
     */
    private function P7MsetPreference(bool $withTimestamp = false)
    {
        $this->signPreferences = new \cAdESPreferences;
        $this->client->signPreference = 'CAdES';

        return $this->signPreferences;
    }

    /**
     * @param bool $withTimestamp
     * @return \cAdESPreferences
     */
    private function CAdEsPreferences(bool $withTimestamp = false)
    {
        $this->signPreferences = new \cAdESPreferences;
        $this->client->signPreference = 'CAdES';

        return $this->signPreferences;
    }

    /**
     * @param string $filepath
     * @param string|null $signPreference
     * @return bool
     * @throws \Exception
     */
    public function sign(string $filepath, string $signPreference = null)
    {

        if (!file_exists($filepath)) {
            throw new \Exception('File not found at ' . $filepath);
        }

        /**
         * Find wich preference has been to set (PDF,XML o P7M)
         */

        if (!in_array(strtoupper(pathinfo($filepath, PATHINFO_EXTENSION)), array('PDF', 'XML', 'P7M'))) {
            throw new \Exception('File Format (.' . pathinfo($filepath, PATHINFO_EXTENSION) . ') not allowed, check ' . $filepath);
        }

        $setPreference = strtoupper(pathinfo($filepath, PATHINFO_EXTENSION)) . 'setPreference';

        try {

            /**  Create Objet */

            $params = new \signWithCredentials;
            $params->credentials = $this->credentials;
            $params->buffer = file_get_contents($filepath);

            if ($signPreference) {

                $signPreference = $signPreference.'Preferences';

                if (!method_exists($this,$signPreference)) {

                    throw new \Exception('Signature Preference not allowed. (CAdES, XAdES or PAdES)');
                }

                $params->AdESPreferences = self::$signPreference();
            } else {
                $params->AdESPreferences = self::$setPreference();
            }

            $this->job = new \stdClass;
            $this->job->signFile = true;

            /**
             * Send Object to Namirial WS
             */
            $response = $this->client->signWithCredentials($params);

            if (isset($response->return)) {

                /**
                 * Create Client Helper
                 */
                $this->client->sign = new \stdClass;
                $this->client->sign->filepath = $filepath;
                $this->client->sign->fileformat = pathinfo($filepath, PATHINFO_EXTENSION);

                /** File has been signed */
                $this->response = $response->return;

                return true;

            } else {
                /** File cant be signed */

                return false;
            }

        } catch (\SoapFault $e) {

            /**
             * File can't be signed, exclude default Soap Fault
             */

            $this->response = $e->getMessage();
            return false;
        }
    }

    /**
     * Verify if Signature is Valid
     * @param string $filepath
     * @return $this|bool
     * @throws \Exception
     */
    public function verify(string $filepath)
    {

        if (!file_exists($filepath)) {
            throw new \Exception('File not found at ' . $filepath);
        }

        if (!in_array(strtoupper(pathinfo($filepath, PATHINFO_EXTENSION)), array('PDF', 'XML', 'P7M'))) {
            throw new \Exception('File Format (.' . pathinfo($filepath, PATHINFO_EXTENSION) . ') not allowed');
        }

        try {
            /**  Create Objet */
            $obj = new \verify;
            $obj->signedContent = file_get_contents($filepath);

            /**
             * Send Object to Namirial WS
             */
            $response = $this->client->verify($obj);
            $this->response = $response->return;

            $this->job = new \stdClass;
            $this->job->verifyFile = true;

            if ($this->response->overallVerified) {

                /**
                 * Create Client Helper
                 */
                $this->client->verify = new \stdClass;
                $this->client->verify->filepath = $filepath;
                $this->client->verify->fileformat = pathinfo($filepath, PATHINFO_EXTENSION);

                //File's Signature is VALID
                return true;
            } else {
                //File's Signature is NOT VALID
                return false;
            }

        } catch (\SoapFault $e) {

            /**
             * File not signed, exclude default Soap Fault
             */
            $this->response = $e->detail->WSException;
            return $this;
        }
    }

    /**
     * @param string|null $filepath
     */
    public function save(string $filepath = null)
    {

        if (!isset($this->response->overallVerified)) {
            if (!isset($this->response)) {
                throw new \Exception('Try to save empty response');
            }
        }

        /**
         * LOAD RESPONSE FROM FILE VERIFICATION
         */
        if (isset($this->job->verifyFile)) {
            if ($this->response->overallVerified) {
                if ($filepath) {

                    try {

                        $directory = dirname($filepath);

                        /** Create dir if not exist */
                        if (!is_dir($directory)) {
                            mkdir($directory);
                        }

                        (file_put_contents($filepath, file_get_contents($this->client->verify->filepath)));

                        /** OLD FILE NAME has been saved */
                        return $filepath;
                    } catch (\Exception $exception) {
                        throw new \Exception($exception->getMessage());
                    }

                } else {

                    $extention = pathinfo($this->client->verify->filepath, PATHINFO_EXTENSION);
                    $directory = dirname($this->client->verify->filepath);
                    $randompath = $directory . '/' . str_random(25) . '.' . $extention;

                    try {

                        (file_put_contents($randompath, file_get_contents($this->client->verify->filepath)));
                        /**
                         * CUSTOM FILE NAME has been saved
                         */
                        return $randompath;
                    } catch (\Exception $exception) {
                        throw new \Exception($exception->getMessage());
                    }
                }
            } else {
                throw new \Exception('File not have valid signature.');
            }
        }

        /**
         * LOAD RESPONSE FROM FILE SIGNATURE
         */
        if (isset($this->job->signFile)) {
            if (isset($this->response)) {
                if ($filepath) {

                    /** Check if p7m */
                    if($this->client->signPreference === 'CAdES'){
                        $filepath .= '.p7m';
                    }

                    try {

                        $directory = dirname($filepath);

                        /** Create dir if not exist */
                        if (!is_dir($directory)) {
                            mkdir($directory);
                        }

                        (file_put_contents($filepath, $this->response));

                        /** OLD FILE NAME has been saved */
                        return $filepath;
                    } catch (\Exception $exception) {
                        throw new \Exception($exception->getMessage());
                    }

                } else {

                    $extention = pathinfo($this->client->sign->filepath, PATHINFO_EXTENSION);
                    $directory = dirname($this->client->sign->filepath);
                    $randompath = $directory . '/' . str_random(25) . '.' . $extention;

                    /** Check if p7m */
                    if($this->client->signPreference === 'CAdES'){
                        $randompath .= '.p7m';
                    }

                    try {

                        (file_put_contents($randompath, $this->response));
                        /**
                         * CUSTOM FILE NAME has been saved
                         */
                        return $randompath;
                    } catch (\Exception $exception) {
                        throw new \Exception($exception->getMessage());
                    }
                }
            } else {
                throw new \Exception('File Signature Response not found');
            }
        }

    }

    /**
     * @throws \Exception
     */
    public function printXml()
    {
        if (!isset($this->client->__last_request)) {
            throw new \Exception('The response not be loaded');
        }

        header('Content-Type: text/xml');
        die($this->response);
    }

    /**
     * @throws \Exception
     */
    public function xmlRequest()
    {
        if (!isset($this->client->__last_request)) {
            throw new \Exception('This request not be loaded');
        }

        header('Content-Type: text/xml');
        die($this->client->__getLastRequest());
    }

    public function xmlResponse()
    {
        if (!isset($this->client->__last_response)) {
            throw new \Exception('This request not be loaded');
        }

        header('Content-Type: text/xml');
        die($this->client->__getLastResponse());
    }

    /**
     * @return array
     */
    public function dump()
    {
        return dump($this);
    }

}
