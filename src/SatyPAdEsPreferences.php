<?php
/**
 * Created by PhpStorm.
 * User: MwSpace LLC
 * Date: 17/01/2019
 * Time: 10:18
 */

namespace Xela\Namirial;

final class SatyPAdEsPreferences extends SatyTimeStampPreferences
{
    public $encryptInAnyCase; // boolean
    public $encryptionPassword; // string
    public $page; // int
    public $signerImage; // signerImage
    public $signerImageReference; // string
}