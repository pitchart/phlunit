<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\HttpResponse;

use PHPUnit\Framework\Constraint\Constraint;
use Psr\Http\Message\ResponseInterface;

class HeaderIsEqualTo extends Constraint
{
    use WithHeaderResponseExporter;

    /**
     * @var string
     */
    private $header;

    /**
     * @var string
     */
    private $value;

    /**
     * HeaderIsEqualTo constructor.
     *
     * @param string $header
     * @param string $value
     */
    public function __construct(string $header, string $value)
    {
        $this->header = $header;
        $this->value = $value;
    }

    protected function matches($other): bool
    {
        if ($other instanceof ResponseInterface
            && $other->hasHeader($this->header)
        ) {
            return $other->getHeaderLine($this->header) === $this->value;
        }
        return false;
    }

    /**
     * @return string
     */
    protected function failureDescription($other): string
    {
        return $this->exporter()->export($other) . ' ' . $this->toString();
    }


    public function toString(): string
    {
        return \sprintf(" has value '%s' for header '%s'", $this->value, $this->header);
    }
}
