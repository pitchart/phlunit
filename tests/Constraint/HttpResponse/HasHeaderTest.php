<?php

namespace Tests\Pitchart\Phlunit\Constraint\HttpResponse;

use GuzzleHttp\Psr7\Response;
use Pitchart\Phlunit\Constraint\HttpResponse\HasHeader;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class HasHeaderTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var HasHeader
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new HasHeader('test');
    }

    public function test_succeeds_when_the_response_contains_the_header()
    {
        $response = (new Response(200))->withHeader('test', 'test-value');

        $this->assertTrue($this->constraint->evaluate($response, '', true));
    }

    public function test_fails_when_the_response_does_not_contain_the_header()
    {
        $response = (new Response(200))->withHeader('xxx-test', 'xxx-test-value');

        $this->assertFalse($this->constraint->evaluate($response, '', true));
    }

    public function test_fails_when_evaluates_anything_but_a_response()
    {
        $this->assertFalse($this->constraint->evaluate('test', '', true));
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $response = (new Response(200))->withHeader('xxx-header', 'xxx-header-value');

        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that a HTTP Response has the header 'test'.
EOF
            , $response);
    }


}
