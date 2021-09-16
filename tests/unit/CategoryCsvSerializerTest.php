<?php

/**
 * TechDivision\Import\Serializer\Csv\CategoryeCsvSerializerTest
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
class CategoryCsvSerializerTest extends AbstractSerializerTest
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
    protected function setUp()
    {

        // create and initialize the CSV value serializer
        $this->valueCsvSerializer = new ValueCsvSerializer();
        $this->valueCsvSerializer->init($this->getMockSerializerConfiguration());
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    /* public function testSerializeCategoryNameTestTest()
    {

        $this->assertEquals(
            '"Default Category/Etiketten und Prüfplaketten/Prüfplaketten/Prüfplaketten ""Nächster Prüftermin / Geprüft"""',
            $this->valueCsvSerializer->serialize(array('Default Category/Etiketten und Prüfplaketten/Prüfplaketten/Prüfplaketten "Nächster Prüftermin / Geprüft"'))
        );
    } */

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    public function testSerializeCategoryNameTestTest0()
    {

        $this->assertEquals(
            '"Default Category"/"Etiketten und Prüfplaketten"',
            $this->valueCsvSerializer->serialize(array('Default Category', 'Etiketten und Prüfplaketten'), '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    public function testSerializeCategoryNameTestTest1()
    {

        $this->assertEquals(
            '"""Default Category""/""Etiketten und Prüfplaketten"""',
            $this->valueCsvSerializer->serialize(array(
                $this->valueCsvSerializer->serialize(array('Default Category', 'Etiketten und Prüfplaketten'), '/')
            ))
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    public function testSerializeCategoryNameTestTest21()
    {

        $this->assertEquals(
            '"Default Category"/"Etiketten und Prüfplaketten"/Prüfplaketten/"Prüfplaketten ""Nächster Prüftermin / Geprüft"" 2"',
            $this->valueCsvSerializer->serialize(array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin / Geprüft" 2'), '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    public function testSerializeCategoryNameTestTest22()
    {

        $this->assertEquals(
            '"""Default Category""/""Etiketten und Prüfplaketten""/Prüfplaketten/""Prüfplaketten """"Nächster Prüftermin / Geprüft"""" 2"""',
            $this->valueCsvSerializer->serialize(array(
                $this->valueCsvSerializer->serialize(array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin / Geprüft" 2'), '/')
            ))
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    public function testUnserializeCategoryNameTestTest22()
    {


        $result = $this->valueCsvSerializer->unserialize('"""Default Category""/""Etiketten und Prüfplaketten""/Prüfplaketten/""Prüfplaketten """"Nächster Prüftermin / Geprüft"""" 2"""');


        $this->assertEquals(
            array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin / Geprüft" 2'),
            $this->valueCsvSerializer->unserialize(array_pop($result), '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    public function testSerializeCategoryNameTestTest23()
    {

        $this->assertEquals(
            '"""Default Category""/""Etiketten und Prüfplaketten""/Prüfplaketten/""Prüfplaketten """"Nächster Prüftermin / Geprüft"""""""',
            $this->valueCsvSerializer->serialize(array(
                $this->valueCsvSerializer->serialize(array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin / Geprüft"'), '/')
            ))
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    /* public function testUnserializeCategoriesWithSlashAndDoubleQuotes22()
    {
        $this->assertEquals(
            array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin / Geprüft" 2'),
            $this->valueCsvSerializer->unserialize('Default Category/Etiketten und Prüfplaketten/Prüfplaketten/Prüfplaketten ""Nächster Prüftermin / Geprüft"" 2"', '/')
        );
    } */

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    /* public function testUnserializeCategoryNameTestTest()
    {
        $this->assertEquals(
            array('Default Category/Etiketten und Prüfplaketten/Prüfplaketten/Prüfplaketten "Nächster Prüftermin / Geprüft"'),
            $this->valueCsvSerializer->unserialize('"Default Category/Etiketten und Prüfplaketten/Prüfplaketten/Prüfplaketten ""Nächster Prüftermin / Geprüft"""')
        );
    } */

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    public function testUnserializeCategoryNameWithSlashAndDoubleQuotes()
    {
        $this->assertEquals(
            array('Prüfplaketten "Nächster Prüftermin / Geprüft"'),
            $this->valueCsvSerializer->unserialize('"Prüfplaketten ""Nächster Prüftermin / Geprüft"""')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains double qoutes and a slash.
     *
     * @return void
     */
    public function testUnserializeCategoriesWithSlashAndDoubleQuotes()
    {
        $this->assertEquals(
            array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin / Geprüft"'),
            $this->valueCsvSerializer->unserialize('Default Category/Etiketten und Prüfplaketten/Prüfplaketten/"Prüfplaketten ""Nächster Prüftermin / Geprüft"""', '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains qoutes.
     *
     * @return void
     */
    public function testUnserializeCategoriesWithQuotes()
    {
        $this->assertEquals(
            array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin Geprüft"'),
            $this->valueCsvSerializer->unserialize('Default Category/Etiketten und Prüfplaketten/Prüfplaketten/Prüfplaketten "Nächster Prüftermin Geprüft"', '/')
         );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains qoutes.
     *
     * @return void
     */
    public function testUnserializeCategoriesWithQuotesAroundSlash()
    {
        $this->assertEquals(
            array('Default Category', '"Meine/Euere"', 'Produkte'),
            $this->valueCsvSerializer->unserialize('Default Category/"""Meine/Euere"""/Produkte', '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains qoutes.
     *
     * @return void
     */
    public function testUnserializeCategoriesWithQuotesAndSlash()
    {
        $this->assertEquals(
            array('Default Category', 'Meine', '"Unsere"', 'Produkte'),
            $this->valueCsvSerializer->unserialize('Default Category/Meine/"""Unsere"""/Produkte', '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains a slash.
     *
     * @return void
     */
    public function testUnserializeCategoriesFromAColumnWithSlash()
    {

        // first extract the the column value (simulating what happens when column will be extracted with $this->getValue(ColumnKeys::PATH) from the CSV file)
        $column = $this->valueCsvSerializer->unserialize('"Default Category/Sicherheitskennzeichnung und Rettungszeichen/Gefahrstoffkennzeichnung/""Gefahrstoffetiketten gemäß GHS-/CLP"""');

        $this->assertEquals(
            array('Default Category', 'Sicherheitskennzeichnung und Rettungszeichen', 'Gefahrstoffkennzeichnung', 'Gefahrstoffetiketten gemäß GHS-/CLP'),
            $this->valueCsvSerializer->unserialize(array_shift($column), '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a string with categories that contains a slash in a middle element.
     *
     * @return void
     */
    public function testUnserializeCategoriesFromAColumnWithSlashInMiddleElement()
    {

        // first extract the the column value (simulating what happens when column will be extracted with $this->getValue(ColumnKeys::PATH) from the CSV file)
        $column = $this->valueCsvSerializer->unserialize('"Default Category/""Deine/Meine""/Produkte/Subkategorie"');

        $this->assertEquals(
            array('Default Category', 'Deine/Meine', 'Produkte', 'Subkategorie'),
            $this->valueCsvSerializer->unserialize(array_shift($column), '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a column with categories that contains a slash within qoutes.
     *
     * @return void
     */
    public function testUnserializeCategoriesFromAColumnWithSlashWithinQuotes()
    {

        // first extract the the column value (simulating what happens when column will be extracted with $this->getValue(ColumnKeys::PATH) from the CSV file)
        $column = $this->valueCsvSerializer->unserialize('"Default Category/Etiketten und Prüfplaketten/Prüfplaketten/""Prüfplaketten """"Nächster Prüftermin / Geprüft"""""""');

        // explode the columns
        $this->assertEquals(
            array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin / Geprüft"'),
            $this->valueCsvSerializer->unserialize(array_shift($column), '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a column with categories that contains a slash within two time qoutes.
     *
     * @return void
     */
    public function testUnserializeCategoriesFromAColumnWithSlashWithinTwoTimeQuotes()
    {

        // first extract the the column value (simulating what happens when column will be extracted with $this->getValue(ColumnKeys::PATH) from the CSV file)
        $column = $this->valueCsvSerializer->unserialize('"Default Category/""""""Etiketten und Prüfplaketten""""""/Prüfplaketten/""Prüfplaketten """"Nächster Prüftermin / Geprüft"""""""');

        // explode the columns
        $this->assertEquals(
            array('Default Category', '"Etiketten und Prüfplaketten"', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin / Geprüft"'),
            $this->valueCsvSerializer->unserialize(array_shift($column), '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a column with categories that contains a slash within qoutes.
     *
     * @return void
     */
    public function testUnserializeCategoriesFromAColumnWithSlashAndQuotes()
    {

        // first extract the the column value (simulating what happens when column will be extracted with $this->getValue(ColumnKeys::PATH) from the CSV file)
        $column = $this->valueCsvSerializer->unserialize('"Default Category/Etiketten und Prüfplaketten/Prüfplaketten/""Prüfplaketten / """"Nächster Prüftermin Geprüft"""""""');

        // explode the columns
        $this->assertEquals(
            array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten / "Nächster Prüftermin Geprüft"'),
            $this->valueCsvSerializer->unserialize(array_shift($column), '/')
        );
    }

    /**
     * Tests if the unserialize() method returns the serialized value from a column with categories that contains qoutes.
     *
     * @return void
     */
    public function testUnserializeCategoriesFromAColumnWithQuotes()
    {

        // first extract the the column value (simulating what happens when column will be extracted with $this->getValue(ColumnKeys::PATH) from the CSV file)
        $column = $this->valueCsvSerializer->unserialize('"Default Category/Etiketten und Prüfplaketten/Prüfplaketten/Prüfplaketten ""Nächster Prüftermin Geprüft"""');

        // explode the columns
        $this->assertEquals(
            array('Default Category', 'Etiketten und Prüfplaketten', 'Prüfplaketten', 'Prüfplaketten "Nächster Prüftermin Geprüft"'),
            $this->valueCsvSerializer->unserialize(array_shift($column), '/')
        );
    }
}
