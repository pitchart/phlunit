<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Converter;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\DateTimeCheck;

trait ToDateTime
{
    public function asDateTime(string $format): DateTimeCheck
    {
        $date = \DateTimeImmutable::createFromFormat($format, $this->value);
        Assert::assertInstanceOf(\DateTimeInterface::class, $date);
        return new DateTimeCheck($date);
    }
}
