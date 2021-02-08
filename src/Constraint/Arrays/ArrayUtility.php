<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\Arrays;

class ArrayUtility
{
    public static function isAssociative(array $array)
    {
        $size = \count($array);
        $filteredKeys = \array_filter(\array_keys($array), function ($int) {return $int === (int) $int;});
        return \count($filteredKeys) !== $size;
    }

    public static function isIndexed(array $array)
    {
        return !self::isAssociative($array);
    }

    public static function toArray(iterable $iterable): array
    {
        if ($iterable instanceof \Traversable) {
            return \iterator_to_array($iterable);
        }

        // Keep BC even if we know that array would not be the expected one
        return (array) $iterable;
    }
}
