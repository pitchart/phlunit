<?php

namespace Tests\Pitchart\Phlunit\Constraint\Arrays;

use Pitchart\Phlunit\Constraint\Arrays\ContainsNoDuplicateItem;
use Pitchart\Phlunit\Constraint\Arrays\ContainsSet;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class ContainsNoDuplicateItemTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var ContainsNoDuplicateItem
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new ContainsNoDuplicateItem();
    }

    /**
     * @param $iterable
     * @dataProvider containsSubsets
     */
    public function test_successes_when_evaluates_iterables_not_containing_duplicate_item($iterable)
    {
        $this->assertTrue($this->constraint->evaluate($iterable, '', true));
    }

    public function containsSubsets()
    {
        $indexedArray = [1, 2, 3];
        $arrayToGenerator = (function (array $array) { yield from $array; });

        yield from [
            'indexed array' => [$indexedArray],
            'indexed \ArrayAccess' => [new \ArrayObject($indexedArray)],
            'indexed \Iterator' => [new \ArrayIterator($indexedArray)],
            'indexed \Generator' => [$arrayToGenerator($indexedArray)],
        ];
    }

    public function test_fails_when_evaluate_non_prefixed_string()
    {
        $this->assertFalse($this->constraint->evaluate([1, 2, 3, 2, 4], '', true));
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that Array &0 (
    0 => 1
    1 => 2
    2 => 1
) contains no duplicate item.
EOF
                , [1, 2, 1]);
    }

}
