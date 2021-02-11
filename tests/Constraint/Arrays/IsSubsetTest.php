<?php

namespace Tests\Pitchart\Phlunit\Constraint\Arrays;

use Pitchart\Phlunit\Constraint\Arrays\IsSubset;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;
use Tests\Pitchart\Phlunit\Fixture\Person;

class IsSubsetTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var IsSubset
     */
    protected $constraint;

    /**
     * @var IsSubset
     */
    protected $associativeConstraint;

    protected function setUp(): void
    {
        $this->constraint = new IsSubset([1, 2, 3]);
        $this->associativeConstraint = new IsSubset(['foo' => 'bar', 'fizz' => 'buzz']);
    }

    /**
     * @param $iterable
     * @dataProvider containsSubsets
     */
    public function test_successes_when_evaluates_subsets_iterables($iterable)
    {
        $this->assertTrue($this->constraint->evaluate($iterable, '', true));
    }

    public function containsSubsets()
    {
        $indexedArray = [2, 3];
        $arrayToGenerator = (function (array $array) { yield from $array; });

        yield from [
            'indexed array' => [$indexedArray],
            'indexed \ArrayAccess' => [new \ArrayObject($indexedArray)],
            'indexed \Iterator' => [new \ArrayIterator($indexedArray)],
            'indexed \Generator' => [$arrayToGenerator($indexedArray)],
        ];
    }

    public function test_succeeds_with_objects_collections()
    {
        $this->assertTrue(
            (new IsSubset([new Person('Batman'), new Person('Catwoman'), new Person('Robin'), new Person('Alfred')]))
                ->evaluate(
                    [new Person('Batman'), new Person('Robin')],
                    '', true
                )
        );
    }

    public function test_fails_when_evaluate_non_prefixed_string()
    {
        $this->assertFalse($this->constraint->evaluate([1, 4], '', true));
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that Array &0 (
    0 => 1
    1 => 4
) is a subset of Array &0 (
    0 => 1
    1 => 2
    2 => 3
).
EOF
            , [1, 4]);
    }

    /**
     * @param $iterable
     * @dataProvider containsAssociativeSubsets
     */
    public function test_successes_when_evaluates_containing_associative_iterables($iterable)
    {
        $this->assertTrue($this->associativeConstraint->evaluate($iterable, '', true));
    }

    public function containsAssociativeSubsets()
    {
        $associativeArray = ['foo' => 'bar'];
        $arrayToGenerator = (function (array $array) { yield from $array; });

        yield from [
            'associative array' => [$associativeArray],
            'associative \ArrayAccess' => [new \ArrayObject($associativeArray)],
            'associative \Iterator' => [new \ArrayIterator($associativeArray)],
            'associative \Generator' => [$arrayToGenerator($associativeArray)],
        ];
    }

    public function test_fails_when_evaluates_non_containing_associative_iterables()
    {
        $this->assertFalse($this->associativeConstraint->evaluate(['foo' => 'buzz',], '', true));
    }
}
