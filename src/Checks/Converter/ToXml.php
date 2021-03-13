<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Converter;

use Pitchart\Phlunit\Checks\XmlCheck;

trait ToXml
{
    public function asXml(): XmlCheck
    {
        return new XmlCheck($this->value);
    }
}
