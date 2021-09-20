<?php

/**
 * TechDivision\Import\Serializer\Csv\ValueCsvSerializerTest
 *
* PHP version 7
*
* @author    Tim Wagner <t.wagner@techdivision.com>
* @copyright 2021 TechDivision GmbH <info@techdivision.com>
* @license   https://opensource.org/licenses/MIT
* @link      https://github.com/techdivision/import-serializer-csv
* @link      http://www.techdivision.com
*/

namespace TechDivision\Import\Serializer\Csv;

/**
 * Test class for the SQL statement implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */
class ValueCsvSerializerTest extends AbstractSerializerTest
{

    /**
     * The CSV value serializer we want to test.
     *
     * @var \TechDivision\Import\Serializer\Csv\ValueCsvSerializer
     */
    protected $valueCsvSerializer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp(): void
    {

        // create and initialize the CSV value serializer
        $this->valueCsvSerializer = new ValueCsvSerializer();
        $this->valueCsvSerializer->init($this->getMockSerializerConfiguration());
    }

    /**
     * Tests the serialization of the values in the column `attribute_option_values` which contains a
     * list with the attributes available option values and has to serialized/unserialized two times.
     *
     * @return void
     * @attributes
     */
    public function testSerializeAttributeOptionValuesWithSuccess()
    {

        // initialize the array containing the unserialized value
        $unserialized = array('Ventilsicherung von 2" bis 8", nur in geschlossener Position');

        // initialize the serialization result
        $expectedResult = '"""Ventilsicherung von 2"""" bis 8"""", nur in geschlossener Position"""';

        // serialize the value two times
        $serialized = $this->valueCsvSerializer->serialize(array($this->valueCsvSerializer->serialize($unserialized)));

        // assert that the result matchtes the expected result
        $this->assertEquals($expectedResult, $serialized);

        // unserialize the serialized value and query whether or not we've the source value
        $values = current($this->valueCsvSerializer->unserialize($serialized));
        $this->assertEquals($unserialized, $this->valueCsvSerializer->unserialize($values));
    }

    /**
     * Tests the serialization of the values in the column `attribute_option_values` which contains a
     * list with the attributes available option values and has to serialized/unserialized two times.
     *
     * @return void
     * @attributes
     */
    public function testSerializeAttributeOptionValuesWithExampleValues()
    {

        // initialize the array containing the unserialized value
        $unserialized = array(
            'bla',
            'bla "blub"',
            'bla, blub',
            'bla, "blub" bla',
            'bla "blub, bla"'
        );

        // initialize the serialization result
        $firstResult = 'bla,"bla ""blub""","bla, blub","bla, ""blub"" bla","bla ""blub, bla"""';
        $secondResult = '"bla,""bla """"blub"""""",""bla, blub"",""bla, """"blub"""" bla"",""bla """"blub, bla"""""""';

        // serialize and assert that the result matchtes the expected result two times
        $this->assertEquals($firstResult, $first = $this->valueCsvSerializer->serialize($unserialized));
        $this->assertEquals($secondResult, $serialized = $this->valueCsvSerializer->serialize(array($first)));

        // unserialize the serialized value and query whether or not we've the source value
        $values = current($this->valueCsvSerializer->unserialize($serialized));
        $this->assertEquals($unserialized, $this->valueCsvSerializer->unserialize($values));
    }

    /**
     * Tests the unserialization of the values in the column `attribute_option_values` which contains a
     * list with the attributes available option values and has to unserialized two times.
     *
     * @return void
     * @attributes
     */
    public function testUnserializeAttributeOptionValuesWithExampleValues()
    {

        // initialize the array containing the unserialized value
        $unserialized = array(
            'bla',
            'bla "blub"',
            'bla, blub',
            'bla, "blub" bla',
            'bla "blub, bla"'
        );

        // initialize the serialization result
        // optional: '"""bla"",""bla """"blub"""""",""bla, blub"",""bla, """"blub"""" bla"",""bla """"blub, bla"""""""';
        $secondResult = '"bla,""bla """"blub"""""",""bla, blub"",""bla, """"blub"""" bla"",""bla """"blub, bla"""""""';

        // unserialize the serialized value and query whether or not we've the source value
        $values = current($this->valueCsvSerializer->unserialize($secondResult));
        $this->assertEquals($unserialized, $this->valueCsvSerializer->unserialize($values));
    }

    /**
     * Tests if the serialize() method returns the serialized value.
     *
     * @return void
     * @attributes
     */
    public function testSerializeAttributeOptionValuesWithSingleQuotes()
    {

        // initialize the array containing the unserialized value
        $unserialized = array(
            'Aushang-Set "Allgemeine Betriebsanweisungen für Tätigkeiten mit Gefahrstoffen"',
            'Aushang "ADR-Transportplaner"',
            'Damit nicht nur Ihre Räume, sondern auch Ihre Reinigungspläne "sauber" sind.'
        );

        // initialize the expected result
        $expectedResult = '"""Aushang-Set """"Allgemeine Betriebsanweisungen für Tätigkeiten mit Gefahrstoffen"""""",""Aushang """"ADR-Transportplaner"""""",""Damit nicht nur Ihre Räume, sondern auch Ihre Reinigungspläne """"sauber"""" sind."""';

        // serialize the value two times
        $serialized = $this->valueCsvSerializer->serialize(array($this->valueCsvSerializer->serialize($unserialized)));

        // assert that the result matchtes the expected result
        $this->assertEquals($expectedResult, $serialized);

        // unserialize the serialized value and query whether or not we've the source value
        $values = current($this->valueCsvSerializer->unserialize($serialized));
        $this->assertEquals($unserialized, $this->valueCsvSerializer->unserialize($values));
    }

    /**
     * Tests the (un-)serialization of the values in the column `configurable_variations` which contains a
     * list with the SKU and the configurable attributes option values and has to unserialized four times.
     *
     * @return void
     * @products
     */
    public function testSerializeConfigurableVariationsWithExampleValues()
    {

        // initialize the inital list
        $vars = array(
            array(
                array('sku','12345'),
                array('color','bla'),
                array('size','blub|diblub')),
            array(
                array('sku','12346'),
                array('color','bla "blub|diblub"'),
                array('size','bla, blub')),
            array(
                array('sku','12347'),
                array('color','bla, = "blub" bla'),
                array('size','bla = | "blub, bla|diblub" du')
            )
        );

        // initialize the expected serialization result
        $firstResult = '"sku=12345,color=bla,size=blub|diblub"|"sku=12346,""color=""""bla """"""""blub|diblub"""""""""""""",""size=""""bla, blub"""""""|"sku=12347,""color=""""bla, = """"""""blub"""""""" bla"""""",""size=""""bla = | """"""""blub, bla|diblub"""""""" du"""""""';
        $secondResult = '"""sku=12345,color=bla,size=blub|diblub""|""sku=12346,""""color=""""""""bla """"""""""""""""blub|diblub"""""""""""""""""""""""""""",""""size=""""""""bla, blub""""""""""""""|""sku=12347,""""color=""""""""bla, = """"""""""""""""blub"""""""""""""""" bla"""""""""""",""""size=""""""""bla = | """"""""""""""""blub, bla|diblub"""""""""""""""" du"""""""""""""""';


        // initialize the array with the values that have to be serialized
        $unserialized = array();

        // prepare the values
        foreach ($vars as $var) {
            // initialize an array with the elements
            $loop1 = array();
            // serialize them with a (=) as separator
            foreach ($var as $el) {
                $loop1[] = $this->valueCsvSerializer->serialize($el, '=');
            }
            // serialize the attributes of ONE configurable variation with a (,) as separator
            $unserialized[] = $this->valueCsvSerializer->serialize($loop1);
        }

        // assert that the (un-)serialization contains the source values/the expected result
        $this->assertEquals($firstResult, $first = $this->valueCsvSerializer->serialize($unserialized, '|'));
        $this->assertEquals($secondResult, $serialized = $this->valueCsvSerializer->serialize(array($first)));

        // unserialize the serialized value and query whether or not we've the source value
        $values = current($this->valueCsvSerializer->unserialize($serialized));
        $this->assertEquals($unserialized, $variations = $this->valueCsvSerializer->unserialize($values, '|'));

        // validate that we've the single values when we desrialize the values
        foreach ($variations as $key => $variation) {
            $keyValuePair = $this->valueCsvSerializer->unserialize($variation);
            foreach ($keyValuePair as $k => $pairs) {
                $this->assertEquals($vars[$key][$k], $this->valueCsvSerializer->unserialize($pairs, '='));
            }
        }
    }

    /**
     * Test (un-)serialization process of a value for the column `configurable_variations` without quotes.
     *
     * @return void
     * @products
     */
    public function testSerializeConfigurableVariations()
    {

        // initialize the array with the values that have to be serialized
        $unserialized = array(
            'sku=configurable-test-Black-55 cm,color=Black,size=55 cm',
            'sku=configurable-test-Black-XS,color=Black,size=XS',
            'sku=configurable-test-Blue-XS,color=Blue,size=XS',
            'sku=configurable-test-Blue-55 cm,color=Blue,size=55 cm'
        );

        // initialize the expected serialization result
        $expectedResult = '"sku=configurable-test-Black-55 cm,color=Black,size=55 cm"|sku=configurable-test-Black-XS,color=Black,size=XS|sku=configurable-test-Blue-XS,color=Blue,size=XS|"sku=configurable-test-Blue-55 cm,color=Blue,size=55 cm"';

        // assert that the (un-)serialization contains the source values/the expected result
        $this->assertEquals($expectedResult, $serialized = $this->valueCsvSerializer->serialize($unserialized, '|'));
        $this->assertEquals($unserialized, $this->valueCsvSerializer->unserialize($serialized, '|'));
    }

    /**
     * Test (un-)serialization process of a value for the column `configurable_variations` with single quotes.
     *
     * @return void
     * @products
     */
    public function testSerializeConfigurableVariationsWithOneValueAndQuotes()
    {

        // initialize the array with the values that have to be serialized
        $unserialized = array(
            'sku=12345,dmeu_lockingmechanism="Anschlussgewinde: 3/4"'
        );

        // initialize the expected serialization result
        $expectedResult = '"sku=12345,dmeu_lockingmechanism=""Anschlussgewinde: 3/4"""';

        // assert that the (un-)serialization contains the source values/the expected result
        $this->assertEquals($expectedResult, $serialized = $this->valueCsvSerializer->serialize($unserialized, '|'));
        $this->assertEquals($unserialized, $this->valueCsvSerializer->unserialize($serialized, '|'));
    }

    /**
     * Test the (un-)serialization for values in the column `configurable_variations` for
     * the product import which contains quotes and has manually been downgraded.
     *
     * @return void
     * @products
     */
    public function testSerializeMultipleConfigurableVariationsWithQuotes()
    {

        // initialize the array with the values that have to be serialized
        $unserialized = array(
            array(
                'sku=12345',
                'dmeu_lockingmechanism="Anschlussgewinde: 3/4"'
            ),
            array(
                'sku=12346',
                'dmeu_lockingmechanism="Anschlussgewinde: 2/4"'
            )
        );

        // initialize the expected serialization result
        $expectedResult = '"sku=12345,""dmeu_lockingmechanism=""""Anschlussgewinde: 3/4"""""""|"sku=12346,""dmeu_lockingmechanism=""""Anschlussgewinde: 2/4"""""""';

        // serialize the values
        $vals = array();
        foreach ($unserialized as $configurable) {
            $vals[] = $this->valueCsvSerializer->serialize($configurable);
        }

        // assert that the serialization contains the expected result
        $this->assertEquals($expectedResult, $serialized = $this->valueCsvSerializer->serialize($vals, '|'));

        // unserialize the serialized value
        $attributes = array();
        foreach ($this->valueCsvSerializer->unserialize($serialized, '|') as $configurable) {
            $attributes[] = $this->valueCsvSerializer->unserialize($configurable);
        }

        // assert that the unserialization contains the source values
        $this->assertEquals($unserialized, $attributes);
    }

    /**
     * Test the unserialization for values in the column `configurable_variations` for
     * the product import which contains quotes and has manually been downgraded.
     *
     * @return
     * @products
     */
    public function testUnserializeMultipleConfigurableVariationsWithQuotesManuallyDowngraded()
    {

        // initialize the array with the values that have to be serialized
        $unserialized = array(
            array(
                'sku=12345',
                'dmeu_lockingmechanism="Anschlussgewinde: 3/4"'
            ),
            array(
                'sku=12346',
                'dmeu_lockingmechanism="Anschlussgewinde: 2/4"'
            )
        );

        // initialize the expected serialization result
        $expectedResult = '"sku=12345,dmeu_lockingmechanism=""Anschlussgewinde: 3/4"""|"sku=12346,dmeu_lockingmechanism=""Anschlussgewinde: 2/4"""';

        // unserializa the serialized value
        $vals = array();
        foreach ($this->valueCsvSerializer->unserialize($expectedResult, '|') as $configurable) {
            $vals[] = $this->valueCsvSerializer->unserialize($configurable);
        }

        // assert that the unserialization contains the source values
        $this->assertEquals($unserialized, $vals);
    }

    /**
     * Test the serialization for values in a EAV attribute column of type `multiselect`
     * for the product import which contains quotes.
     *
     * @return
     * @products
     */
    public function testSerializeMultiselectValuesWithQuotes()
    {


        // initialize the array with the values that have to be serialized
        $unserialized = array(
            '"lorem", ipsum "dolor" somit',
            'Sic transit gloria mundi'
        );

        // initialize the expected serialization result
        $expectedResult = '"""""""lorem"""", ipsum """"dolor"""" somit""|""Sic transit gloria mundi"""';

        // assert that the serialization has the expected result
        $this->assertEquals($expectedResult, $this->valueCsvSerializer->serialize(array($this->valueCsvSerializer->serialize($unserialized, '|'))));

        // unserializa the serialized value
        $vals = array();
        foreach ($this->valueCsvSerializer->unserialize($expectedResult) as $v) {
            $vals = array_merge($vals, $this->valueCsvSerializer->unserialize($v, '|'));
        }

        // assert that the unserialization contains the source values
        $this->assertEquals($unserialized, $vals);
    }

    /**
     * Test the serialization for values in a EAV attribute column of type `multiselect`
     * for the product import which contains quotes and a pipe.
     *
     * @return
     * @products
     */
    public function testSerializeMultiselectValuesWithSingleQuotesAndPipe()
    {

        // initialize the array with the values that have to be serialized
        $unserialized = array(
            '"lorem", ipsum "dolor" somit | Sic transit gloria mundi'
        );

        // initialize the expected serialization result
        $expectedResult = '"""""""lorem"""", ipsum """"dolor"""" somit | Sic transit gloria mundi"""';

        // assert that the serialization has the expected result
        $this->assertEquals($expectedResult, $this->valueCsvSerializer->serialize(array($this->valueCsvSerializer->serialize($unserialized, '|'))));

        // unserializa the serialized value
        $vals = array();
        foreach ($this->valueCsvSerializer->unserialize($expectedResult) as $v) {
            $vals = array_merge($vals, $this->valueCsvSerializer->unserialize($v, '|'));
        }

        // assert that the unserialization contains the source values
        $this->assertEquals($unserialized, $vals);
    }

    /**
     * Test the serialization for values in a EAV attribute column of type `multiselect`
     * for the product import which contains quotes and pipes.
     *
     * @return
     * @products
     */
    public function testSerializeMultiselectValuesAndQuotesAndPipes()
    {

        // initialize the array with the values that have to be serialized
        $unserialized = array(
            '"lorem", ipsum "dolor" somit | Sic transit gloria mundi 1',
            '"lorem", ipsum "dolor" somit | Sic transit gloria mundi 2'
        );

        // initialize the expected serialization result
        $expectedResult = '"""""""lorem"""", ipsum """"dolor"""" somit | Sic transit gloria mundi 1""|""""""lorem"""", ipsum """"dolor"""" somit | Sic transit gloria mundi 2"""';

        // assert that the serialization has the expected result
        $this->assertEquals($expectedResult, $this->valueCsvSerializer->serialize(array($this->valueCsvSerializer->serialize($unserialized, '|'))));

        // unserializa the serialized value
        $vals = array();
        foreach ($this->valueCsvSerializer->unserialize($expectedResult) as $v) {
            $vals = array_merge($vals, $this->valueCsvSerializer->unserialize($v, '|'));
        }

        // assert that the unserialization contains the source values
        $this->assertEquals($unserialized, $vals);
    }

    /**
     * Test the unserialization for values in a EAV attribute column for the product import
     * which contains a single value, e. g. description.
     *
     * @return void
     * @products
     */
    public function testUnserializeProductAttributeOptionValueWithSuccess()
    {

        // initialize the value we want to unserialized
        $serialized = '"Ventilsicherung von 2"" bis 8"", nur in geschlossener Position"';

        // initialize the expected result
        $expectedResult = array('Ventilsicherung von 2" bis 8", nur in geschlossener Position');

        // unserialize the value and assert the expected result has been returned
        $this->assertEquals($expectedResult, $this->valueCsvSerializer->unserialize($serialized));
    }

    /**
     * Tests if the serialize() method returns the serialized value.
     *
     * @return void
     */
    public function testSerializeAttributeOptionsWithQuotesAndSuccess()
    {
        $this->assertEquals('"ac_\01",ov_01', $serialized = $this->valueCsvSerializer->serialize($unserialized = array('ac_\\01','ov_01')));
        $this->assertEquals($unserialized, $this->valueCsvSerializer->unserialize($serialized));
    }

    /**
     * Tests if the unserialize() method returns the serialized value.
     *
     * @return void
     */
    public function testUnserializeSerializeWithSuccess()
    {
        $this->assertEquals(array('ac_,01','ov_01'), $unserialized = $this->valueCsvSerializer->unserialize($serialized = '"ac_,01",ov_01'));
        $this->assertEquals($serialized, $this->valueCsvSerializer->serialize($unserialized));
    }

    /**
     * Tests if the unserialize() method returns the serialized value for a multiselect attribute which values that contains commas.
     *
     * @return void
     */
    public function testUnserializeMultiselectValueWithValuesContainingCommasWithSuccess()
    {
        $this->assertEquals(array('attr1=ac_,01|ac_,02','attr2=ov_01'), $this->valueCsvSerializer->unserialize('"attr1=ac_,01|ac_,02","attr2=ov_01"'));
    }
}
