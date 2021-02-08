<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\DateTime;

class IsSameIgnoringMillis extends DateFormatComparator
{
    public function __construct(\DateTimeInterface $date)
    {
        parent::__construct($date, 'Y-m-d H:i:s');
    }

    public function toString(): string
    {
        return \sprintf(
            'is the same date and time than %s',
            $this->date->format($this->format)
        );
    }

    protected function failureDescription($other): string
    {
        return $other->format($this->format) . ' ' . $this->toString();
    }
}
