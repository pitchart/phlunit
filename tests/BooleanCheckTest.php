<?php declare(strict_types=1);

namespace Tests\Pitchart\Phlunit;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Exception as ExceptionConstraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Checks\ArrayCheck;
use Pitchart\Phlunit\Checks\CallableCheck;
use Pitchart\Phlunit\Checks\CollectionCheck;
use Pitchart\Phlunit\Checks\GenericCheck;
use Pitchart\Phlunit\Checks\DateTimeCheck;
use Pitchart\Phlunit\Checks\ResponseCheck;
use Pitchart\Phlunit\Checks\StringCheck;
use Pitchart\Phlunit\Check;
use Psr\Http\Message\ResponseInterface;
use Tests\Pitchart\Phlunit\Fixture\Custom;
use Tests\Pitchart\Phlunit\Fixture\CustomAssertion;

class BooleanCheckTest extends TestCase
{
    public function test_assert_true()
    {
        Check::that(true)->isTrue();
    }

    public function test_assert_false()
    {
        Check::that(false)->isFalse();
    }

}