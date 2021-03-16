<?php

namespace Tests\Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Exception as ExceptionConstraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Checks\ArrayCheck;
use Pitchart\Phlunit\Checks\CollectionCheck;
use Pitchart\Phlunit\Check;

class CollectionCheckTest extends TestCase
{
    public function test_emptyness()
    {
        Check::that(new \ArrayIterator([]))->isEmpty();
        Check::that([])->isEmpty();

        Check::that(new \ArrayIterator([1, 2, 3]))->isNotEmpty();
        Check::that([1, 2, 3])->isNotEmpty();
    }

    public function test_switches_from_generic_to_collection_specific_assertions()
    {
        $phluentp = Check::that([1, 2]);

        Check::that($phluentp)->isAnInstanceOf(CollectionCheck::class);
    }

    public function test_switches_from_generic_to_array_specific_assertions()
    {
        $phluentp = Check::that([1, 2]);

        Check::that($phluentp)->isAnInstanceOf(ArrayCheck::class);
    }

    public function test_verifies_size()
    {
        Check::that([0, 1, 2])
            ->hasElementAt(1)
            ->and->hasNoElementAt(12)
            ->hasLength(3)
            ->hasNotLength(12)
            ->contains(1, 2)
        ;
    }

    public function test_verifies_sut_contains_only_one_type()
    {
        Check::that([0, 1, 2])->isACollectionOf('integer')->isACollectionOf('int');
        Check::that(['zero', 'one', 'two'])->isACollectionOf('string');
    }

    public function test_verifies_sut_contains_only_one_class_instances()
    {
        check::that([new \StdClass(), new \StdClass(), new \StdClass()])->containsOnlyInstancesOf(\StdClass::class);
    }

    public function test_verifies_sut_is_subset_of_a_set()
    {
        Check::that([1, 3])->isSubsetOf(1, 2, 3, 4);
    }

    public function test_verifies_sut_contains_a_set()
    {
        Check::that([1, 2, 3, 4])->containsSet(1, 3);
    }

    public function test_verifies_items_uniqueness()
    {
        Check::that([1, 2, 3, 4])->containsNoDuplicateItem();
    }

    public function test_checks_arrays()
    {
        Check::that([0, 1, 2])
            ->hasElementAt(1)
            ->hasNoElementAt(12)
            ->hasLength(3)
            ->hasNotLength(12)
            ->contains(0, 2)
        ;

        Check::that([new \StdClass(), new \StdClass(), new \StdClass()])->containsOnlyInstancesOf(\StdClass::class);
    }

    public function test_checks_exact_content_of_a_collection()
    {
        Check::that([1, 2, 3])->containsExactly(1, 2, 3);
        Check::that([])->containsExactly();
        Check::that([1, 2, 3])->containsExactly(...[1, 2, 3]);
    }

    /**
     * @param iterable $sut
     * @param string $method
     * @param array $arguments
     * @dataProvider methodsAreFulentProvider
     */
    public function test_has_fluent_methods(iterable $sut, string $method, array $arguments = [])
    {
        Check::that(call_user_func_array([Check::that($sut), $method], $arguments))
            ->isAnInstanceOf(CollectionCheck::class);
    }

    public function methodsAreFulentProvider()
    {
        yield from [
            'contains' => [[1, 2, 3], 'contains', [2]],
            'isACollectionOf' => [[1, 2, 3], 'isACollectionOf', ['int']],
            'containsOnlyInstancesOf' => [[new \StdClass], 'containsOnlyInstancesOf', [\StdClass::class]],
            'hasLength' => [[1, 2, 3], 'hasLength', [3]],
            'hasNotLength' => [[1, 2, 3], 'hasNotLength', [2]],
            'isSubsetOf' => [[1, 2, 3], 'isSubsetOf', [0, 1, 2, 3, 4, 5]],
            'containsExactly' => [[1, 2, 3], 'containsExactly', [1, 2, 3]],
            'containsSet' => [[1, 2, 3], 'containsSet', [1, 2]],
            'containsNoDuplicateItem ' => [[1, 2, 3], 'containsNoDuplicateItem', []],
            'isEqualTo' => [[1, 2, 3], 'isEqualTo', [[1, 2, 3]]],
            'isNotEqualTo' => [[1, 2, 3], 'isNotEqualTo', [[1, 2]]],
        ];
    }

}