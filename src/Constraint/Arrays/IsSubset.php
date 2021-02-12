<?php declare(strict_types=1);

namespace Pitchart\Phlunit\Constraint\Arrays;

use PHPUnit\Framework\Constraint\Constraint;
use function Pitchart\Transformer\transform;

final class IsSubset extends Constraint
{
    /**
     * @var iterable
     */
    private $set;

    public function __construct(iterable $set)
    {
        $this->set = $set;
    }

    public function evaluate($other, string $description = '', bool $returnResult = false): ?bool
    {
        $other = ArrayUtility::toArray($other);
        $set = ArrayUtility::toArray($this->set);

        if (ArrayUtility::isAssociative($other)) {
            $result = \array_diff_assoc($other, $set) === [];
        } else {
            $result = transform($other)->diff($set)->toArray() === [];
        }

        if (!$returnResult && !$result) {
            $this->fail($other, $description);
        }

        return $result;
    }

    public function toString(): string
    {
        return ' is a subset of ' . $this->exporter()->export($this->set);
    }

    protected function failureDescription($other): string
    {
        return $this->exporter()->export($other) . $this->toString();
    }
}
