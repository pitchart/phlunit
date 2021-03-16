<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\Arrays;

use PHPUnit\Framework\Constraint\Constraint;

class ContainsNoDuplicateItem extends Constraint
{
    protected function matches($other): bool
    {
        $other = ArrayUtility::toArray($other);
        return \count($this->deduplicate($other)) === \count($other);
    }

    /**
     * @return (mixed|null)[]
     *
     * @psalm-return non-empty-list<mixed|null>
     */
    private function deduplicate(array $array): array
    {
        $unique = [];
        do {
            $element = \array_shift($array);
            $unique[] = $element;

            $array = \array_udiff(
                $array,
                [$element],
                function($first, $second) {
                    return $first <=> $second;
                }
            );
        } while (\count($array) > 0);

        return $unique;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return 'contains no duplicate item';
    }
}
