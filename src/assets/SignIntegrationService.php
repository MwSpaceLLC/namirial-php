<?php

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

class signCAdESRemote {
    public $credentials; // credentials
    public $buffer; // base64Binary
    public $CAdESPreferences; // cAdESPreferences
}

class credentials {
    public $idOtp; // int
    public $otp; // string
    public $password; // string
    public $securityCode; // string
    public $sessionKey; // string
    public $username; // string
}

class cAdESPreferences extends timeStampPreferences {
    public $counterSignature;
    public $counterSignatureIndex;
    public $detached;
}

class signPreferences {
    public $hashAlgorithm; // string
    public $signEngineImpl; // signEngineImpl
    public $signType; // int
    public $withTimestamp; // boolean
}

class timeStampPreferences extends signPreferences {
    public $filenameInTSD; // string
    public $outputAsTSD; // boolean
    public $outputBase64Encoded; // boolean
    public $timestampHashAlgo; // string
    public $timestampPassword; // string
    public $timestampUrl; // string
    public $timestampUsername; // string
}

class signCAdESRemoteResponse {
    public $return; // base64Binary
}

class wsFaultBean {
    public $error; // int
    public $message; // string
}

class timestampTSRVerify {
    public $tsr; // base64Binary
    public $content; // base64Binary
}

class timestampTSRVerifyResponse {
    public $return; // timestampReportBean
}

class timestampReportBean {
    public $comment; // string
    public $content; // base64Binary
    public $contentFilename; // string
    public $contentMimeType; // string
    public $date; // dateTime
    public $hashAlgorithm; // string
    public $index; // int
    public $issuer; // string
    public $serialNumber; // integer
    public $signatureAlgorithm; // string
    public $signatureVerificationStatus; // result
    public $timestampCertData; // base64Binary
    public $timestampCertificateStatus; // certificateStatus
    public $trustedListVerificationStatus; // result
}

class sign {
    public $username; // string
    public $password; // string
    public $buffer; // base64Binary
    public $AdESPreferences; // signPreferences
}

class signResponse {
    public $return; // base64Binary
}

class signXAdES {
    public $username; // string
    public $password; // string
    public $buffer; // base64Binary
    public $XAdESPreferences; // xAdESPreferences
}

class xAdESPreferences extends timeStampPreferences {
    public $signElement; // string
}

class signXAdESResponse {
    public $return; // base64Binary
}

class signXAdESRemote {
    public $credentials; // credentials
    public $buffer; // base64Binary
    public $XAdESPreferences; // xAdESPreferences
}

class signXAdESRemoteResponse {
    public $return; // base64Binary
}

class getCertificate {
    public $username; // string
    public $password; // string
}

class getCertificateResponse {
    public $return; // base64Binary
}

class checkOTP {
    public $credentials; // credentials
}

class checkOTPResponse {
}

class disableRemote {
    public $credentials; // credentials
}

class disableRemoteResponse {
}

class getAvailableSignatures {
    public $credentials; // credentials
}

class getAvailableSignaturesResponse {
    public $return; // long
}

class signPAdESRemote {
    public $credentials; // credentials
    public $buffer; // base64Binary
    public $PAdESPreferences; // pAdESPreferences
}

class pAdESPreferences extends timeStampPreferences {
    public $encryptInAnyCase; // boolean
    public $encryptionPassword; // string
    public $page; // int
    public $signerImage; // signerImage
    public $signerImageReference; // string
    public $needAppearanceDisabled;
    public $withSignatureField;

}

class signerImage {
    public $fieldName; // string
    public $fontName; // string
    public $fontSize; // int
    public $height; // int
    public $image; // base64Binary
    public $imageFilename; // string
    public $imageURL; // string
    public $location; // string
    public $reason; // string
    public $signerName; // string
    public $textVisible; // boolean
    public $imageVisible;
    public $width; // int
    public $x; // int
    public $y; // int
}

class signPAdESRemoteResponse {
    public $return; // base64Binary
}

class signPkcs1 {
    public $credentials; // credentials
    public $hash; // base64Binary
    public $preferences; // signPreferences
}

class signPkcs1Response {
    public $return; // base64Binary
}

class verifyWithPreferences {
    public $signedContent; // base64Binary
    public $preferences; // verifyPreferences
}

class verifyPreferences {
    public $namirial; // boolean
    public $pdfEncryptionPassword; // string
    public $verifyOnDate; // dateTime
}

class verifyWithPreferencesResponse {
    public $return; // signedDocumentReportBean
}

class signedDocumentReportBean {
    public $checkDate; // dateTime
    public $noteReportList; // noteReportBean
    public $nrOfSignatures; // int
    public $overallVerified; // boolean
    public $plainDocument; // base64Binary
    public $signatureFormat; // string
    public $signatureReportList; // signatureReportBean
    public $verificationDate; // dateTime
}

class noteReportBean {
    public $about; // int
    public $description; // string
    public $policy; // int
    public $synopsis; // string
    public $type; // int
}

class signatureReportBean {
    public $derEncodedSignerCert; // base64Binary
    public $id; // string
    public $integrity; // boolean
    public $issuerCertificateRevocationDate; // dateTime
    public $issuerCertificateStatus; // certificateStatus
    public $issuerDN; // string
    public $issuerInTrustedList; // boolean
    public $keySize; // int
    public $qcComplianceStatus; // result
    public $serialNumber; // integer
    public $signatureAlgorithmName; // string
    public $signatureDate; // dateTime
    public $signerCertificateNotAfter; // dateTime
    public $signerCertificateNotBefore; // dateTime
    public $signerCertificateRevocationDate; // dateTime
    public $signerCertificateStatus; // certificateStatus
    public $subjectDN; // string
    public $timestampReportBeanList; // timestampReportBean
    public $trustedSignatureDate; // boolean
}

class signCAdESArrayListWithCredentials {
    public $credentials; // credentials
    public $bufferList; // base64Binary
    public $CAdESPreferences; // cAdESPreferences
}

class signCAdESArrayListWithCredentialsResponse {
    public $return; // base64Binary
}

class signPkcs1ArrayList {
    public $credentials; // credentials
    public $hashList; // base64Binary
    public $preferences; // signPreferences
}

class signPkcs1ArrayListResponse {
    public $return; // base64Binary
}

class verify {
    public $signedContent; // base64Binary
}

class verifyResponse {
    public $return; // signedDocumentReportBean
}

class sendOtpBySMS {
    public $credentials; // credentials
}

class sendOtpBySMSResponse {
}

class signPAdESArrayList {
    public $username; // string
    public $password; // string
    public $bufferList; // base64Binary
    public $PAdESPreferences; // pAdESPreferences
}

class signPAdESArrayListResponse {
    public $return; // base64Binary
}

class signArrayListWithCredentials {
    public $credentials; // credentials
    public $bufferList; // base64Binary
    public $AdESPreferences; // signPreferences
}

class signArrayListWithCredentialsResponse {
    public $return; // base64Binary
}

class timestampTSDVerify {
    public $tsd; // base64Binary
}

class timestampTSDVerifyResponse {
    public $return; // timestampReportBean
}

class changePassword {
    public $securityCode; // string
    public $username; // string
    public $password; // string
    public $newPassword; // string
}

class changePasswordResponse {
}

class enableRemote {
    public $credentials; // credentials
}

class enableRemoteResponse {
}

class signPAdESArrayListWithCredentials {
    public $credentials; // credentials
    public $bufferList; // base64Binary
    public $PAdESPreferences; // pAdESPreferences
}

class signPAdESArrayListWithCredentialsResponse {
    public $return; // base64Binary
}

class signCAdESArrayListWithMultiPreferences {
    public $credentials; // credentials
    public $bufferList; // base64Binary
    public $CAdESPreferences; // cAdESPreferences
}

class signCAdESArrayListWithMultiPreferencesResponse {
    public $return; // base64Binary
}

class signXAdESArrayListWithCredentials {
    public $credentials; // credentials
    public $bufferList; // base64Binary
    public $XAdESPreferences; // xAdESPreferences
}

class signXAdESArrayListWithCredentialsResponse {
    public $return; // base64Binary
}

class closeSession {
    public $credentials; // credentials
}

class closeSessionResponse {
}

class signCAdESArrayList {
    public $username; // string
    public $password; // string
    public $bufferList; // base64Binary
    public $CAdESPreferences; // cAdESPreferences
}

class signCAdESArrayListResponse {
    public $return; // base64Binary
}

class changePasswordRemote {
    public $credentials; // credentials
    public $newPassword; // string
}

class changePasswordRemoteResponse {
}

class signXAdESArrayList {
    public $username; // string
    public $password; // string
    public $bufferList; // base64Binary
    public $XAdESPreferences; // xAdESPreferences
}

class signXAdESArrayListResponse {
    public $return; // base64Binary
}

class signWithCredentials {
    public $credentials; // credentials
    public $buffer; // base64Binary
    public $AdESPreferences; // signPreferences
}

class signWithCredentialsResponse {
    public $return; // base64Binary
}

class signXAdESArrayListWithMultiPreferences {
    public $credentials; // credentials
    public $bufferList; // base64Binary
    public $XAdESPreferences; // xAdESPreferences
}

class signXAdESArrayListWithMultiPreferencesResponse {
    public $return; // base64Binary
}

class signPAdESArrayListWithMultiPreferences {
    public $credentials; // credentials
    public $bufferList; // base64Binary
    public $PAdESPreferences; // pAdESPreferences
}

class signPAdESArrayListWithMultiPreferencesResponse {
    public $return; // base64Binary
}

class disable {
    public $securityCode; // string
    public $username; // string
    public $password; // string
}

class disableResponse {
}

class signArrayList {
    public $username; // string
    public $password; // string
    public $bufferList; // base64Binary
    public $AdESPreferences; // signPreferences
}

class signArrayListResponse {
    public $return; // base64Binary
}

class signPAdES {
    public $username; // string
    public $password; // string
    public $buffer; // base64Binary
    public $PAdESPreferences; // pAdESPreferences
}

class signPAdESResponse {
    public $return; // base64Binary
}

class enable {
    public $securityCode; // string
    public $username; // string
    public $password; // string
}

class enableResponse {
}

class signCAdES {
    public $username; // string
    public $password; // string
    public $buffer; // base64Binary
    public $CAdESPreferences; // cAdESPreferences
}

class signCAdESResponse {
    public $return; // base64Binary
}

class openSession {
    public $credentials; // credentials
}

class openSessionResponse {
    public $return; // string
}

class checkFirstFactor {
    public $credentials; // credentials
}

class checkFirstFactorResponse {
}

class getSignatures {
    public $credentials; // credentials
}

class getSignaturesResponse {
    public $return; // long
}

class verifyOnDate {
    public $signedContent; // base64Binary
    public $verifyDate; // dateTime
}

class verifyOnDateResponse {
    public $return; // signedDocumentReportBean
}

class timestamp {
    public $content; // base64Binary
    public $preferences; // timeStampPreferences
}

class timestampResponse {
    public $return; // base64Binary
}

class signEngineImpl {
    const LOCAL = 'LOCAL';
    const _STATIC = 'STATIC';
    const DYNAMIC = 'DYNAMIC';
}

class result {
    const VALID = 'VALID';
    const INVALID = 'INVALID';
    const UNDETERMINED = 'UNDETERMINED';
    const VALID_WITH_WARNINGS = 'VALID_WITH_WARNINGS';
    const INFORMATION = 'INFORMATION';
}

class certificateStatus {
    const VALID = 'VALID';
    const REVOKED = 'REVOKED';
    const UNKNOWN = 'UNKNOWN';
}


/**
 * SignIntegrationService class
 *
 *
 *
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class SignIntegrationService extends SoapClient {

    /**
     * @var array
     */
    private static $classmap = array(
        'signCAdESRemote' => 'signCAdESRemote',
        'credentials' => 'credentials',
        'cAdESPreferences' => 'cAdESPreferences',
        'signPreferences' => 'signPreferences',
        'timeStampPreferences' => 'timeStampPreferences',
        'signCAdESRemoteResponse' => 'signCAdESRemoteResponse',
        'wsFaultBean' => 'wsFaultBean',
        'timestampTSRVerify' => 'timestampTSRVerify',
        'timestampTSRVerifyResponse' => 'timestampTSRVerifyResponse',
        'timestampReportBean' => 'timestampReportBean',
        'sign' => 'sign',
        'signResponse' => 'signResponse',
        'signXAdES' => 'signXAdES',
        'xAdESPreferences' => 'xAdESPreferences',
        'signXAdESResponse' => 'signXAdESResponse',
        'signXAdESRemote' => 'signXAdESRemote',
        'signXAdESRemoteResponse' => 'signXAdESRemoteResponse',
        'getCertificate' => 'getCertificate',
        'getCertificateResponse' => 'getCertificateResponse',
        'checkOTP' => 'checkOTP',
        'checkOTPResponse' => 'checkOTPResponse',
        'disableRemote' => 'disableRemote',
        'disableRemoteResponse' => 'disableRemoteResponse',
        'getAvailableSignatures' => 'getAvailableSignatures',
        'getAvailableSignaturesResponse' => 'getAvailableSignaturesResponse',
        'signPAdESRemote' => 'signPAdESRemote',
        'pAdESPreferences' => 'pAdESPreferences',
        'signerImage' => 'signerImage',
        'signPAdESRemoteResponse' => 'signPAdESRemoteResponse',
        'signPkcs1' => 'signPkcs1',
        'signPkcs1Response' => 'signPkcs1Response',
        'verifyWithPreferences' => 'verifyWithPreferences',
        'verifyPreferences' => 'verifyPreferences',
        'verifyWithPreferencesResponse' => 'verifyWithPreferencesResponse',
        'signedDocumentReportBean' => 'signedDocumentReportBean',
        'noteReportBean' => 'noteReportBean',
        'signatureReportBean' => 'signatureReportBean',
        'signCAdESArrayListWithCredentials' => 'signCAdESArrayListWithCredentials',
        'signCAdESArrayListWithCredentialsResponse' => 'signCAdESArrayListWithCredentialsResponse',
        'signPkcs1ArrayList' => 'signPkcs1ArrayList',
        'signPkcs1ArrayListResponse' => 'signPkcs1ArrayListResponse',
        'verify' => 'verify',
        'verifyResponse' => 'verifyResponse',
        'sendOtpBySMS' => 'sendOtpBySMS',
        'sendOtpBySMSResponse' => 'sendOtpBySMSResponse',
        'signPAdESArrayList' => 'signPAdESArrayList',
        'signPAdESArrayListResponse' => 'signPAdESArrayListResponse',
        'signArrayListWithCredentials' => 'signArrayListWithCredentials',
        'signArrayListWithCredentialsResponse' => 'signArrayListWithCredentialsResponse',
        'timestampTSDVerify' => 'timestampTSDVerify',
        'timestampTSDVerifyResponse' => 'timestampTSDVerifyResponse',
        'changePassword' => 'changePassword',
        'changePasswordResponse' => 'changePasswordResponse',
        'enableRemote' => 'enableRemote',
        'enableRemoteResponse' => 'enableRemoteResponse',
        'signPAdESArrayListWithCredentials' => 'signPAdESArrayListWithCredentials',
        'signPAdESArrayListWithCredentialsResponse' => 'signPAdESArrayListWithCredentialsResponse',
        'signCAdESArrayListWithMultiPreferences' => 'signCAdESArrayListWithMultiPreferences',
        'signCAdESArrayListWithMultiPreferencesResponse' => 'signCAdESArrayListWithMultiPreferencesResponse',
        'signXAdESArrayListWithCredentials' => 'signXAdESArrayListWithCredentials',
        'signXAdESArrayListWithCredentialsResponse' => 'signXAdESArrayListWithCredentialsResponse',
        'closeSession' => 'closeSession',
        'closeSessionResponse' => 'closeSessionResponse',
        'signCAdESArrayList' => 'signCAdESArrayList',
        'signCAdESArrayListResponse' => 'signCAdESArrayListResponse',
        'changePasswordRemote' => 'changePasswordRemote',
        'changePasswordRemoteResponse' => 'changePasswordRemoteResponse',
        'signXAdESArrayList' => 'signXAdESArrayList',
        'signXAdESArrayListResponse' => 'signXAdESArrayListResponse',
        'signWithCredentials' => 'signWithCredentials',
        'signWithCredentialsResponse' => 'signWithCredentialsResponse',
        'signXAdESArrayListWithMultiPreferences' => 'signXAdESArrayListWithMultiPreferences',
        'signXAdESArrayListWithMultiPreferencesResponse' => 'signXAdESArrayListWithMultiPreferencesResponse',
        'signPAdESArrayListWithMultiPreferences' => 'signPAdESArrayListWithMultiPreferences',
        'signPAdESArrayListWithMultiPreferencesResponse' => 'signPAdESArrayListWithMultiPreferencesResponse',
        'disable' => 'disable',
        'disableResponse' => 'disableResponse',
        'signArrayList' => 'signArrayList',
        'signArrayListResponse' => 'signArrayListResponse',
        'signPAdES' => 'signPAdES',
        'signPAdESResponse' => 'signPAdESResponse',
        'enable' => 'enable',
        'enableResponse' => 'enableResponse',
        'signCAdES' => 'signCAdES',
        'signCAdESResponse' => 'signCAdESResponse',
        'openSession' => 'openSession',
        'openSessionResponse' => 'openSessionResponse',
        'checkFirstFactor' => 'checkFirstFactor',
        'checkFirstFactorResponse' => 'checkFirstFactorResponse',
        'getSignatures' => 'getSignatures',
        'getSignaturesResponse' => 'getSignaturesResponse',
        'verifyOnDate' => 'verifyOnDate',
        'verifyOnDateResponse' => 'verifyOnDateResponse',
        'timestamp' => 'timestamp',
        'timestampResponse' => 'timestampResponse',
        'signEngineImpl' => 'signEngineImpl',
        'result' => 'result',
        'certificateStatus' => 'certificateStatus',
    );

    /**
     * SignIntegrationService constructor.
     * @param $wsdl
     * @param array $options
     */
    public function __construct($wsdl, $options = array()) {
        foreach(self::$classmap as $key => $value) {
            if(!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }
        parent::__construct($wsdl, $options);
    }

    /**
     *
     *
     * @param signCAdESRemote $parameters
     * @return signCAdESRemoteResponse
     */
    public function signCAdESRemote(signCAdESRemote $parameters) {
        return $this->__soapCall('signCAdESRemote', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param timestampTSRVerify $parameters
     * @return timestampTSRVerifyResponse
     */
    public function timestampTSRVerify(timestampTSRVerify $parameters) {
        return $this->__soapCall('timestampTSRVerify', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param sign $parameters
     * @return signResponse
     */
    public function sign(sign $parameters) {
        return $this->__soapCall('sign', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signXAdES $parameters
     * @return signXAdESResponse
     */
    public function signXAdES(signXAdES $parameters) {
        return $this->__soapCall('signXAdES', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param checkOTP $parameters
     * @return checkOTPResponse
     */
    public function checkOTP(checkOTP $parameters) {
        return $this->__soapCall('checkOTP', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param getCertificate $parameters
     * @return getCertificateResponse
     */
    public function getCertificate(getCertificate $parameters) {
        return $this->__soapCall('getCertificate', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signXAdESRemote $parameters
     * @return signXAdESRemoteResponse
     */
    public function signXAdESRemote(signXAdESRemote $parameters) {
        return $this->__soapCall('signXAdESRemote', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param disableRemote $parameters
     * @return disableRemoteResponse
     */
    public function disableRemote(disableRemote $parameters) {
        return $this->__soapCall('disableRemote', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param getAvailableSignatures $parameters
     * @return getAvailableSignaturesResponse
     */
    public function getAvailableSignatures(getAvailableSignatures $parameters) {
        return $this->__soapCall('getAvailableSignatures', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signPAdESRemote $parameters
     * @return signPAdESRemoteResponse
     */
    public function signPAdESRemote(signPAdESRemote $parameters) {
        return $this->__soapCall('signPAdESRemote', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signPkcs1 $parameters
     * @return signPkcs1Response
     */
    public function signPkcs1(signPkcs1 $parameters) {
        return $this->__soapCall('signPkcs1', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signCAdESArrayListWithCredentials $parameters
     * @return signCAdESArrayListWithCredentialsResponse
     */
    public function signCAdESArrayListWithCredentials(signCAdESArrayListWithCredentials $parameters) {
        return $this->__soapCall('signCAdESArrayListWithCredentials', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param verifyWithPreferences $parameters
     * @return verifyWithPreferencesResponse
     */
    public function verifyWithPreferences(verifyWithPreferences $parameters) {
        return $this->__soapCall('verifyWithPreferences', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signPkcs1ArrayList $parameters
     * @return signPkcs1ArrayListResponse
     */
    public function signPkcs1ArrayList(signPkcs1ArrayList $parameters) {
        return $this->__soapCall('signPkcs1ArrayList', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param sendOtpBySMS $parameters
     * @return sendOtpBySMSResponse
     */
    public function sendOtpBySMS(sendOtpBySMS $parameters) {
        return $this->__soapCall('sendOtpBySMS', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param verify $parameters
     * @return verifyResponse
     */
    public function verify(verify $parameters) {
        return $this->__soapCall('verify', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signPAdESArrayList $parameters
     * @return signPAdESArrayListResponse
     */
    public function signPAdESArrayList(signPAdESArrayList $parameters) {
        return $this->__soapCall('signPAdESArrayList', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signArrayListWithCredentials $parameters
     * @return signArrayListWithCredentialsResponse
     */
    public function signArrayListWithCredentials(signArrayListWithCredentials $parameters) {
        return $this->__soapCall('signArrayListWithCredentials', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param changePassword $parameters
     * @return changePasswordResponse
     */
    public function changePassword(changePassword $parameters) {
        return $this->__soapCall('changePassword', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param timestampTSDVerify $parameters
     * @return timestampTSDVerifyResponse
     */
    public function timestampTSDVerify(timestampTSDVerify $parameters) {
        return $this->__soapCall('timestampTSDVerify', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param enableRemote $parameters
     * @return enableRemoteResponse
     */
    public function enableRemote(enableRemote $parameters) {
        return $this->__soapCall('enableRemote', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signPAdESArrayListWithCredentials $parameters
     * @return signPAdESArrayListWithCredentialsResponse
     */
    public function signPAdESArrayListWithCredentials(signPAdESArrayListWithCredentials $parameters) {
        return $this->__soapCall('signPAdESArrayListWithCredentials', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signCAdESArrayListWithMultiPreferences $parameters
     * @return signCAdESArrayListWithMultiPreferencesResponse
     */
    public function signCAdESArrayListWithMultiPreferences(signCAdESArrayListWithMultiPreferences $parameters) {
        return $this->__soapCall('signCAdESArrayListWithMultiPreferences', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signXAdESArrayListWithCredentials $parameters
     * @return signXAdESArrayListWithCredentialsResponse
     */
    public function signXAdESArrayListWithCredentials(signXAdESArrayListWithCredentials $parameters) {
        return $this->__soapCall('signXAdESArrayListWithCredentials', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param closeSession $parameters
     * @return closeSessionResponse
     */
    public function closeSession(closeSession $parameters) {
        return $this->__soapCall('closeSession', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signCAdESArrayList $parameters
     * @return signCAdESArrayListResponse
     */
    public function signCAdESArrayList(signCAdESArrayList $parameters) {
        return $this->__soapCall('signCAdESArrayList', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param changePasswordRemote $parameters
     * @return changePasswordRemoteResponse
     */
    public function changePasswordRemote(changePasswordRemote $parameters) {
        return $this->__soapCall('changePasswordRemote', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signXAdESArrayList $parameters
     * @return signXAdESArrayListResponse
     */
    public function signXAdESArrayList(signXAdESArrayList $parameters) {
        return $this->__soapCall('signXAdESArrayList', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signWithCredentials $parameters
     * @return signWithCredentialsResponse
     */
    public function signWithCredentials(signWithCredentials $parameters) {
        return $this->__soapCall('signWithCredentials', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signXAdESArrayListWithMultiPreferences $parameters
     * @return signXAdESArrayListWithMultiPreferencesResponse
     */
    public function signXAdESArrayListWithMultiPreferences(signXAdESArrayListWithMultiPreferences $parameters) {
        return $this->__soapCall('signXAdESArrayListWithMultiPreferences', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signPAdESArrayListWithMultiPreferences $parameters
     * @return signPAdESArrayListWithMultiPreferencesResponse
     */
    public function signPAdESArrayListWithMultiPreferences(signPAdESArrayListWithMultiPreferences $parameters) {
        return $this->__soapCall('signPAdESArrayListWithMultiPreferences', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param disable $parameters
     * @return disableResponse
     */
    public function disable(disable $parameters) {
        return $this->__soapCall('disable', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signArrayList $parameters
     * @return signArrayListResponse
     */
    public function signArrayList(signArrayList $parameters) {
        return $this->__soapCall('signArrayList', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param enable $parameters
     * @return enableResponse
     */
    public function enable(enable $parameters) {
        return $this->__soapCall('enable', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signPAdES $parameters
     * @return signPAdESResponse
     */
    public function signPAdES(signPAdES $parameters) {
        return $this->__soapCall('signPAdES', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param signCAdES $parameters
     * @return signCAdESResponse
     */
    public function signCAdES(signCAdES $parameters) {
        return $this->__soapCall('signCAdES', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param openSession $parameters
     * @return openSessionResponse
     */
    public function openSession(openSession $parameters) {
        return $this->__soapCall('openSession', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param checkFirstFactor $parameters
     * @return checkFirstFactorResponse
     */
    public function checkFirstFactor(checkFirstFactor $parameters) {
        return $this->__soapCall('checkFirstFactor', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param getSignatures $parameters
     * @return getSignaturesResponse
     */
    public function getSignatures(getSignatures $parameters) {
        return $this->__soapCall('getSignatures', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param verifyOnDate $parameters
     * @return verifyOnDateResponse
     */
    public function verifyOnDate(verifyOnDate $parameters) {
        return $this->__soapCall('verifyOnDate', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

    /**
     *
     *
     * @param timestamp $parameters
     * @return timestampResponse
     */
    public function timestamp(timestamp $parameters) {
        return $this->__soapCall('timestamp', array($parameters),       array(
                'uri' => 'http://service.ws.nam/',
                'soapaction' => ''
            )
        );
    }

}