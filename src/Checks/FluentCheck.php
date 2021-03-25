<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Interface FluentCheck
 * @package Pitchart\Phlunit\Checks
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @template T
 */
interface FluentCheck
{
    /**
     * @template T
     * @psalm-return FluentCheck<T>
     */
    public function that();

    /**
     * @template T
     * @param mixed $sut
     * @psalm-param T of mixed
     * @psalm-return FluentCheck<T>
     */
    public function andThat($sut);

    /**
     * @template T
     * @psalm-return FluentCheck<T>
     */
    public function and();

    /**
     * @template T
     * @psalm-return FluentCheck<T>
     */
    public function which();

    /**
     * @template T
     * @param Constraint $constraint
     * @psalm-return FluentCheck<T>
     */
    public function has(Constraint $constraint);

    /**
     * @template T
     * @param Constraint $constraint
     * @psalm-return FluentCheck<T>
     */
    public function is(Constraint $constraint);

    /**
     * @template T
     * @param Constraint $constraint
     * @psalm-return FluentCheck<T>
     */
    public function hasNot(Constraint $constraint);

    /**
     * @template T
     * @param Constraint $constraint
     * @psalm-return FluentCheck<T>
     */
    public function isNot(Constraint $constraint);
}
