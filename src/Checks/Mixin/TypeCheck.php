<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Mixin;

use PHPUnit\Framework\Assert;

trait TypeCheck
{
    public function isString(): self
    {
        Assert::assertIsString($this->value, $this->message);
        return $this;
    }

    public function isArray(): self
    {
        Assert::assertIsArray($this->value, $this->message);
        return $this;
    }

    public function isBool(): self
    {
        Assert::assertIsBool($this->value, $this->message);
        return $this;
    }

    public function isFloat(): self
    {
        Assert::assertIsFloat($this->value, $this->message);
        return $this;
    }

    public function isInt(): self
    {
        Assert::assertIsInt($this->value, $this->message);
        return $this;
    }

    public function isNumeric(): self
    {
        Assert::assertIsNumeric($this->value, $this->message);
        return $this;
    }

    public function isObject(): self
    {
        Assert::assertIsObject($this->value, $this->message);
        return $this;
    }

    public function isResource(): self
    {
        Assert::assertIsResource($this->value, $this->message);
        return $this;
    }

    public function isScalar(): self
    {
        Assert::assertIsScalar($this->value, $this->message);
        return $this;
    }

    public function isCallable(): self
    {
        Assert::assertIsCallable($this->value, $this->message);
        return $this;
    }

    public function isIterable(): self
    {
        Assert::assertIsIterable($this->value, $this->message);
        return $this;
    }

    /**
     * @param string $expected
     * @psalm-param class-string $expected
     *
     * @return self
     */
    public function isAnInstanceOf(string $expected): self
    {
        Assert::assertInstanceOf($expected, $this->value, $this->message);
        return $this;
    }
}
