<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;

/**
 * Class ArrayCheck
 *
 * @package Pitchart\Phlunit\Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @implements FluentCheck<array>
 */
class ArrayCheck extends CollectionCheck implements FluentCheck
{
    /**
     * ArrayCheck constructor.
     *
     * @template T of array
     * @param array $collection
     */
    public function __construct(array $collection)
    {
        parent::__construct($collection);
    }

    /**
     * @param string|int $expected
     *
     * @return ArrayCheck
     */
    public function hasElementAt($expected): self
    {
        Assert::assertArrayHasKey($expected, (array) $this->value, $this->message);
        return $this;
    }

    /**
     * @param string|int $expected
     *
     * @return ArrayCheck
     */
    public function hasNoElementAt($expected): self
    {
        Assert::assertArrayNotHasKey($expected, (array) $this->value, $this->message);
        return $this;
    }
}
