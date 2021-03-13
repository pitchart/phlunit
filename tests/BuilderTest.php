<?php

namespace Tests\Pitchart\Phlunit;

use Pitchart\Phlunit\Check;
use Tests\Pitchart\Phlunit\Fixture\Address;
use Tests\Pitchart\Phlunit\Fixture\Contact;
use Tests\Pitchart\Phlunit\Fixture\ContactBuilder;
use PHPUnit\Framework\TestCase;
use Tests\Pitchart\Phlunit\Fixture\SimpleAddressBuilder;

/**
 * Class BuilderTest
 *
 * @package Tests\Pitchart\Phlunit
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 * @link http://www.natpryce.com/articles/000714.html
 */
class BuilderTest extends TestCase
{

    public function test_has_an_instance_variable_for_each_constructor_parameter()
    {
        $contact = ContactBuilder::create()->build();

        Check::that($contact)->isAnInstanceOf(Contact::class);
    }

    public function test_can_not_build_when_constructor_parameter_is_missing()
    {
        Check::thatCall([ContactBuilder::class, 'createWithMissingArguments'])
            ->throws(\InvalidArgumentException::class)
            ->that()->isDescribedBy('The following arguments key(s) must be provided with default value : [dateOfBirth]');
    }

    public function test_builds_when_some_provided_arguments_are_not_for_constructor_usage()
    {
        $contact = ContactBuilder::createWithMoreArgumentsThanConstructorNeeds()->build();

        Check::that($contact)->isAnInstanceOf(Contact::class);
    }

    public function test_has_a_build_method_that_creates_a_new_object_using_the_values_in_its_instance_variables()
    {
        $batman = ContactBuilder::create()->build();
        $anotherBatman = ContactBuilder::create()->build();

        Check::that($batman)->isNotEqualTo($anotherBatman);
    }

    public function test_initialises_its_instance_variables_to_commonly_used_or_safe_values()
    {
        $batman = ContactBuilder::create()->build();

        Check::that($batman->getFirstname())->isEqualTo('Bruce')
            ->andThat($batman->getLastname())->isEqualTo('Wayne')
            ->andThat($batman->getDateOfBirth())->isSameDayAs(new \DateTime())
        ;
    }

    public function test_has_fluent_public_methods_for_overriding_the_values_in_its_instance_variables()
    {
        $builder = ContactBuilder::create();

        $spiderman = $builder->withFirstname('Peter')->andLastname('Parker')->build();

        Check::that($spiderman->getFirstname())->isEqualTo('Peter')
            ->andThat($spiderman->getLastname())->isEqualTo('Parker')
        ;
    }

    public function test_can_only_override_one_argument_at_a_time()
    {
        $builder = ContactBuilder::create();

        Check::thatCall([$builder, 'withFirstname'])->with('spiderman', 'batman', 'superman')
            ->throws(\InvalidArgumentException::class)
            ->that()->isDescribedBy("There must be exactly one argument for method 'withFirstname', 3 given");
    }

    public function test_can_not_call_method_to_override_non_existing_argument()
    {
        $builder = ContactBuilder::create();

        Check::thatCall([$builder, 'withName'])->with('spiderman')
            ->throws(\InvalidArgumentException::class)
            ->that()->isDescribedBy('There is no argument name');
    }

    public function test_can_not_call_random_method()
    {
        $builder = ContactBuilder::create();

        Check::thatCall([$builder, 'notSoRandomMethodName'])->with('spiderman')
            ->throws(\BadMethodCallException::class)
            ->that()->isDescribedBy('Method notSoRandomMethodName is not supported. Supported methods are with*() and and*()');
    }

    public function test_can_build_using_a_static_factory_method()
    {
        $builder = SimpleAddressBuilder::create();

        $address = $builder->build();

        Check::that($address)->isAnInstanceOf(Address::class);
    }
}
