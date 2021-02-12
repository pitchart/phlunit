<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;
use Pitchart\Phlunit\Constraint\DateTime\IsSameDayAs;
use Pitchart\Phlunit\Constraint\DateTime\IsSameIgnoringMillis;
use Pitchart\Phlunit\Constraint\DateTime\IsSameTimeAs;

class DateTimeCheck implements FluentCheck
{
    use TypeCheck, ConstraintCheck, WithMessage;

    /**
     * @var \DateTimeInterface
     */
    private $value;

    /**
     * DateTimeCheck constructor.
     *
     * @param \DateTimeInterface $date
     */
    public function __construct(\DateTimeInterface $date)
    {
        $this->value = $date;
    }

    public function hasYear(int $year): self
    {
        Assert::assertSame($year, (int) $this->value->format('Y'), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function hasMonth(int $month): self
    {
        Assert::assertSame($month, (int) $this->value->format('m'), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function hasDay(int $day): self
    {
        Assert::assertSame($day, (int) $this->value->format('d'), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function hasHours(int $hours): self
    {
        Assert::assertSame($hours, (int) $this->value->format('H'), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function hasMinutes(int $minutes): self
    {
        Assert::assertSame($minutes, (int) $this->value->format('i'), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function hasSeconds(int $seconds): self
    {
        Assert::assertSame($seconds, (int) $this->value->format('s'), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isSameDayAs(\DateTimeInterface $expected): self
    {
        Assert::assertThat($this->value, new IsSameDayAs($expected), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isSameTimeAs(\DateTimeInterface $expected): self
    {
        Assert::assertThat($this->value, new IsSameTimeAs($expected), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isSameIgnoringMillis(\DateTimeInterface $expected): self
    {
        Assert::assertThat($this->value, new IsSameIgnoringMillis($expected), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isAfter(\DateTimeInterface $date)
    {
        Assert::assertGreaterThan($date, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isBefore(\DateTimeInterface $date)
    {
        Assert::assertLessThan($date, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isBetween(\DateTimeInterface $from, \DateTimeInterface $to)
    {
        Assert::assertGreaterThanOrEqual($from, $this->value, $this->message);
        Assert::assertLessThanOrEqual($to, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }
}
