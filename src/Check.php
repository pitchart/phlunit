<?php declare(strict_types=1);


namespace Pitchart\Phlunit;

use Pitchart\Phlunit\Checks\ArrayCheck;
use Pitchart\Phlunit\Checks\BooleanCheck;
use Pitchart\Phlunit\Checks\CallableCheck;
use Pitchart\Phlunit\Checks\CollectionCheck;
use Pitchart\Phlunit\Checks\DateTimeCheck;
use Pitchart\Phlunit\Checks\ExceptionCheck;
use Pitchart\Phlunit\Checks\FluentCheck;
use Pitchart\Phlunit\Checks\GenericCheck;
use Pitchart\Phlunit\Checks\IntegerCheck;
use Pitchart\Phlunit\Checks\ResponseCheck;
use Pitchart\Phlunit\Checks\StringCheck;
use Psr\Http\Message\ResponseInterface;

final class Check
{
    private static $assertionClassesMap = [
        'string' => StringCheck::class,
        'boolean' => BooleanCheck::class,
        'integer' => IntegerCheck::class,
        'float' => GenericCheck::class,
        'array' => ArrayCheck::class,
        'iterable' => CollectionCheck::class,
        'callable' => CallableCheck::class,
        \Throwable::class => ExceptionCheck::class,
        ResponseInterface::class => ResponseCheck::class,
        \DateTimeInterface::class => DateTimeCheck::class,
    ];

    private static function hasAssertionClass($type)
    {
        return isset(self::$assertionClassesMap[$type]) && \class_exists(self::$assertionClassesMap[$type]);
    }


    /**
     * @template T
     * @param mixed $sut
     *
     * @return BooleanCheck | GenericCheck | CallableCheck | CollectionCheck | ResponseCheck | ArrayCheck | DateTimeCheck | StringCheck | ExceptionCheck | FluentCheck<T>
     */
    public static function that($sut): FluentCheck
    {
        if (\is_object($sut)) {
            if (self::hasAssertionClass(\get_class($sut))) {
                return new self::$assertionClassesMap[\get_class($sut)]($sut);
            }
            foreach (\array_keys(self::$assertionClassesMap) as $class) {
                if ($sut instanceof $class) {
                    return new self::$assertionClassesMap[$class]($sut);
                }
            }
        }
        if (\is_callable($sut)) {
            return new self::$assertionClassesMap['callable']($sut);
        }
        if (\is_array($sut)) {
            return new self::$assertionClassesMap['array']($sut);
        }
        if (\is_iterable($sut)) {
            return new self::$assertionClassesMap['iterable']($sut);
        }
        if (self::hasAssertionClass(\gettype($sut))) {
            return new self::$assertionClassesMap[\gettype($sut)]($sut);
        }
        return new GenericCheck($sut);
    }

    public static function thatCall(callable $function): CallableCheck
    {
        return self::that($function);
    }

    public static function registerChecksFor(string $className, string $assertionClass)
    {
        self::$assertionClassesMap[$className] = $assertionClass;
    }
}
