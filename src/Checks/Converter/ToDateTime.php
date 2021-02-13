<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Converter;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\DateTimeCheck;

/**
 * Class ToDateTime
 *
 * @package Pitchart\Phlunit\Checks\Converter
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 */
trait ToDateTime
{
    public function asDateTime(string $format = 'Y-m-d H:i:s'): DateTimeCheck
    {
        $date = \DateTimeImmutable::createFromFormat($format, $this->value);
        Assert::assertInstanceOf(\DateTimeInterface::class, $date);
        return new DateTimeCheck($date);
    }
}
