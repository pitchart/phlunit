<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;
use Pitchart\Phlunit\Constraint\Arrays\ContainsNoDuplicateItem;
use Pitchart\Phlunit\Constraint\Arrays\ContainsSet;
use Pitchart\Phlunit\Constraint\Arrays\IsSubset;

class CollectionCheck implements FluentCheck
{
    use TypeCheck,ConstraintCheck,  WithMessage;
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

    public function contains(...$expected): self
    {
        foreach ($expected as $expectedElement) {
            Assert::assertContains($expectedElement, $this->value, $this->message);
        }
        $this->resetMessage();
        return $this;
    }

    public function containsOnly(string $type): self
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

    public function isSubsetOf(...$set): self
    {
        $constraint = new IsSubset($set);
        $this->resetMessage();
        Assert::assertThat($this->value, $constraint, $this->message);
        return $this;
    }

    public function containsSet(...$subset): self
    {
        $constraint = new ContainsSet($subset, $this->message);
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
}
