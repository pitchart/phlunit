<?php declare(strict_types=1);

namespace Pitchart\Phlunit\Constraint\HttpResponse;

use PHPUnit\Framework\Constraint\Constraint;
use Psr\Http\Message\ResponseInterface;

final class HasReason extends Constraint
{
    /**
     * @var string
     */
    private $reason;

    /**
     * @param string $key
     */
    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function toString(): string
    {
        return 'has the expected reason phrase ' . $this->exporter()->export($this->reason);
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other value or object to evaluate
     */
    protected function matches($other): bool
    {
        if ($other instanceof ResponseInterface) {
            return $other->getReasonPhrase() === $this->reason;
        }

        return false;
    }

    /**
     * Returns the description of the failure
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param mixed $other evaluated value or object
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    protected function failureDescription($other): string
    {
        $reason = $other instanceof ResponseInterface ? $other->getReasonPhrase() : (string) $other;
        return 'a HTTP Response with reason phrase \'' . $reason . '\' ' . $this->toString();
    }
}
