<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\HttpResponse\HttpHeaderCheck;
use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;
use Pitchart\Phlunit\Constraint\HttpResponse\HasContentType;
use Pitchart\Phlunit\Constraint\HttpResponse\HasHeader;
use Pitchart\Phlunit\Constraint\HttpResponse\HasReason;
use Pitchart\Phlunit\Constraint\HttpResponse\HasStatusCode;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseCheck
 *
 * @package Pitchart\Phlunit\Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @implements FluentCheck<ResponseInterface>
 */
class ResponseCheck implements FluentCheck
{
    use TypeCheck, ConstraintCheck, WithMessage;

    /**
     * @var ResponseInterface
     */
    private $value;

    /**
     * ResponseCheck constructor.
     *
     * @param ResponseInterface $value
     */
    public function __construct(ResponseInterface $value)
    {
        $this->value = $value;
    }

    public function hasHeader(string $header): self
    {
        Assert::assertThat($this->value, new HasHeader($header), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function whoseHeader(string $header): HttpHeaderCheck
    {
        $this->hasHeader($header);
        return new HttpHeaderCheck($this->value, $header);
    }

    /**
     * @param int|string $value
     *
     * @return ResponseCheck
     */
    public function hasStatus($value): self
    {
        Assert::assertThat($this->value, new HasStatusCode($value), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function hasReason(string $reason): self
    {
        Assert::assertThat($this->value, new HasReason($reason), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isJson(): self
    {
        Assert::assertThat($this->value, new HasContentType('application/json'), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isHtml(): self
    {
        Assert::assertThat($this->value, new HasContentType('text/html'), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isXml(): self
    {
        Assert::assertThat($this->value, new HasContentType('application/xml'), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function asJson(): JsonCheck
    {
        $content = $this->value->getBody()->getContents();
        Assert::assertJson($content);
        return new JsonCheck($content);
    }

    public function asXml(): XmlCheck
    {
        $content = $this->value->getBody()->getContents();
        return new XmlCheck($content);
    }
}
