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

use Throwable;

final class SatyException extends \Exception
{
    /**
     * SatyException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
