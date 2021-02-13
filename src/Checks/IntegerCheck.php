<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Converter\ToDateTime;
use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

/**
 * Class IntegerCheck
 *
 * @package Pitchart\Phlunit\Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @implements FluentCheck<int>
 */
class IntegerCheck implements FluentCheck
{
    use TypeCheck, ConstraintCheck, WithMessage;
    use ToDateTime { asDateTime as asDateTimeWithFormat; }

    /**
     * @var int
     */
    private $value;

    /**
     * GenericCheck constructor.
     *
     * @param $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function isEqualTo(int $expected): self
    {
        Assert::assertSame($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isNotEqualTo(int $expected): self
    {
        Assert::assertNotSame($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isEmpty(): self
    {
        Assert::assertEmpty($this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isNotEmpty(): self
    {
        Assert::assertNotEmpty($this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isGreaterThan(float $expected): self
    {
        Assert::assertGreaterThan($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isGreaterThanOrEqualTo(float $expected): self
    {
        Assert::assertGreaterThanOrEqual($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isLessThan(float $expected): self
    {
        Assert::assertLessThan($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isLessThanOrEqualTo(float $expected): self
    {
        Assert::assertLessThanOrEqual($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function asDateTime(): DateTimeCheck
    {
        return $this->asDateTimeWithFormat('U');
    }
}
