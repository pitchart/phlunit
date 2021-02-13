<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\HttpResponse;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\FluentCheck;
use Pitchart\Phlunit\Constraint\HttpResponse\HeaderContains;
use Pitchart\Phlunit\Constraint\HttpResponse\HeaderIsEqualTo;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpHeaderCheck
 *
 * @package Pitchart\Phlunit\Checks\HttpResponse
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @template THeader
 * @implements FluentCheck<THeader>
 */
class HttpHeaderCheck implements FluentCheck
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var string
     */
    private $header;

    /**
     * HttpHeaderCheck constructor.
     *
     * @param ResponseInterface $response
     * @param string $header
     * @param array $value
     */
    public function __construct(ResponseInterface $response, string $header)
    {
        $this->response = $response;
        $this->header = $header;
    }

    public function isEqualTo(string $headerValue, string $message = ''): self
    {
        Assert::assertThat($this->response, new HeaderIsEqualTo($this->header, $headerValue), $message);
        return $this;
    }

    public function contains(string $headerPart, string $message = ''): self
    {
        Assert::assertThat($this->response, new HeaderContains($this->header, $headerPart), $message);
        return $this;
    }
}
