<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Mixin;

use PHPUnit\Framework\Assert;

trait TypeCheck
{
    public function isString($message = ''): self
    {
        Assert::assertIsString($this->value, $message);
        return $this;
    }

    public function isArray($message = ''): self
    {
        Assert::assertIsArray($this->value, $message);
        return $this;
    }

    public function isBool($message = ''): self
    {
        Assert::assertIsBool($this->value, $message);
        return $this;
    }

    public function isFloat($message = ''): self
    {
        Assert::assertIsFloat($this->value, $message);
        return $this;
    }

    public function isInt($message = ''): self
    {
        Assert::assertIsInt($this->value, $message);
        return $this;
    }

    public function isNumeric($message = ''): self
    {
        Assert::assertIsNumeric($this->value, $message);
        return $this;
    }

    public function isObject($message = ''): self
    {
        Assert::assertIsObject($this->value, $message);
        return $this;
    }

    public function isResource($message = ''): self
    {
        Assert::assertIsResource($this->value, $message);
        return $this;
    }

    public function isScalar($message = ''): self
    {
        Assert::assertIsScalar($this->value, $message);
        return $this;
    }

    public function isCallable($message = ''): self
    {
        Assert::assertIsCallable($this->value, $message);
        return $this;
    }

    public function isIterable($message = ''): self
    {
        Assert::assertIsIterable($this->value, $message);
        return $this;
    }

    public function isAnInstanceOf(string $expected, $message = ''): self
    {
        Assert::assertInstanceOf($expected, $this->value, $message);
        return $this;
    }
}
