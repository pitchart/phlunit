<?php

namespace Tests\Pitchart\Phlunit\Constraint\Arrays;

use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\Arrays\ContainsNoDuplicateItem;
use Pitchart\Phlunit\Constraint\Arrays\ContainsSet;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;
use Tests\Pitchart\Phlunit\Fixture\Person;

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
        $evaluation = $this->constraint->evaluate($iterable, '', true);

        Check::that($evaluation)->isTrue();
    }

    public function test_succeeds_with_objects_collections()
    {
        $constraint = new ContainsNoDuplicateItem();

        $evaluation = $constraint->evaluate([new Person('Batman'), new Person('Robin')], '', true);

        Check::that($evaluation)->isTrue();
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
        $evaluation = $this->constraint->evaluate([1, 2, 3, 2, 4], '', true);

        Check::that($evaluation)->isFalse();
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
