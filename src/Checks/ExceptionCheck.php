<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Exception as ExceptionConstraint;
use PHPUnit\Framework\Constraint\ExceptionCode;
use PHPUnit\Framework\Constraint\ExceptionMessage;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

/**
 * Class ExceptionCheck
 *
 * @package Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 *
 * @implements FluentCheck<\Throwable>
 */
class ExceptionCheck implements FluentCheck
{
    use TypeCheck, WithMessage;

    /**
     * @var \Throwable
     */
    private $value;

    /**
     * ExceptionCheck constructor.
     *
     * @param \Throwable $value
     */
    public function __construct(\Throwable $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $className
     *
     * @return ExceptionCheck
     */
    public function isAnInstanceOf(string $className): self
    {
        Assert::assertThat($this->value, new ExceptionConstraint($className), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isDescribedBy(string $message): self
    {
        Assert::assertThat($this->value, new ExceptionMessage($message), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function hasCode(int $code): self
    {
        Assert::assertThat($this->value, new ExceptionCode($code), $this->message);
        $this->resetMessage();
        return $this;
    }
}
