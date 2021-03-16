<?php


namespace Tests\Pitchart\Phlunit\Checks;


use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Checks\GenericCheck;
use Pitchart\Phlunit\Checks\DateTimeCheck;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\IntegerCheck;
use Pitchart\Phlunit\Checks\JsonCheck;
use Pitchart\Phlunit\Checks\StringCheck;

class StringCheckTest extends TestCase
{
    /**
     * @param iterable $sut
     * @param string $method
     * @param array $arguments
     * @dataProvider methodsAreFulentProvider
     */
    public function test_has_fluent_methods(string $sut, string $method, array $arguments = [])
    {
        Check::that(call_user_func_array([Check::that($sut), $method], $arguments))
            ->isAnInstanceOf(StringCheck::class);
    }

    public function methodsAreFulentProvider()
    {
        yield from [
            'isEqualTo' => ['test', 'isEqualTo', ['test']],
            'isNotEqualTo' => ['test', 'isNotEqualTo', ['tdd']],
            'isEmpty' => ['', 'isEmpty'],
            'isNotEmpty' => ['test', 'isNotEmpty'],
            'isBlank' => ['', 'isBlank'],
            'isNotBlank' => ['test', 'isNotBlank'],
            'isGreaterThan' => ['test', 'isGreaterThan', ['tes']],
            'isGreaterThanOrEqualTo' => ['test', 'isGreaterThanOrEqualTo', ['test']],
            'isLessThan' => ['tes', 'isLessThan', ['test']],
            'isLessThanOrEqualTo' => ['test', 'isLessThanOrEqualTo', ['test']],
            'contains' => ['test', 'contains', ['e']],
            'startsWith' => ['test', 'startsWith', ['t']],
            'endsWith' => ['test', 'endsWith', ['t']],
            'isDigits' => ['42', 'isDigits'],
            'isLetters' => ['test', 'isLetters'],
            'isWhitespaces' => ["\t ", 'isWhitespaces'],
            'isHexadecimal' => ["A4", 'isHexadecimal'],
            'matches' => ['test', 'matches', ['/test/']],
            'ignoringCase' => ['', 'ignoringCase'],
            'respectingCase' => ['', 'respectingCase'],
        ];
    }

    /**
     * @param $value
     * @dataProvider emptyProvider
     */
    public function test_should_respect_empty($value)
    {
        Check::that($value)->isEmpty();
    }

    /**
     * @param $value
     */
    public function test_should_respect_not_empty()
    {
        Check::that('null')->isNotEmpty();
    }

    public function test_should_respect_comparisons()
    {
        Check::that('B')
            ->isGreaterThan('A')
            ->isGreaterThanOrEqualTo('B')
            ->isLessThan('Z')
            ->isLessThanOrEqualTo('B')
        ;
    }

    public function emptyProvider()
    {
        yield from [
            'null value' => [null],
            'empty string' => [''],
        ];
    }

    public function test_should_respect_equality()
    {
        Check::that('Batman')->isEqualTo('Batman');
    }

    public function test_should_respect_inequality()
    {
        Check::that('Batman')->isNotEqualTo('Robin');
    }

    public function test_respects_string_extractions()
    {
        Check::that('foobar')
            ->startsWith('foo')
            ->contains('o')
            ->endsWith('bar')
        ;
    }

    public function test_respects_string_extractions_case_insensitively()
    {
        Check::that('foobar')
            ->ignoringCase()
            ->isEqualTo('foObAr')
            ->isNotEqualTo('f00BAR')
            ->startsWith('foO')
            ->contains('O')
            ->endsWith('Bar')
        ;
    }

    public function test_can_switch_between_case_sensitive_and_insensitive()
    {
        Check::that('foobar')
            ->ignoringCase()
            ->startsWith('foO')
            ->respectingCase()
            ->startsWith('foo');
    }

    public function test_respects_digits_formats()
    {
        Check::that('123456')->isDigits();
    }

    public function test_respects_letters_formats()
    {
        Check::that('azerty')->isLetters();
    }

    public function test_checks_for_whitespaces()
    {
        Check::that("\t \n\r")->isWhitespaces();
    }

    public function test_assert_string_is_blank()
    {
        Check::that("\t \n\r")->isBlank();
    }

    public function test_assert_string_is_not_blank()
    {
        Check::that("\t a \n")->isNotBlank();
    }

    public function test_can_be_converted_to_datetime_assertion_using_format()
    {
        $check = Check::that('1983-0-28')->asDateTime('Y-m-d');

        Check::that($check)->isAnInstanceOf(DateTimeCheck::class);
    }

    public function test_integer_strings_can_switch_to_integer_checks()
    {
        $check = Check::that('42')->asInteger();

        Check::that($check)->isAnInstanceOf(IntegerCheck::class);
    }

    public function test_json_string_can_switch_to_json_checks()
    {
        $check = Check::that('{"name": "Batman"}')->asJson();

        Check::that($check)->isAnInstanceOf(JsonCheck::class);
    }

}