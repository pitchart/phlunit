<?php declare(strict_types=1);

namespace Pitchart\Phlunit\Constraint\HttpResponse;

use PHPUnit\Framework\Constraint\Constraint;
use Psr\Http\Message\ResponseInterface;

final class HasStatusCode extends Constraint
{
    /**
     * @var int
     */
    private $code;

    /**
     * @param int|string $code
     */
    public function __construct($code)
    {
        $this->code = (int) $code;
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @return string
     */
    public function toString(): string
    {
        return 'has the expected status code ' . $this->exporter()->export($this->code);
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
            return $other->getStatusCode() === $this->code;
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
     *
     * @return string
     */
    protected function failureDescription($other): string
    {
        $statusCode = $other instanceof ResponseInterface ? $other->getStatusCode() : (string) $other;
        return 'a HTTP Response with status ' . $statusCode . ' ' . $this->toString();
    }
}
