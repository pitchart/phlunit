<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\DateTime;

class IsSameDayAs extends DateFormatComparator
{
    public function __construct(\DateTimeInterface $date)
    {
        parent::__construct($date, 'Y-m-d');
    }

    public function toString(): string
    {
        return \sprintf(
            'is the same day as %s',
            $this->date->format($this->format)
        );
    }

    protected function failureDescription($other): string
    {
        return $other->format($this->format) . ' ' . $this->toString();
    }
}
