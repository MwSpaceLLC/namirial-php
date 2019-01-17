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

final class SatyCredential
{
    public $idOtp; // int
    public $otp; // string
    public $password; // string
    public $securityCode; // string
    public $sessionKey; // string
    public $username; // string
}
