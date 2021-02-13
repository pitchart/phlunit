<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Converter;

use Pitchart\Phlunit\Checks\IntegerCheck;

trait ToInteger
{
    public function asInteger(): IntegerCheck
    {
        return new IntegerCheck((int) $this->value);
    }
}
