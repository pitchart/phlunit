<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\Arrays;

class ArrayUtility
{
    public static function isAssociative(array $array): bool
    {
        $size = \count($array);
        $filteredKeys = \array_filter(\array_keys($array), function($int) {return $int === (int) $int;});
        return \count($filteredKeys) !== $size;
    }

    public static function isIndexed(array $array): bool
    {
        return !self::isAssociative($array);
    }

    public static function toArray(iterable $iterable): array
    {
        if ($iterable instanceof \Traversable) {
            return \iterator_to_array($iterable);
        }

        return $iterable;
    }
}
