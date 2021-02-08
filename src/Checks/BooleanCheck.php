<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

class BooleanCheck implements FluentCheck
{
    use TypeCheck, WithMessage;

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

    public function isTrue()
    {
        Assert::assertTrue($this->value);
        return $this;
    }

    public function isFalse()
    {
        Assert::assertFalse($this->value);
        return $this;
    }
}
