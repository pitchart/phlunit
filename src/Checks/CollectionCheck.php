<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;
use Pitchart\Phlunit\Constraint\Arrays\ContainsExactly;
use Pitchart\Phlunit\Constraint\Arrays\ContainsNoDuplicateItem;
use Pitchart\Phlunit\Constraint\Arrays\ContainsSet;
use Pitchart\Phlunit\Constraint\Arrays\IsSubset;

/**
 * Class CollectionCheck
 *
 * @package Pitchart\Phlunit\Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @implements FluentCheck<iterable>
 */
class CollectionCheck implements FluentCheck
{
    use TypeCheck, ConstraintCheck, WithMessage;

    /**
     * @var iterable
     */
    protected $value;

    /**
     * CollectionCheck constructor.
     *
     * @template T of iterable
     * @param iterable $actual
     */
    public function __construct(iterable $collection)
    {
        $this->value = $collection;
    }

    public function isEmpty(): self
    {
        Assert::assertEmpty($this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isNotEmpty(): self
    {
        Assert::assertNotEmpty($this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isACollectionOf(string $type): self
    {
        Assert::assertContainsOnly($type, $this->value, null, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function containsOnlyInstancesOf(string $className): self
    {
        Assert::assertContainsOnlyInstancesOf($className, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    /**
     * @param array<mixed> ...$expected
     *
     * @return CollectionCheck
     */
    public function contains(...$expected): self
    {
        foreach ($expected as $expectedElement) {
            Assert::assertContains($expectedElement, $this->value, $this->message);
        }
        $this->resetMessage();
        return $this;
    }

    /**
     * @param array<mixed> ...$expected
     *
     * @return CollectionCheck
     */
    public function containsExactly(...$expected): self
    {
        Assert::assertThat($this->value, new ContainsExactly(...$expected), $this->message);
        return $this;
    }

    /**
     * @param array<mixed> ...$subset
     *
     * @return CollectionCheck
     */
    public function containsSet(...$subset): self
    {
        $constraint = new ContainsSet($subset);
        Assert::assertThat($this->value, $constraint, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function containsNoDuplicateItem(): self
    {
        Assert::assertThat($this->value, new ContainsNoDuplicateItem(), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function hasLength(int $length): self
    {
        Assert::assertCount($length, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function hasNotLength(int $length): self
    {
        Assert::assertNotCount($length, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    /**
     * @param array<mixed> ...$set
     *
     * @return CollectionCheck
     */
    public function isSubsetOf(...$set): self
    {
        $constraint = new IsSubset($set);
        $this->resetMessage();
        Assert::assertThat($this->value, $constraint, $this->message);
        return $this;
    }
}
