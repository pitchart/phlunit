<?php declare(strict_types=1);

namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

/**
 * Class FloatCheck
 *
 * @package Pitchart\Phlunit\Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @implements FluentCheck<double>
 */
class FloatCheck implements FluentCheck
{
    use WithMessage, TypeCheck;

    /**
     * @var float
     */
    private $value;

    /**
     * @var
     */
    private $delta;

    /**
     * FloatCheck constructor.
     *
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @param float $expected
     *
     * @return GenericCheck
     */
    public function isEqualTo(float $expected): self
    {
        if ($this->delta) {
            Assert::assertEqualsWithDelta($expected, $this->value, $this->delta, $this->message);
        } else {
            Assert::assertSame($expected, $this->value, $this->message);
        }
        $this->resetMessage();
        return $this;
    }

    /**
     * @param float $expected
     *
     * @return GenericCheck
     */
    public function isNotEqualTo(float $expected): self
    {
        if ($this->delta) {
            Assert::assertNotEqualsWithDelta($expected, $this->value, $this->delta, $this->message);
        } else {
            Assert::assertNotSame($expected, $this->value, $this->message);
        }
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

    public function withDelta(float $delta)
    {
        $this->delta = $delta;
        return $this;
    }

    public function strictly()
    {
        return $this->withDelta(0.0);
    }
}
