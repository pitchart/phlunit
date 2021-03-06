<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\String;

use PHPUnit\Framework\Constraint\Constraint;

class StartsWith extends Constraint
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * StartsWith constructor.
     *
     * @param string $prefix
     */
    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        return \sprintf(
            'starts with "%s", ignoring case',
            $this->prefix
        );
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param string $other value or object to evaluate
     */
    protected function matches($other): bool
    {
        return \preg_match("/^" . \preg_quote($this->prefix) . "/i", $other) > 0;
    }
}
