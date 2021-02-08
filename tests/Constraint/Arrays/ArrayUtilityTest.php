<?php


namespace Tests\Pitchart\Phlunit\Constraint\Arrays;


use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Constraint\Arrays\ArrayUtility;

class ArrayUtilityTest extends TestCase
{

    public function test_detects_associative_arrays()
    {
        $this->assertFalse(ArrayUtility::isAssociative([]));
        $this->assertFalse(ArrayUtility::isAssociative([1, 2, 3]));
        $this->assertFalse(ArrayUtility::isAssociative([2, '1' =>'bar', 3]));
        $this->assertTrue(ArrayUtility::isAssociative(['foo' =>'bar', 2, 3]));
    }

    public function test_detects_sequential_arrays()
    {
        $this->assertTrue(ArrayUtility::isIndexed([]));
        $this->assertTrue(ArrayUtility::isIndexed([1, 2, 3]));
        $this->assertTrue(ArrayUtility::isIndexed([2, '1' =>'bar', 3]));
        $this->assertFalse(ArrayUtility::isIndexed(['foo' =>'bar', 2, 3]));
    }

    /**
     * @dataProvider iterableProvider
     */
    public function test_converts_iterables_to_array(iterable $iterable, array $expected)
    {
        $this->assertEquals($expected, ArrayUtility::toArray($iterable));
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