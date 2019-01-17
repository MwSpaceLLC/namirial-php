<?php
/**
 * Created by PhpStorm.
 * User: MwSpace LLC
 * Date: 17/01/2019
 * Time: 10:25
 */

namespace Xela\Namirial;


class SatyTimeStampPreferences extends SatySignPreferences {
    public $filenameInTSD; // string
    public $outputAsTSD; // boolean
    public $outputBase64Encoded; // boolean
    public $timestampHashAlgo; // string
    public $timestampPassword; // string
    public $timestampUrl; // string
    public $timestampUsername; // string
}