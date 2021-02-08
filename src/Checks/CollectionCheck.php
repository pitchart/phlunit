<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Constraint\Arrays\ContainsNoDuplicateItem;
use Pitchart\Phlunit\Constraint\Arrays\ContainsSet;
use Pitchart\Phlunit\Constraint\Arrays\IsSubset;

class CollectionCheck implements FluentCheck
{
    use TypeCheck;
    /**
     * @var iterable
     */
    protected $value;

    /**
     * CollectionCheck constructor.
     *
     * @param iterable $actual
     */
    public function __construct(iterable $collection)
    {
        $this->value = $collection;
    }

    public function isEmpty($message = ''): self
    {
        Assert::assertEmpty($this->value, $message);
        return $this;
    }

    public function isNotEmpty($message = ''): self
    {
        Assert::assertNotEmpty($this->value, $message);
        return $this;
    }

    public function contains($expected, $message = ''): self
    {
        Assert::assertContains($expected, $this->value, $message);
        return $this;
    }

    public function containsOnly(string $type, $message = ''): self
    {
        Assert::assertContainsOnly($type, $this->value, null, $message);
        return $this;
    }

    public function containsOnlyInstancesOf(string $className, string $message = ''): self
    {
        Assert::assertContainsOnlyInstancesOf($className, $this->value, $message);
        return $this;
    }

    public function hasLength(int $length, $message = ''): self
    {
        Assert::assertCount($length, $this->value, $message);
        return $this;
    }

    public function hasNotLength(int $length, $message = ''): self
    {
        Assert::assertNotCount($length, $this->value, $message);
        return $this;
    }

    public function isSubsetOf(iterable $set, $message = ''): self
    {
        $constraint = new IsSubset($set);
        Assert::assertThat($this->value, $constraint, $message);
        return $this;
    }

    public function containsSet(iterable $subset, $message = ''): self
    {
        $constraint = new ContainsSet($subset, $message);
        Assert::assertThat($this->value, $constraint, $message);
        return $this;
    }

    public function containsNoDuplicateItem($message = ''): self
    {
        Assert::assertThat($this->value, new ContainsNoDuplicateItem(), $message);
        return $this;
    }
}
