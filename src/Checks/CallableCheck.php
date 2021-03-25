<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use Pitchart\Phlunit\Checks\Mixin\FluentChecks;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

/**
 * Class CallableCheck
 *
 * @package Pitchart\Phlunit\Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @implements FluentCheck<callable>
 */
class CallableCheck implements FluentCheck
{
    use TypeCheck, FluentChecks, ConstraintCheck, WithMessage;

    /**
     * @var callable
     */
    private $value;

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @var mixed
     */
    private $result;

    public function __construct(callable $value)
    {
        $this->value = $value;
    }

    /**
     * @param array<mixed> ...$args
     *
     * @return CallableCheck
     */
    public function with(...$args): self
    {
        $this->arguments = $args;
        return $this;
    }

    public function throws(string $className): ExceptionCheck
    {
        $this->execute();
        Assert::assertInstanceOf(\Throwable::class, $this->result, $this->message);
        $this->resetMessage();
        return (new ExceptionCheck($this->result))->isAnInstanceOf($className);
    }

    /**
     * @return ArrayCheck|BooleanCheck|CallableCheck|CollectionCheck|DateTimeCheck|ExceptionCheck|FluentCheck|GenericCheck|ResponseCheck|StringCheck
     */
    public function hasAResult()
    {
        $this->execute();
        Assert::assertNotInstanceOf(\Throwable::class, $this->result, $this->message);
        $this->resetMessage();
        return Check::that($this->result);
    }

    /**
     * @return \Exception|mixed
     */
    private function execute()
    {
        try {
            $this->result = \call_user_func($this->value, ...$this->arguments);
        } catch (\Exception $exception) {
            $this->result = $exception;
        }
        return $this->result;
    }
}
