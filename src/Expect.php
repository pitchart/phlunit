<?php declare(strict_types=1);


namespace Pitchart\Phlunit;

use PHPUnit\Framework\TestCase;

final class Expect
{
    /**
     * @var TestCase
     */
    private $testCase;

    /**
     * Expect constructor.
     *
     * @param TestCase $testCase
     */
    private function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    public static function after(TestCase $testCase)
    {
        return new self($testCase);
    }

    public function anException(string $class = \Exception::class): self
    {
        $this->testCase->expectException($class);

        return $this;
    }

    public function describedBy(string $message): self
    {
        $this->testCase->expectExceptionMessage($message);

        return $this;
    }

    public function havingCode(int $code): self
    {
        $this->testCase->expectExceptionCode($code);

        return $this;
    }

    public function aDeprecation(): self
    {
        $this->testCase->expectDeprecation();

        return $this;
    }

    public function aNotice(): self
    {
        $this->testCase->expectNotice();

        return $this;
    }

    public function aWarning(): self
    {
        $this->testCase->expectWarning();

        return $this;
    }

    public function anError(): self
    {
        $this->testCase->expectError();

        return $this;
    }

    public function describedByAMessageMatching(string $pattern): self
    {
        $this->testCase->expectDeprecationMessageMatches($pattern);

        return $this;
    }

    public function describedByAMessageContaining(string $part): self
    {
        $this->testCase->expectDeprecationMessageMatches('/' . \preg_quote($part) . '/');

        return $this;
    }
}
