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
    public function PDFsetPreference(bool $withTimestamp = false)
    {
        $this->signPreferences = new \PAdEsPreferences;

        return $this->signPreferences;
    }

    /**
     * @param bool $withTimestamp
     * @return $this
     */
    public function XMLsetPreference(bool $withTimestamp = false)
    {
        $this->signPreferences = new \xAdESPreferences;

        return $this->signPreferences;
    }

    /**
     * @param bool $withTimestamp
     * @return $this
     */
    public function P7MsetPreference(bool $withTimestamp = false)
    {
        $this->signPreferences = new \CAdEsPreferences;

        return $this->signPreferences;
    }

    /**
     * @return $this
     */
    public function withTimestamp(string $timestampUrl)
    {
        $this->signPreferences->withTimestamp = true;
        $this->signPreferences->timestampUrl = $timestampUrl;
        $this->signPreferences->timestampUsername = $timestampUsername;
        $this->signPreferences->timestampPassword = $timestampPassword;
        return $this;
    }

    /**
     * @param string $filepath
     * @return $this
     * @throws \Exception
     */
    public function sign(string $filepath)
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

            $params->AdESPreferences = self::$setPreference();

            /**
             * Send Object to Namirial WS
             */
            $response = $this->client->signWithCredentials($params);

            $this->response = isset($response->return) ? $response->return : $response;
            return $this;

        } catch (\SoapFault $e) {

            /**
             * File can't be signed, exclude default Soap Fault
             */

            $this->response = $e->getMessage();
            return $this;
        }
    }

    /**
     * @param string $filepath
     * @return $this
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

            /**
             * Create Client Helper
             */
            $this->client->verify = new \stdClass;
            $this->client->verify->filepath = $filepath;
            $this->client->verify->fileformat = pathinfo($filepath, PATHINFO_EXTENSION);

            return $this;

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
    public function save(string $directory = null)
    {

        if (is_file($directory)) {
            throw new \Exception('This parameter can be only a dir/');
        }

        if (!isset($this->response->overallVerified)) {
            if (!isset($this->response->return)) {
                throw new \Exception('U try to save empty response');
            }
        }

        if ($this->response->overallVerified) {
            $Dir = str_replace(basename($this->client->verify->filepath), '', $this->client->verify->filepath);
            $File = str_replace('.p7m', '', basename($this->client->verify->filepath));
            $directory = isset($directory) ? rtrim(trim($directory), '/') : rtrim(trim($Dir), '/');

            file_put_contents("$directory/$File", $this->response->plainDocument);
        }

    }

    /**
     * Verify if Signature is Valid
     * @param string $filepath
     * @return $this|bool
     * @throws \Exception
     */
    public function isValid(string $filepath)
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

            if ($this->response->overallVerified) {
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
