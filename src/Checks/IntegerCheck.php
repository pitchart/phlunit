<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;

class IntegerCheck implements FluentCheck
{
    use TypeCheck;

    /**
     * @var mixed
     */
    private $value;

    /**
     * GenericCheck constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isEqualTo($expected, string $message = ''): self
    {
        Assert::assertSame($expected, $this->value, $message);
        return $this;
    }

    public function isNotEqualTo($expected, string $message = ''): self
    {
        Assert::assertNotSame($expected, $this->value, $message);
        return $this;
    }

    public function isEmpty($message = ''): self
    {
        Assert::assertEmpty($this->value, $message);
        return $this;
    }

    public function isNotEmpty($message = ''): self
    {
        Assert::assertNotEmpty($this->value, $message);
        return $this;
    }

    public function isGreaterThan($expected, string $message = ''): self
    {
        Assert::assertGreaterThan($expected, $this->value, $message);
        return $this;
    }

    public function isGreaterThanOrEqualTo($expected, string $message = ''): self
    {
        Assert::assertGreaterThanOrEqual($expected, $this->value, $message);
        return $this;
    }

    public function isLessThan($expected, string $message = ''): self
    {
        Assert::assertLessThan($expected, $this->value, $message);
        return $this;
    }

    public function isLessThanOrEqualTo($expected, string $message = ''): self
    {
        Assert::assertLessThanOrEqual($expected, $this->value, $message);
        return $this;
    }
}
