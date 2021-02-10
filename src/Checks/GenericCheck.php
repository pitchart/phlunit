<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

class GenericCheck implements FluentCheck
{
    use TypeCheck, ConstraintCheck, WithMessage;

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
        $this->resetMessage();
        return $this;
    }

    public function isNotEqualTo($expected, string $message = ''): self
    {
        Assert::assertNotEquals($expected, $this->value, $message);
        $this->resetMessage();
        return $this;
    }

    public function isEmpty($message = ''): self
    {
        Assert::assertEmpty($this->value, $message);
        $this->resetMessage();
        return $this;
    }

    public function isNotEmpty($message = ''): self
    {
        Assert::assertNotEmpty($this->value, $message);
        $this->resetMessage();
        return $this;
    }
}
