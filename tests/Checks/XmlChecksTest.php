<?php

namespace Tests\Pitchart\Phlunit\Checks;

use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\FluentCheck;
use Pitchart\Phlunit\Checks\XmlCheck;
use PHPUnit\Framework\TestCase;
use Tests\Pitchart\Phlunit\CheckTestCase;

class XmlChecksTest extends CheckTestCase
{

    public function test_is_accessed_from_string()
    {
        $check = Check::that($this->batman())->asXml();

        Check::that($check)->isAnInstanceOf(XmlCheck::class);
    }

    /**
     * @param XmlCheck $check
     * @param string $method
     * @param array $arguments
     *
     * @dataProvider fluentMethodsProvider
     */
    public function test_has_fluent_methods(XmlCheck $check, string $method, array $arguments)
    {
        Check::that(call_user_func_array([$check, $method], $arguments))
            ->isAnInstanceOf(XmlCheck::class);
    }

    public function fluentMethodsProvider()
    {
        $check = Check::that($this->batman())->asXml();
        $hero = file_get_contents(TEST_FILES_PATH.'hero.xsd');

        yield from [
            'isEqualTo' => [$check, 'isEqualTo', [$this->batman()]],
            'isNotEqualTo' => [$check, 'isNotEqualTo', [$this->superman()]],
            'isEqualToFileContent' => [$check, 'isEqualToFileContent', [TEST_FILES_PATH.'batman.xml']],
            'isNotEqualToFileContent' => [$check, 'isNotEqualToFileContent', [TEST_FILES_PATH.'superman.xml']],
            'matchesSchema' => [$check, 'matchesSchema', [$hero]],
        ];
    }

    public function test_verifies_sut_is_equal_to_an_xml_string()
    {
        (new XmlCheck($this->batman()))->isEqualTo($this->batman());
    }

    public function test_verifies_sut_is_not_equal_to_an_xml_string()
    {
        (new XmlCheck($this->batman()))->isNotEqualTo($this->superman());
    }

    public function test_verifies_sut_is_equal_to_an_xml_file_content()
    {
        (new XmlCheck($this->batman()))->isEqualToFileContent(TEST_FILES_PATH.'batman.xml');
    }

    public function test_verifies_sut_is_not_equal_to_an_file_content()
    {
        (new XmlCheck($this->batman()))->isNotEqualToFileContent(TEST_FILES_PATH.'superman.xml');
    }

    public function test_verifies_sut_satisfies_schema()
    {
        $schema = file_get_contents(TEST_FILES_PATH.'hero.xsd');
        (new XmlCheck($this->batman()))->matchesSchema($schema);
    }

    private function batman()
    {
        return '<?xml version="1.0" encoding="UTF-8" ?>
            <hero>
                <name>Batman</name>
                <city>Gotham City</city>
                <realName>Bruce Wayne</realName>
                <level>10</level>
            </hero>';
    }

    private function superman()
    {
        return '<?xml version="1.0" encoding="UTF-8" ?>
            <hero>
                <name>Superman</name>
                <city>Everywhere</city>
                <realName>Clark Kent</realName>
                <level>100</level>
            </hero>';
    }

    protected function checkClass(): FluentCheck
    {
        return Check::that($this->superman())->asXml();
    }


}
