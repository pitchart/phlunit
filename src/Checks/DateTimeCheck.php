<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;
use Pitchart\Phlunit\Constraint\DateTime\IsSameDayAs;
use Pitchart\Phlunit\Constraint\DateTime\IsSameIgnoringMillis;

class DateTimeCheck implements FluentCheck
{
    use TypeCheck, WithMessage;

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

    public function isSameDayAs(\DateTimeInterface $expected): self
    {
        Assert::assertThat($this->value, new IsSameDayAs($expected));
        $this->resetMessage();
        return $this;
    }

    public function isSameIgnoringMillis(\DateTimeInterface $expected): self
    {
        Assert::assertThat($this->value, new IsSameIgnoringMillis($expected));
        $this->resetMessage();
        return $this;
    }
}
