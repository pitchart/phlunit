<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Mixin;

use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\ArrayCheck;
use Pitchart\Phlunit\Checks\BooleanCheck;
use Pitchart\Phlunit\Checks\CallableCheck;
use Pitchart\Phlunit\Checks\CollectionCheck;
use Pitchart\Phlunit\Checks\DateTimeCheck;
use Pitchart\Phlunit\Checks\ExceptionCheck;
use Pitchart\Phlunit\Checks\FloatCheck;
use Pitchart\Phlunit\Checks\FluentCheck;
use Pitchart\Phlunit\Checks\GenericCheck;
use Pitchart\Phlunit\Checks\IntegerCheck;
use Pitchart\Phlunit\Checks\ResponseCheck;
use Pitchart\Phlunit\Checks\StringCheck;

/**
 * Class FluentChecks
 *
 * @package Pitchart\Phlunit\Checks\Mixin
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 */
trait FluentChecks
{
    /**
     * @template T
     *
     * @param mixed $sut
     *
     * @psalm-param T of mixed
     *
     * @psalm-return FluentCheck<T>
     * @return \Pitchart\Phlunit\Checks\XmlCheck
     */
    public function that(): self
    {
        return $this;
    }

    /**
     * @template T
     *
     * @param mixed $sut
     *
     * @psalm-param T of mixed
     *
     * @psalm-return FluentCheck<T>
     * @return \Pitchart\Phlunit\Checks\XmlCheck
     */
    public function and(): self
    {
        return $this;
    }

    /**
     * @template T
     *
     * @param mixed $sut
     *
     * @psalm-param T of mixed
     *
     * @psalm-return FluentCheck<T>
     * @return \Pitchart\Phlunit\Checks\XmlCheck
     */
    public function which(): self
    {
        return $this;
    }

    /**
     * @template T
     *
     * @param mixed $sut
     *
     * @psalm-param T of mixed
     *
     * @psalm-return \Pitchart\Phlunit\Checks\FluentCheck<empty>
     * @return \Pitchart\Phlunit\Checks\FluentCheck
     */
    public function andThat($sut): \Pitchart\Phlunit\Checks\FluentCheck
    {
        return Check::that($sut);
    }
}
