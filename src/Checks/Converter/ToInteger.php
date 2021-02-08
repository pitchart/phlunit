<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Converter;

use Pitchart\Phlunit\Checks\GenericCheck;

trait ToInteger
{
    public function asInteger(): GenericCheck
    {
        return new GenericCheck((int) $this->value);
    }
}
