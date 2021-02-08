<?php declare(strict_types=1);

namespace Pitchart\Phlunit\Constraint\Arrays;

use PHPUnit\Framework\Constraint\Constraint;

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

    public function evaluate($other, string $description = '', bool $returnResult = false)
    {
        $other        = ArrayUtility::toArray($other);
        $this->set = ArrayUtility::toArray($this->set);

        if (ArrayUtility::isAssociative($other)) {
            $result = \array_diff_assoc($other, $this->set) === [];
        } else {
            $result = \array_diff($other, $this->set) === [];
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
