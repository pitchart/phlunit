<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\HttpResponse;

use PHPUnit\Framework\Constraint\Constraint;
use Psr\Http\Message\ResponseInterface;

class HasContentType extends Constraint
{
    /**
     * @var string
     */
    private $contentType;

    /**
     * HasContentType constructor.
     *
     * @param string $contentType
     */
    public function __construct($contentType)
    {
        $this->contentType = $contentType;
    }

    protected function matches($other): bool
    {
        if ($other instanceof ResponseInterface) {
            return $other->hasHeader('Content-Type')
                && ($other->getHeaderLine('Content-Type') === $this->contentType);
        }
        return false;
    }

    public function toString(): string
    {
        return \sprintf("has expected Content-Type '%s'", $this->contentType);
    }

    /**
     * @return string
     */
    protected function failureDescription($other): string
    {
        $contentType = $other instanceof ResponseInterface ? $other->getHeaderLine('Content-Type') : (string) $other;
        return 'a HTTP Response with Content-Type \'' . $contentType . '\' ' . $this->toString();
    }
}
