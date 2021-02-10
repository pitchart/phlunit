<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\DateTime;

class IsSameTimeAs extends DateFormatComparator
{
    public function __construct(\DateTimeInterface $date)
    {
        parent::__construct($date, 'H:i:s');
    }

    public function toString(): string
    {
        return \sprintf(
            'is the same time as expected %s',
            $this->date->format($this->format)
        );
    }

    protected function failureDescription($other): string
    {
        return $other->format($this->format) . ' ' . $this->toString();
    }
}
