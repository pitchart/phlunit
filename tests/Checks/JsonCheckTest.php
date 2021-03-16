<?php


namespace Tests\Pitchart\Phlunit\Checks;


use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\FluentCheck;
use Pitchart\Phlunit\Checks\JsonCheck;
use Tests\Pitchart\Phlunit\CheckTestCase;

class JsonCheckTest extends CheckTestCase
{
    /**
     * @param string $sut
     * @param string $method
     * @param array $arguments
     * @dataProvider methodsAreFulentProvider
     */
    public function test_has_fluent_methods(string $sut, string $method, array $arguments = [])
    {
        Check::that(call_user_func_array([Check::that($sut)->asJson(), $method], $arguments))
            ->isAnInstanceOf(JsonCheck::class);
    }

    public function methodsAreFulentProvider()
    {
        $batman = file_get_contents(TEST_FILES_PATH.'batman.json');
        yield from [
            'isEqualTo' => ['{"name":"Batman"}', 'isEqualTo', [$batman]],
            'isNotEqualTo' => ['{"name":"Batman"}', 'isNotEqualTo', ['{"name":"Robin"}']],
            'isEqualToFileContent' => ['{"name":"Batman"}', 'isEqualToFileContent', [TEST_FILES_PATH.'batman.json']],
            'isNotEqualToFileContent' => ['{"name":"Batman"}', 'isNotEqualToFileContent', [TEST_FILES_PATH.'robin.json']],
            'matchesSchema' => ['{"name":"Batman"}', 'matchesSchema', [['type' => 'object', 'required' => ['name'], 'properties' => ['name' => ['type' => 'string']]],
            ]]
        ];
    }

    public function checkClass(): FluentCheck
    {
        return Check::that('{"name":"Batman"}')->asJson();
    }
}