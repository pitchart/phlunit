<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Converter;

use Pitchart\Phlunit\Checks\JsonCheck;

trait ToJson
{
    public function asJson(): JsonCheck
    {
        return new JsonCheck($this->value);
    }
}
