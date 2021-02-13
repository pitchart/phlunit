<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\Arrays;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use function Pitchart\Transformer\transform;
use SebastianBergmann\Comparator\ComparisonFailure;

class ContainsExactly extends Constraint
{
    /**
     * @var array<mixed>
     */
    private $elements;

    /**
     * ContainsExactly constructor.
     *
     * @param array<mixed> ...$elements
     */
    public function __construct(...$elements)
    {
        $this->elements = $elements;
    }

    /**
     * @param iterable $other
     * @param string $description
     * @param bool $returnResult
     *
     * @return bool|null
     */
    public function evaluate($other, string $description = '', bool $returnResult = false): ?bool
    {
        //type cast $other & $this->subset as an array to allow
        //support in standard array functions.
        $other = \array_values(ArrayUtility::toArray($other));
        $elements = ArrayUtility::toArray($this->elements);
        $failureList = [];

        $missing = $this->getMissingElements($other, $elements);

        $success = $missing === [];

        if (!empty($missing)) {
            $count = \count($missing);
            $failureList[] = \sprintf(
                "%d %s missing",
                $count,
                $count == 1 ? 'element is' : 'elements are'
            );
        }

        $unexpected = $this->getUnexpectedElements($other, $elements);

        $success = $success && $unexpected === [];

        if (!empty($unexpected)) {
            $count = \count($unexpected);
            $failureList[] = \sprintf(
                "%d %s unexpected",
                $count,
                $count == 1 ? 'element is' : 'elements are'
            );
        }

        if ($success) {
            foreach ($elements as $key => $element) {
                if ($element != $other[$key]) {
                    $success = false;
                    $failureList[] = \sprintf("element at position %s is not the one expected", $key);
                    break;
                }
            }
        }

        if ($returnResult) {
            return $success;
        }

        if (!$success) {
            throw $this->buildFailure($other, $elements, $failureList, $description);
        }

        return null;
    }

    private function buildFailure(array $other, array $elements, array $failureList, string $description = ''): ExpectationFailedException
    {
        $failureDescription = \sprintf(
            'Failed asserting that ' . $this->toString(),
            \count($elements),
            \implode(' and ', $failureList)
        );

        if (!empty($description)) {
            $failureDescription = $description . "\n" . $failureDescription;
        }

        $comparisonFailure = new ComparisonFailure(
            $elements,
            $other,
            $this->exporter()->export($elements),
            $this->exporter()->export($other)
        );

        return new ExpectationFailedException($failureDescription, $comparisonFailure);
    }

    private function getMissingElements(array $other, array $elements): array
    {
        return  transform($elements)->diff($other)->toArray();
    }

    private function getUnexpectedElements(array $other, array $elements): array
    {
        return  transform($other)->diff($elements)->toArray();
    }

    public function toString(): string
    {
        return 'iterable contains %d expected elements because %s.';
    }
}
