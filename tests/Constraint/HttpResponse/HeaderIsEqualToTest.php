<?php

namespace Tests\Pitchart\Phlunit\Constraint\HttpResponse;

use GuzzleHttp\Psr7\Response;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\HttpResponse\HeaderIsEqualTo;
use PHPUnit\Framework\TestCase;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;

class HeaderIsEqualToTest extends ConstraintTestCase
{
    /**
     * @var HeaderIsEqualTo
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new HeaderIsEqualTo('test', 'test');
    }

    public function test_succeeds_for_single_value_header_with_matching_value()
    {
        $response = (new Response(200))->withHeader('test', 'test');

        $evaluation = $this->constraint->evaluate($response, '', true);

        Check::that($evaluation)->isTrue();
    }

    public function test_succeeds_for_multi_values_header()
    {
        $response = (new Response(200))
            ->withHeader('Accept-Charset', 'utf-8')
            ->withAddedHeader('Accept-Charset', 'iso-8859-1;q=0.5')
            ->withAddedHeader('Accept-Charset', '*;q=0.1')
        ;

        $constraint = new HeaderIsEqualTo('Accept-Charset', 'utf-8, iso-8859-1;q=0.5, *;q=0.1');

        $evaluation = $constraint->evaluate($response, '', true);

        Check::that($evaluation)->isTrue();
    }

    public function test_fails_for_missing_header()
    {
        $response = (new Response(200))->withHeader('test', 'fail');

        $evaluation = $this->constraint->evaluate($response, '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_for_single_value_header_with_wrong_value()
    {
        $response = (new Response(200))->withHeader('test', 'fail');

        $evaluation = $this->constraint->evaluate($response, '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_for_multi_values_header_with_wrong_value()
    {
        $response = (new Response(200))
            ->withHeader('Accept-Charset', 'utf-8')
            ->withAddedHeader('Accept-Charset', '*;q=0.1')
        ;

        $constraint = new HeaderIsEqualTo('Accept-Charset', 'utf-8, iso-8859-1;q=0.5, *;q=0.1');

        $evaluation = $constraint->evaluate($response, '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $response = (new Response(200))->withHeader('xxx-header', 'xxx-header-value');

        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that GuzzleHttp\Psr7\Response Object (
    'headers' (
        xxx-header: xxx-header-value
    )
)  has value 'test' for header 'test'.
EOF
            , $response);
    }

}
