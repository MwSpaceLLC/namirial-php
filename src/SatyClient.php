<?php

/**
 * Copyright (C) 2019 MwSpace s.r.l <https://mwspace.com>
 *
 * This file is part of namirial-php.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-e-invoice-it.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Xela\Namirial;

final class SatyClient extends \SoapClient
{
    /**
     * SatyClient constructor.
     * @param $wsdl
     * @param array|null $options
     */
    public function __construct($wsdl, array $options = null)
    {
        parent::__construct($wsdl, $options);
    }
}