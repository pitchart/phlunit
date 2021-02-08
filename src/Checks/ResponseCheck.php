<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\HttpResponse\HttpHeaderCheck;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Constraint\HttpResponse\HasContentType;
use Pitchart\Phlunit\Constraint\HttpResponse\HasHeader;
use Pitchart\Phlunit\Constraint\HttpResponse\HasReason;
use Pitchart\Phlunit\Constraint\HttpResponse\HasStatusCode;
use Psr\Http\Message\ResponseInterface;

class ResponseCheck implements FluentCheck
{
    use TypeCheck;

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

    public function hasHeader(string $header)
    {
        Assert::assertThat($this->value, new HasHeader($header));
        return $this;
    }

    public function whoseHeader(string $header)
    {
        $this->hasHeader($header);
        return new HttpHeaderCheck($this->value, $header, $this->value->getHeader($header));
    }

    public function hasStatus($value)
    {
        Assert::assertThat($this->value, new HasStatusCode($value));
        return $this;
    }

    public function hasReason(string $reason)
    {
        Assert::assertThat($this->value, new HasReason($reason));
        return $this;
    }

    public function isJson()
    {
        Assert::assertThat($this->value, new HasContentType('application/json'));
        return $this;
    }

    public function isHtml()
    {
        Assert::assertThat($this->value, new HasContentType('text/html'));
        return $this;
    }

    public function isXml()
    {
        Assert::assertThat($this->value, new HasContentType('application/xml'));
        return $this;
    }
}
