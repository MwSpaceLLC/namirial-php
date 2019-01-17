<?php

/**
 * Copyright (C) 2019 MwSpace s.r.l <https://mwspace.com>
 *
 * This file is part of namirial-php.
 *
 * You should have received a copy of the GNU General Public License
 * along with namirial-php.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Xela\Namirial;

final class Saty
{
    private $client = null;

    /**
     * Saty constructor.
     * @param string $address
     * @param bool $trace
     */
    public function __construct(string $address, bool $trace = true)
    {

        $this->client = new SatyClient(
            'http://' . $address . ':8080/SignEngineWeb/services?WSDL', array(
                'location' => 'http://' . $address . ':8080/SignEngineWeb/services',
                'cache_wsdl' => WSDL_CACHE_NONE,
                'trace' => $trace,
                'exceptions' => true
            )
        );

    }

    /**
     * @param string $username
     * @param string $password
     * @param string|null $securityCode
     * @param int $idOtp
     * @param string|null $opt
     * @return \stdClass
     */
    public function setAgent(string $username, string $password, string $securityCode = null, int $idOtp = null, string $opt = null)
    {
        $this->credentials = new SatyCredential;
        $this->credentials->username = $username;
        $this->credentials->password = $password;
        ($securityCode !== null) ? $this->credentials->securityCode = $securityCode : null;
        ($idOtp !== null) ? $this->credentials->idOtp = $idOtp : null;
        ($opt !== null) ? $this->credentials->opt = $opt : null;

        return $this->credentials;

    }

    /**
     * @param bool $withTimestamp
     * @return $this
     */
    public function PDFsetPreference(bool $withTimestamp = false)
    {
        $this->signPreferences = new SatyPAdEsPreferences;
        $this->signPreferences->withTimestamp = $withTimestamp;

        return $this->signPreferences;
    }

    /**
     * @param bool $withTimestamp
     * @return $this
     */
    public function XMLsetPreference(bool $withTimestamp = false)
    {
        $this->signPreferences = new SatyXAdEsPreferences;
        $this->signPreferences->withTimestamp = $withTimestamp;

        return $this->signPreferences;
    }

    /**
     * @param bool $withTimestamp
     * @return $this
     */
    public function P7MsetPreference(bool $withTimestamp = false)
    {
        $this->signPreferences = new SatyCAdEsPreferences;
        $this->signPreferences->withTimestamp = $withTimestamp;

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
            throw new SatyException('File not found at ' . $filepath);
        }

        /**
         * Find wich preference has been to set (PDF,XML o P7M)
         */

        if (!in_array(strtoupper(pathinfo($filepath, PATHINFO_EXTENSION)), array('PDF', 'XML', 'P7M'))) {
            throw new SatyException('File Format (.' . pathinfo($filepath, PATHINFO_EXTENSION) . ') not allowed, check ' . $filepath);
        }

        $signPreferences = strtoupper(pathinfo($filepath, PATHINFO_EXTENSION)) . 'setPreference';

        try {

            /**  Create Objet */
            $obj = new SatyParams;
            $obj->credentials = $this->credentials;
            $obj->buffer = file_get_contents($filepath);
            $obj->AdESPreferences = self::$signPreferences();

            /**
             * Send Object to Namirial WS
             */
            $response = $this->client->signWithCredentials($obj);

            $this->response = $response;
            return $this;

        } catch (\SoapFault $e) {

            /**
             * File not is signed, exclude default Soap Fault
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
            throw new SatyException('File not found at ' . $filepath);
        }

        if (!in_array(strtoupper(pathinfo($filepath, PATHINFO_EXTENSION)), array('PDF', 'XML', 'P7M'))) {
            throw new SatyException('File Format (.' . pathinfo($filepath, PATHINFO_EXTENSION) . ') not allowed');
        }

        try {
            /**  Create Objet */
            $obj = new SatyParams;
            $obj->signedContent = file_get_contents($filepath);

            /**
             * Send Object to Namirial WS
             */
            $response = $this->client->verify($obj);
            $this->response = $response->return;
            return $this;

        } catch (\SoapFault $e) {

            /**
             * File not is signed, exclude default Soap Fault
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
        if (isset($this->response->overallVerified)) {
            if ($filepath) {
                file_put_contents($filepath, $this->overallVerified->document);
            } else {
                die('-_- devo salvare il file...');
            }
        }
    }

    /**
     * @return array
     */
    public function dump()
    {
        return dump($this);
    }

}
