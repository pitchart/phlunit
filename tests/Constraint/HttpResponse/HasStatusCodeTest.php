<?php

namespace Tests\Pitchart\Phlunit\Constraint\HttpResponse;

use GuzzleHttp\Psr7\Response;
use Pitchart\Phlunit\Constraint\HttpResponse\HasHeader;
use Pitchart\Phlunit\Constraint\HttpResponse\HasStatusCode;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class HasStatusCodeTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var HasHeader
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new HasStatusCode(200);
    }

    public function test_succeeds_when_the_response_contains_the_header()
    {
        $response = new Response(200);

        $this->assertTrue($this->constraint->evaluate($response, '', true));
    }

    public function test_fails_when_the_response_does_not_contain_the_header()
    {
        $response = new Response(400);

        $this->assertFalse($this->constraint->evaluate($response, '', true));
    }

    public function test_fails_when_evaluates_anything_but_a_response()
    {
        $this->assertFalse($this->constraint->evaluate('test', '', true));
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $response = new Response(400);

        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that a HTTP Response with status 400 has the expected status code 200.
EOF
            , $response);
    }


}
