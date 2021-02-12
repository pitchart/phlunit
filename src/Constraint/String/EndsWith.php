<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\String;

use PHPUnit\Framework\Constraint\Constraint;

class EndsWith extends Constraint
{
    /**
     * @var string
     */
    private $suffix;

    /**
     * StartsWith constructor.
     *
     * @param string $suffix
     */
    public function __construct(string $suffix)
    {
        $this->suffix = $suffix;
    }

    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        return \sprintf(
            'ends with "%s", ignoring case',
            $this->suffix
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
        return \preg_match('/' . \preg_quote($this->suffix) . '$/i', $other) > 0;
    }
}
