<?php

namespace Tests\Pitchart\Phlunit\Constraint\HttpResponse;

use GuzzleHttp\Psr7\Response;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\HttpResponse\HasHeader;
use Pitchart\Phlunit\Constraint\HttpResponse\HasReason;
use Pitchart\Phlunit\Constraint\HttpResponse\HasStatusCode;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class HasReasonTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var HasReason
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new HasReason('OK');
    }

    public function test_succeeds_when_the_response_contains_the_header()
    {
        $response = new Response(200);

        $evaluation = $this->constraint->evaluate($response, '', true);

        Check::that($evaluation)->isTrue();
    }

    public function test_fails_when_the_response_does_not_contain_the_header()
    {
        $response = new Response(400);

        $evaluation = $this->constraint->evaluate($response, '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_when_evaluates_anything_but_a_response()
    {
        $evalutaion = $this->constraint->evaluate('test', '', true);

        Check::that($evalutaion)->isFalse();
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $response = new Response(400);

        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that a HTTP Response with reason phrase 'Bad Request' has the expected reason phrase 'OK'.
EOF
            , $response);
    }


}
