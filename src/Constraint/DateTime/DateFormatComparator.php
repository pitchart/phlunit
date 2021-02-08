<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\DateTime;

use PHPUnit\Framework\Constraint\Constraint;

abstract class DateFormatComparator extends Constraint
{
    /**
     * @var \DateTimeInterface
     */
    protected $date;

    /**
     * @var string
     */
    protected $format;

    /**
     * IsSameUsingFormat constructor.
     *
     * @param \DateTimeInterface $date
     * @param $format
     */
    protected function __construct(\DateTimeInterface $date, string $format)
    {
        $this->date = $date;
        $this->format = $format;
    }

    protected function matches($other): bool
    {
        return $this->date->format($this->format)
            === $other->format($this->format);
    }
}
