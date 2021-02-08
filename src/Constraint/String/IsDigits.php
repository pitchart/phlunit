<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\String;

use PHPUnit\Framework\Constraint\Constraint;

class IsDigits extends Constraint
{
    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        return 'is digits';
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other value or object to evaluate
     */
    protected function matches($other): bool
    {
        return \is_numeric($other);
    }
}
