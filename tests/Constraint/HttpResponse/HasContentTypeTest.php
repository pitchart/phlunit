<?php

namespace Tests\Pitchart\Phlunit\Constraint\HttpResponse;

use GuzzleHttp\Psr7\Response;
use Pitchart\Phlunit\Constraint\HttpResponse\HasContentType;
use Pitchart\Phlunit\Constraint\HttpResponse\HasJsonContent;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class HasContentTypeTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var HasContentType
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new HasContentType('application/json');
    }

    public function test_succeeds_when_evaluates_matching_content_type()
    {
        $response = (new Response())->withHeader('Content-Type', 'application/json');

        $this->assertTrue($this->constraint->evaluate($response, '', true));
    }

    public function test_fails_when_evaluates_anything_but_matching_content_type()
    {
        $response = (new Response())->withHeader('Content-Type', 'text/html');

        $this->assertFalse($this->constraint->evaluate($response, '', true));
    }

    public function test_fails_for_anything_but_response_interface_instance()
    {
        $this->assertFalse($this->constraint->evaluate('toto', '', true));
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $response = (new Response())->withHeader('Content-Type', 'text/html');

        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that a HTTP Response with Content-Type 'text/html' has expected Content-Type 'application/json'.
EOF
            , $response);
    }


}
