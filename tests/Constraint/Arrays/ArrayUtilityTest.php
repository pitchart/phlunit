<?php


namespace Tests\Pitchart\Phlunit\Constraint\Arrays;


use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\Arrays\ArrayUtility;

class ArrayUtilityTest extends TestCase
{
    public function test_detects_associative_arrays()
    {
        Check::that(ArrayUtility::isAssociative(['foo' => 'bar', 2, 3]))->isTrue();
    }

    public function nonAssociativeArrays()
    {
        return [
            'an empty array' => [[]],
            'a sequential array' => [[1, 2, 3]],
            'an array containing a numeric key as string' => [[2, '1' => 'bar', 3]],
        ];
    }

    /**
     * @param array $array
     * @dataProvider nonAssociativeArrays
     */
    public function test_detects_associative_non_arrays(array $array)
    {
        Check::that(ArrayUtility::isAssociative($array))->isFalse();
    }

    /**
     * @param array $array
     * @dataProvider nonAssociativeArrays
     */
    public function test_detects_sequential_arrays(array $array)
    {
        Check::that(ArrayUtility::isIndexed($array))->isTrue();
    }

    public function test_detects_non_sequential_arrays()
    {
        Check::that(ArrayUtility::isIndexed(['foo' => 'bar', 2, 3]))->isFalse();
    }

    /**
     * @dataProvider iterableProvider
     */
    public function test_converts_iterables_to_array(iterable $iterable, array $expected)
    {
        Check::that(ArrayUtility::toArray($iterable))->isEqualTo($expected);
    }

    public function iterableProvider()
    {
        $indexedArray = [1, 2, 3];
        $associativeArray = ['foo' => 'bar', 'fizz' => 'buzz'];
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