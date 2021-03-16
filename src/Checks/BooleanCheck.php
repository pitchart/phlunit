<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\FluentChecks;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

/**
 * Class BooleanCheck
 *
 * @package Pitchart\Phlunit\Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @implements FluentCheck<boolean>
 */
class BooleanCheck implements FluentCheck
{
    use TypeCheck, FluentChecks, WithMessage;

    /**
     * @var mixed
     */
    private $value;

    /**
     * BooleanCheck constructor.
     *
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function isTrue(): self
    {
        Assert::assertTrue($this->value);
        return $this;
    }

    public function isFalse(): self
    {
        Assert::assertFalse($this->value);
        return $this;
    }
}
