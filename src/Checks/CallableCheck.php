<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Exception as ExceptionConstraint;
use PHPUnit\Framework\Constraint\ExceptionCode;
use PHPUnit\Framework\Constraint\ExceptionMessage;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;

class CallableCheck implements FluentCheck
{
    use TypeCheck;

    /**
     * @var callable
     */
    private $value;

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @var ?string
     */
    private $exceptionClass;

    /**
     * @var ?string
     */
    private $exceptionMessage;

    /**
     * @var ?int
     */
    private $exceptionCode;

    public function __construct(callable $value)
    {
        $this->value = $value;
    }

    public function with(...$args): self
    {
        $this->arguments = $args;
        return $this;
    }

    public function throws(string $className): self
    {
        $this->exceptionClass = $className;
        return $this;
    }

    public function withMessage(string $message): self
    {
        $this->exceptionMessage = $message;
        return $this;
    }

    public function withCode(int $code): self
    {
        $this->exceptionCode = $code;
        return $this;
    }

    public function onExecute()
    {
        if ($this->exceptionClass !== null) {
            try {
                $this->execute();
            } catch (\Exception $exception) {
                Assert::assertThat($exception, new ExceptionConstraint($this->exceptionClass));
                if ($this->exceptionMessage !== null) {
                    Assert::assertThat($exception, new ExceptionMessage($this->exceptionMessage));
                }
                if ($this->exceptionCode !== null) {
                    Assert::assertThat($exception, new ExceptionCode($this->exceptionCode));
                }
            }
        }
    }

    private function execute()
    {
        return \call_user_func($this->value, ...$this->arguments);
    }
}
