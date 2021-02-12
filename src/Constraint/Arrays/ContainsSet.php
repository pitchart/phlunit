<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\Arrays;

use PHPUnit\Framework\Constraint\Constraint;
use function Pitchart\Transformer\transform;

final class ContainsSet extends Constraint
{
    /**
     * @var iterable
     */
    private $set;

    public function __construct(iterable $subset)
    {
        $this->set = $subset;
    }

    public function evaluate($other, string $description = '', bool $returnResult = false): ?bool
    {
        //type cast $other & $this->subset as an array to allow
        //support in standard array functions.
        $other = ArrayUtility::toArray($other);
        $set = ArrayUtility::toArray($this->set);

        if (ArrayUtility::isAssociative($other)) {
            $result = \array_diff_assoc($set, $other) === [];
        } else {
            $result = transform($set)->diff($other)->toArray() === [];
        }

        if (!$returnResult && !$result) {
            $this->fail($other, $description);
        }

        return $result;
    }

    public function toString(): string
    {
        return ' contains the subset ' . $this->exporter()->export($this->set);
    }

    protected function failureDescription($other): string
    {
        return $this->exporter()->export($other) . $this->toString();
    }
}
