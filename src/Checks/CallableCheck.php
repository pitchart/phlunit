<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

class CallableCheck implements FluentCheck
{
    use TypeCheck, WithMessage;

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

    public function hasAResult()
    {
        $this->execute();
        Assert::assertNotInstanceOf(\Throwable::class, $this->result, $this->message);
        $this->resetMessage();
        return Check::that($this->result);
    }

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
