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

if (!extension_loaded('soap')) {
    throw new \Exception('Soap php module are required for this library. Please install .dll');

} else {
    require_once __DIR__ . '/assets/SignIntegrationService.php';
}

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
     * Service constructor.
     * @param string|null $ipaddress
     * @throws \Exception
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
     * @return \stdClass
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
     * @return mixed
     */
    public function report()
    {
        return $this->response->noteReportList;
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
     * @return \pAdESPreferences
     */
    private function PAdEsPreferences(bool $withTimestamp = false)
    {

        $signerImage = new \signerImage;
        $signerImage->image = file_get_contents(__DIR__ . "/assets/logo_firmacerta.jpg");
        $signerImage->x = 0;
        $signerImage->y = 100;
        $signerImage->width = 500;
        $signerImage->height = 500;
        $signerImage->textVisible = isset($this->client->textVisible) ? $this->client->textVisible : TRUE;

        $this->signPreferences = new \pAdESPreferences;

        $this->signPreferences->page = isset($this->client->pageStamp) ? $this->client->pageStamp : 1;
        $this->signPreferences->signerImage = $signerImage;

        $this->client->signPreference = 'PAdES';
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
     * @param bool $return
     * @param string|null $signPreference
     * @return Service|bool
     * @throws \Exception
     */
    public function sign(string $filepath, string $signPreference = null, bool $return = null)
    {

        if (!file_exists($filepath)) {
            throw new \Exception('File not found at ' . $filepath);
        }

        /**
         * Create Client Helper
         */
        $this->client->sign = new \stdClass;
        $this->client->sign->filepath = $filepath;
        $this->client->sign->fileformat = pathinfo($filepath, PATHINFO_EXTENSION);

        /**
         * Find wich preference has been to set (PDF,XML o P7M)
         */

        switch (strtoupper(pathinfo($filepath, PATHINFO_EXTENSION))) {
            case 'PDF':
                $setPreference = 'PAdESPreferences';
                break;
            case 'XML':
                $setPreference = 'XAdESPreferences';
                break;
            default:
                $setPreference = 'CAdESPreferences';
        }

        /**
         * Find wich preference has been to set (PDF,XML o P7M)
         */
        try {

            /**  Create Objet */

            $params = new \signWithCredentials;
            $params->credentials = $this->credentials;
            $params->buffer = file_get_contents($filepath);

            if ($signPreference) {

                $signPreference = $signPreference . 'Preferences';

                if (!method_exists($this, $signPreference)) {

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

                /** File has been signed */
                $this->response = $response->return;

                return ($return) ? true : $this;

            } else {
                /** File cant be signed */

                return ($return) ? false : $this;
            }

        } catch (\SoapFault $e) {

            /**
             * File can't be signed, exclude default Soap Fault
             */

            $this->response = $e->getMessage();
            return ($return) ? false : $this;
        }
    }

    /**
     * @param string $filecontents
     * @param string|null $signPreference
     * @param bool|null $return
     * @return Service|bool
     * @throws \Exception
     */
    public function signContents(string $filecontents, string $signPreference = null, bool $return = null)
    {

        /**
         * Create Client Helper
         */
        $this->client->sign = new \stdClass;
        $this->client->sign->filecontents = $filecontents;

        /**
         * Get extention from buffer
         */
        $file_info = new \finfo(FILEINFO_MIME_TYPE);
        $mime_type = $file_info->buffer($filecontents);
        $extention = array_reverse(explode('/', $mime_type))[0];


        $this->client->sign->filecontentsextention = $extention;

        /**
         * Find wich preference has been to set (PDF,XML o P7M)
         */

        switch (strtoupper($extention)) {
            case 'PDF':
                $setPreference = 'PAdESPreferences';
                break;
            case 'XML':
                $setPreference = 'XAdESPreferences';
                break;
            default:
                $setPreference = 'CAdESPreferences';
        }

        /**
         * Find wich preference has been to set (PDF,XML o P7M)
         */
        try {

            /**  Create Objet */

            $params = new \signWithCredentials;
            $params->credentials = $this->credentials;
            $params->buffer = $filecontents;

            if ($signPreference) {

                $signPreference = $signPreference . 'Preferences';

                if (!method_exists($this, $signPreference)) {

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

                /** File has been signed */
                $this->response = $response->return;

                return ($return) ? true : $this;

            } else {
                /** File cant be signed */

                return ($return) ? false : $this;
            }

        } catch (\SoapFault $e) {

            /**
             * File can't be signed, exclude default Soap Fault
             */

            $this->response = $e->getMessage();
            return ($return) ? false : $this;
        }
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        if (isset($this->client->sign->filecontents)) {
            return $this->response;
        } elseif (isset($this->client->verify->filecontents)) {

            /**
             * Try to check if p7m
             */
            if ($this->client->verify->fileformat === 'octet-stream') {

                return $this->response->plainDocument;
            } else {

                return $this->client->verify->filecontents;
            }

        } else {

            throw new \Exception('Get method return empty');
        }
    }

    /**
     * @return mixed
     */
    public function ext()
    {
        if (isset($this->client->sign->filecontents)) {
            return '.' . $this->client->sign->filecontentsextention;
        }
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function force()
    {
        if ($this->job->verifyFile) {
            $this->client->forceVerify = true;
            return $this;
        } else {

            throw new \Exception('Verify method not found');
        }
    }

    /**
     * @param string $filepath
     * @param bool $return
     * @return $this
     * @throws \Exception
     */
    public function verify(string $filepath, bool $return = null)
    {

        if (!file_exists($filepath)) {
            throw new \Exception('File not found at ' . $filepath);
        }

        if (!in_array(strtoupper(pathinfo($filepath, PATHINFO_EXTENSION)), array('PDF', 'XML', 'P7M'))) {
            throw new \Exception('File Format (.' . pathinfo($filepath, PATHINFO_EXTENSION) . ') not allowed');
        }

        $this->job = new \stdClass;
        $this->job->verifyFile = true;

        /**
         * Create Client Helper
         */
        $this->client->verify = new \stdClass;
        $this->client->verify->filepath = $filepath;
        $this->client->verify->fileformat = pathinfo($filepath, PATHINFO_EXTENSION);

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
                return ($return) ? true : $this;

            } else {
                //File's Signature is NOT VALID
                return ($return) ? false : $this;
            }

        } catch (\SoapFault $e) {

            /**
             * File not signed, exclude default Soap Fault
             */
            $this->response = $e->detail->WSException;
            return ($return) ? false : $this;
        }
    }

    /**
     * @param string $filecontents
     * @param bool|null $return
     * @return Service|bool
     */
    public function verifyContents(string $filecontents, bool $return = null)
    {

        $this->job = new \stdClass;
        $this->job->verifyFile = true;

        /**
         * Create Client Helper
         */
        $this->client->verify = new \stdClass;
        $this->client->verify->filecontents = $filecontents;

        /**
         * Get extention from buffer
         */
        $file_info = new \finfo(FILEINFO_MIME_TYPE);
        $mime_type = $file_info->buffer($filecontents);
        $extention = array_reverse(explode('/', $mime_type))[0];

        $this->client->verify->fileformat = $extention;

        try {
            /**  Create Objet */
            $obj = new \verify;
            $obj->signedContent = $filecontents;

            /**
             * Send Object to Namirial WS
             */
            $response = $this->client->verify($obj);
            $this->response = $response->return;

            if ($this->response->overallVerified) {

                //File's Signature is VALID
                return ($return) ? true : $this;

            } else {
                //File's Signature is NOT VALID
                return ($return) ? false : $this;
            }

        } catch (\SoapFault $e) {

            /**
             * File not signed, exclude default Soap Fault
             */
            $this->response = $e->detail->WSException;
            return ($return) ? false : $this;
        }
    }

    /**
     * @param string $filepath
     * @throws \Exception
     */
    public function isValid(string $filepath)
    {
        self::verify($filepath, true);
    }

    /**
     * @param string|null $filepath
     * @return string
     * @throws \Exception
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
            if (isset($this->client->forceVerify) || $this->response->overallVerified) {
                if ($filepath) {

                    /** Check if p7m */
                    if (pathinfo($this->client->verify->filepath, PATHINFO_EXTENSION) === 'p7m') {
                        $contentFile = $this->response->plainDocument;
                    } else {
                        $contentFile = file_get_contents($this->client->verify->filepath);
                    }

                    try {

                        $directory = dirname($filepath);

                        /** Create dir if not exist */
                        if (!is_dir($directory)) {
                            mkdir($directory);
                        }

                        (file_put_contents($filepath, $contentFile));

                        /** OLD FILE NAME has been saved */
                        return $filepath;
                    } catch (\Exception $exception) {
                        throw new \Exception($exception->getMessage());
                    }

                } else {

                    /** Check if p7m */
                    if (pathinfo($this->client->verify->filepath, PATHINFO_EXTENSION) === 'p7m') {
                        $this->client->verify->filepath = str_replace('.p7m', '', $this->client->verify->filepath);
                        $contentFile = $this->response->plainDocument;
                    } else {
                        $contentFile = file_get_contents($this->client->verify->filepath);
                    }

                    $extention = pathinfo($this->client->verify->filepath, PATHINFO_EXTENSION);
                    $directory = dirname($this->client->verify->filepath);
                    $randompath = $directory . '/valid/';

                    /** Create dir if not exist */
                    if (!is_dir($randompath)) {
                        mkdir($randompath);
                    }

                    $randompath .= str_random(25) . '.' . $extention;

                    try {

                        (file_put_contents($randompath, $contentFile));

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
                    if ($this->client->signPreference === 'CAdES') {
                        if (pathinfo($filepath, PATHINFO_EXTENSION) !== 'p7m') {
                            throw new \Exception('Cant save CAdES file withoud .p7m');
                        }
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

                } elseif (isset($this->client->override)) {

                    /** Check if p7m */
                    if ($this->client->signPreference === 'CAdES') {
                        throw new \Exception('Override funct not work with .p7m file');
                    }

                    try {

                        (file_put_contents($this->client->sign->filepath, $this->response));
                        /**
                         * FILE has been overrided
                         */
                        return $this->client->sign->filepath;
                    } catch (\Exception $exception) {
                        throw new \Exception($exception->getMessage());
                    }

                } else {

                    $extention = pathinfo($this->client->sign->filepath, PATHINFO_EXTENSION);
                    $directory = dirname($this->client->sign->filepath);
                    $randompath = $directory . '/signed/';

                    /** Create dir if not exist */
                    if (!is_dir($randompath)) {
                        mkdir($randompath);
                    }

                    $randompath .= str_random(25) . '.' . $extention;

                    /** Check if p7m */
                    if ($this->client->signPreference === 'CAdES') {
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
     * Verify if Virtual Device of Namirial sws exist.
     *
     * @throws \Exception
     */
    public function checkDevice()
    {

        $domtree = new \DOMDocument('1.0', 'UTF-8');
        $xmlRoot = $domtree->createElement("xml");
        $xmlRoot = $domtree->appendChild($xmlRoot);
        $currentTrack = $domtree->createElement("verifySign");
        $currentTrack = $xmlRoot->appendChild($currentTrack);
        $currentTrack->appendChild($domtree->createElement('username', $this->credentials->username));
        $currentTrack->appendChild($domtree->createElement('password', $this->credentials->password));

        $params = new \signWithCredentials;
        $params->credentials = $this->credentials;
        $params->buffer = $domtree->saveXML();

        $params->AdESPreferences = self::XAdESPreferences();

        try {

            /** Try to response if exist */
            $response = $this->client->signWithCredentials($params);

        } catch (\SoapFault $exception) {

            throw new \Exception($exception->getMessage());
        }

    }

    /**
     * @throws \Exception
     */
    public function override()
    {
        $this->client->override = true;
        self::save();
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

    /**
     * @throws \Exception
     */
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
