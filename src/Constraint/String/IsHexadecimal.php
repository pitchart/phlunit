<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\String;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\StringMatchesFormatDescription;

class IsHexadecimal extends Constraint
{
    /**
     * @return string
     */
    public function toString(): string
    {
        return 'is hexadecimal';
    }

    protected function matches($other): bool
    {
        return (new StringMatchesFormatDescription('%x'))->evaluate($other, '', true);
    }
}
