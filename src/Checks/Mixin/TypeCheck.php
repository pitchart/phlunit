<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Mixin;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\ArrayCheck;
use Pitchart\Phlunit\Checks\BooleanCheck;
use Pitchart\Phlunit\Checks\CallableCheck;
use Pitchart\Phlunit\Checks\CollectionCheck;
use Pitchart\Phlunit\Checks\DateTimeCheck;
use Pitchart\Phlunit\Checks\ExceptionCheck;
use Pitchart\Phlunit\Checks\FloatCheck;
use Pitchart\Phlunit\Checks\FluentCheck;
use Pitchart\Phlunit\Checks\GenericCheck;
use Pitchart\Phlunit\Checks\IntegerCheck;
use Pitchart\Phlunit\Checks\ResponseCheck;
use Pitchart\Phlunit\Checks\StringCheck;

trait TypeCheck
{

    /**
     * @template T
     * @param mixed $sut
     * @psalm-param T of mixed
     * @psalm-return FluentCheck<T>
     * @return BooleanCheck|GenericCheck|CallableCheck|CollectionCheck|ResponseCheck|ArrayCheck|DateTimeCheck|StringCheck|ExceptionCheck|FloatCheck|IntegerCheck
     */
    public function that(): self
    {
        return $this;
    }

    /**
     * @template T
     * @param mixed $sut
     * @psalm-param T of mixed
     * @psalm-return FluentCheck<T>
     * @return BooleanCheck|GenericCheck|CallableCheck|CollectionCheck|ResponseCheck|ArrayCheck|DateTimeCheck|StringCheck|ExceptionCheck|FloatCheck|IntegerCheck
     */
    public function andThat($sut): FluentCheck
    {
        return Check::that($sut);
    }


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
