<?php

namespace Tests\Pitchart\Phlunit\Constraint\Arrays;

use Tests\Pitchart\Phlunit\Fixture\Person;
use Pitchart\Phlunit\Constraint\Arrays\ContainsExactly;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class ContainsExactlyTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var ContainsExactly
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new ContainsExactly(1, 2, 3);
    }

    /**
     * @param iterable $iterable
     * @dataProvider validIterablesProvider
     */
    public function test_succeeds_when_elements_are_the_sames_in_the_same_order(iterable $iterable)
    {
        $this->assertTrue($this->constraint->evaluate($iterable, '', true));
    }

    public function test_succeeds_with_objects_collections()
    {
        $this->assertTrue(
            (new ContainsExactly(new Person('Batman'), new Person('Robin')))
                ->evaluate(
                    [new Person('Batman'), new Person('Robin')],
                    '', true
                )
        );
    }

    public function test_fails_when_sut_has_more_elements()
    {
        $this->assertFalse($this->constraint->evaluate([1, 2, 3, 4], '', true));
    }

    public function test_fails_when_sut_has_no_element()
    {
        $this->assertFalse($this->constraint->evaluate([], '', true));
    }

    public function test_fails_when_sut_has_less_elements()
    {
        $this->assertFalse($this->constraint->evaluate([1, 2], '', true));
    }

    public function test_fails_when_sut_has_missing_and_unexpected_elements()
    {
        $this->assertFalse($this->constraint->evaluate([1, 4], '', true));
    }

    public function test_fails_when_elements_are_not_in_the_same_order()
    {
        $this->assertFalse($this->constraint->evaluate([1, 3, 2], '', true));
    }

    /**
     * @param iterable $sut
     * @param string $message
     * @dataProvider clearMessageProvider
     */
    public function test_fails_with_a_clear_and_complete_error_message(iterable $sut = [], string $message = '', string $description = '')
    {
        $this->assertHasFailingMessage($message, $sut, $description);
    }

    public function clearMessageProvider()
    {
        yield from ['missing elements only' => [
            [1, 2], <<<EOF
Failed asserting that iterable contains 3 expected elements because 1 element is missing.
--- Expected
+++ Actual
@@ @@
 Array &0 (
     0 => 1
     1 => 2
-    2 => 3
 )
EOF
        ]];

        yield from ['unexpected elements only' => [
            [1, 2, 3, 4, 5], <<<EOF
Failed asserting that iterable contains 3 expected elements because 2 elements are unexpected.
--- Expected
+++ Actual
@@ @@
     0 => 1
     1 => 2
     2 => 3
+    3 => 4
+    4 => 5
 )
EOF
        ]];

        yield from ['missing and unexpected elements' => [
            [2, 3, 4, 5], <<<EOF
Failed asserting that iterable contains 3 expected elements because 1 element is missing and 2 elements are unexpected.
--- Expected
+++ Actual
@@ @@
 Array &0 (
-    0 => 1
-    1 => 2
-    2 => 3
+    0 => 2
+    1 => 3
+    2 => 4
+    3 => 5
 )
EOF
        ]];

        yield from ['elements at bad position' => [
            [1, 3, 2], <<<EOF
Failed asserting that iterable contains 3 expected elements because element at position 1 is not the one expected.
--- Expected
+++ Actual
@@ @@
 Array &0 (
     0 => 1
-    1 => 2
-    2 => 3
+    1 => 3
+    2 => 2
 )
EOF
        ]];

        yield from ['an identifier message' => [
            [1, 2], <<<EOF
An identifier message
Failed asserting that iterable contains 3 expected elements because 1 element is missing.
--- Expected
+++ Actual
@@ @@
 Array &0 (
     0 => 1
     1 => 2
-    2 => 3
 )
EOF
        , 'An identifier message']];
    }

    public function validIterablesProvider()
    {
        $indexedArray = [1, 2, 3];
        $associativeArray = ['foo' => 1, 'bar' => 2, 'baz' => 3];
        $arrayToGenerator = (function (array $array) { yield from $array; });

        yield from [
            'indexed array' => [$indexedArray, $indexedArray],
            'indexed \ArrayAccess' => [new \ArrayObject($indexedArray), $indexedArray],
            'indexed \Iterator' => [new \ArrayIterator($indexedArray), $indexedArray],
            'indexed \Generator' => [$arrayToGenerator($indexedArray), $indexedArray],
            'associative array' => [$associativeArray, $associativeArray],
            'associative \ArrayAccess' => [new \ArrayObject($associativeArray), $associativeArray],
            'associative \Iterator' => [new \ArrayIterator($associativeArray), $associativeArray],
            'associative \Generator' => [$arrayToGenerator($associativeArray), $associativeArray],
        ];
    }


}
