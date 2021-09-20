<?php

/**
 * TechDivision\Import\Serializer\Csv\AdditionalAttributeCsvSerializerTest
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

use TechDivision\Import\Serializer\SerializerFactoryInterface;
use TechDivision\Import\Serializer\Csv\Services\EavAttributeAwareProcessorInterface;

/**
 * Test class for CSV additional attribute serializer implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */
class AdditionalAttributeCsvSerializerTest extends AbstractSerializerTest
{

    /**
     * The additional attribute serializer we want to test.
     *
     * @var \TechDivision\Import\Serializer\Csv\AdditionalAttributeCsvSerializer
     */
    protected $additionalAttributeSerializer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp(): void
    {

        // load the default attributes/entity types
        $attributes = $this->getAttributes();
        $entityTypes = $this->getEntityTypes();

        // initialize the mock for the import processor
        $attributeLoader = $this->getMockBuilder(EavAttributeAwareProcessorInterface::class)->setMethods(get_class_methods(EavAttributeAwareProcessorInterface::class))->getMock();
        $attributeLoader->expects($this->any())->method('getEavEntityTypeByEntityTypeCode')->willReturnCallback(function ($entityTypeCode) use ($entityTypes) {
            return $entityTypes[$entityTypeCode];
        });
        $attributeLoader->expects($this->any())->method('getEavAttributeByEntityTypeIdAndAttributeCode')->willReturnCallback(function ($entityTypeId, $attributeCode) use ($attributes) {
            return $attributes[$attributeCode];
        });

        // initialize the mock for the CSV serializer
        $valueCsvSerializer = new ValueCsvSerializer();
        $valueCsvSerializer->init($mockConfiguration = $this->getMockConfiguration());
        $valueCsvSerializerFactory = $this->getMockBuilder(SerializerFactoryInterface::class)->getMock();
        $valueCsvSerializerFactory->expects($this->any())->method('createSerializer')->willReturn($valueCsvSerializer);

        // initialize the additional attribute serializer to be tested
        $this->additionalAttributeSerializer = new AdditionalAttributeCsvSerializer($mockConfiguration, $attributeLoader, $valueCsvSerializerFactory);
    }

    /**
     * Tests if the serialize() method returns the serialized value.
     *
     * @return void
     */
    public function testNormalizeEmptyArrayWithSuccess()
    {
        $this->assertEquals(null, $this->additionalAttributeSerializer->normalize(array()));
    }

    /**
     * Tests if the serialize() method returns the serialized value.
     *
     * @return void
     */
    public function testNormalizeWithSuccess()
    {
        $this->assertEquals('ac_01=ov_01,ac_02=ov_02', $this->additionalAttributeSerializer->normalize(array('ac_01' => 'ov_01', 'ac_02' => 'ov_02')));
    }

    /**
     * Tests if the unserialize() method returns the serialized value.
     *
     * @return void
     */
    public function testDenormalizeEmptyArrayWithSuccess()
    {
        $this->assertEquals(array(), $this->additionalAttributeSerializer->denormalize(null));
    }

    /**
     * Tests if the unserialize() method returns the serialized value.
     *
     * @return void
     */
    public function testtDenormalizeWithSuccess()
    {
        $this->assertEquals(array('ac_01' => 'ov_01', 'ac_02' => 'ov_02'), $this->additionalAttributeSerializer->denormalize('"ac_01=ov_01","ac_02=ov_02"'));
    }

    /**
     * Tests if the unserialize() method returns the serialized value, if only one value is available.
     *
     * @return void
     */
    public function testtDenormalizeSingleAdditionalAttribute()
    {
        $this->assertEquals(array('delivery_date_1' => '2019011'), $this->additionalAttributeSerializer->denormalize('"delivery_date_1=2019011"'));
    }

    /**
     * Tests if the unserialize() method with simple values for a boolean, select and multiselect attribute.
     *
     * @return void
     */
    public function testtDenormalizeWithoutValueDelimiter()
    {

        // initialize the serialized value
        $value = 'my_boolean_attribute=true,my_select_attribute=selected_value_01,my_multiselect_attribute=multiselected_value_01|multiselected_value_02';

        // initialize the expected result
        $values = array(
            'my_boolean_attribute'     => true,
            'my_select_attribute'      => 'selected_value_01',
            'my_multiselect_attribute' => array('multiselected_value_01', 'multiselected_value_02'),
        );

        // unserialize the value and assert the result
        $this->assertSame($values, $this->additionalAttributeSerializer->denormalize($value));
    }

    /**
     * Tests if the unserialize() method with enclosed simple values for a boolean, select and multiselect attribute.
     *
     * @return void
     */
    public function testtDenormalizeWithValueDelimiter()
    {

        // initialize the serialized value
        $value = '"my_boolean_attribute=true","my_select_attribute=selected_value_01","my_multiselect_attribute=multiselected_value_01|multiselected_value_02"';

        // initialize the expected result
        $values = array(
            'my_boolean_attribute'     => true,
            'my_select_attribute'      => 'selected_value_01',
            'my_multiselect_attribute' => array('multiselected_value_01', 'multiselected_value_02'),
        );

        // unserialize the value and assert the result
        $this->assertSame($values, $this->additionalAttributeSerializer->denormalize($value));
    }

    /**
     * Tests if the unserialize() method with partially enclosed values for a boolean, select and multiselect attribute that may contain a comma.
     *
     * @return void
     */
    public function testtDenormalizeWithPartialValueDelimiterAndValuesWithComma()
    {

        // initialize the serialized value
        $value = 'my_boolean_attribute=true,"my_select_attribute=selected_value,01","my_multiselect_attribute=multiselected_value,01|multiselected_value,02"';

        // initialize the expected result
        $values = array(
            'my_boolean_attribute'     => true,
            'my_select_attribute'      => 'selected_value,01',
            'my_multiselect_attribute' => array('multiselected_value,01', 'multiselected_value,02'),
        );

        // unserialize the value and assert the result
        $this->assertSame($values, $this->additionalAttributeSerializer->denormalize($value));
    }

    /**
     * Tests if the unserialize() method with enclosed simple values for a boolean, select and multiselect attribute.
     *
     * @return void
     */
    public function testtDenormalizeWithoutValueDelimiterAndManyAttributes()
    {

        // initialize the serialized value
        $value = '"""ClothingSize=Eine Größe XXL"",""Colours=Gelb"",""Description=Schutzoverall"",""FlagNew=Nein"",""FlagSample=Ja"",""Manufacturer=DS SafetyWear"",""Material=Vliesstoff"",""MergeUomFactor=Stück"",""Packaging=Stück"",""PublishTo=Web & Catalogue"",""Type=Mit Kapuze, verklebten Nähten und extra Polyethylenbeschichtung"",""BulletText2=<strong>195603:</strong><br>Mit Kapuze, Reißverschluss mit Abdeckblende und Gummizügen an Hosenbeinen, Armen und Kapuze. CE-Kategorie III, Typ 5, 6.<br><strong>Farbe:</strong>&nbsp;Weiß<br><strong>Größen:</strong> M, L, XL, XXL<br><br><strong>195608:</strong><br>Ausführung wie <strong>195603</strong>, jedoch mit verklebten Nähten für verbesserten Schutz. CE-Kategorie III, Typ 4, 5, 6.<br><strong>Farbe:</strong>&nbsp;Weiß<br><strong>Größen:&nbsp;</strong>M, L, XL, XXL<br><br><strong>195609:</strong><br>Ausführung wie <strong>195608</strong>, jedoch mit zusätzlicher Polyethylenbeschichtung für noch höheren Schutz, z.B. gegen aggressive Flüssigkeiten oder Sprühnebel. Geeignet für den Einsatz bei kontaminationsgefährlichen Arbeiten. CE-Kategorie III, Typ 3, 4, 5.<br><strong>Farbe:&nbsp;</strong>Gelb<br><strong>Größen:&nbsp;</strong>L, XL, XXL"",""Category1Header=Erste Hilfe & Arbeitsschutzausrüstung"",""Category3Header=Schutzkleidung"",""Legend=Schutzoveralls"",""MainlinePageNumber=U-370"",""Properties=CE-Kategorie III, Typ 3, 4, 5"",""PubCodeRankingValue=13825"",""SpaceCode=CJE: TYVEK-SCHUTZKLEIDUNG"",""StyleNo=195609"",""StyleNoHeader=Artikel-<br>nummer"",""SubHeader=Optimaler Schutz vor Staub, Farbe, Schadstoffen"",""TableHead1=Geben Sie bitte die gewünschte Größe an."",""YNumberMaterial=Y2932705"",""SP_STATUS=CURRENT"""';

        // create and initialize the CSV value serializer
        $valueCsvSerializer = new ValueCsvSerializer();
        $valueCsvSerializer->init($this->getMockSerializerConfiguration());

        // initialize the expected result
        $values = array(
            'ClothingSize'        => 'Eine Größe XXL',
            'Colours'             => 'Gelb',
            'Description'         => 'Schutzoverall',
            'FlagNew'             => 'Nein',
            'FlagSample'          => 'Ja',
            'Manufacturer'        => 'DS SafetyWear',
            'Material'            => 'Vliesstoff',
            'MergeUomFactor'      => 'Stück',
            'Packaging'           => 'Stück',
            'PublishTo'           => 'Web & Catalogue',
            'Type'                => 'Mit Kapuze, verklebten Nähten und extra Polyethylenbeschichtung',
            'BulletText2'         => '<strong>195603:</strong><br>Mit Kapuze, Reißverschluss mit Abdeckblende und Gummizügen an Hosenbeinen, Armen und Kapuze. CE-Kategorie III, Typ 5, 6.<br><strong>Farbe:</strong>&nbsp;Weiß<br><strong>Größen:</strong> M, L, XL, XXL<br><br><strong>195608:</strong><br>Ausführung wie <strong>195603</strong>, jedoch mit verklebten Nähten für verbesserten Schutz. CE-Kategorie III, Typ 4, 5, 6.<br><strong>Farbe:</strong>&nbsp;Weiß<br><strong>Größen:&nbsp;</strong>M, L, XL, XXL<br><br><strong>195609:</strong><br>Ausführung wie <strong>195608</strong>, jedoch mit zusätzlicher Polyethylenbeschichtung für noch höheren Schutz, z.B. gegen aggressive Flüssigkeiten oder Sprühnebel. Geeignet für den Einsatz bei kontaminationsgefährlichen Arbeiten. CE-Kategorie III, Typ 3, 4, 5.<br><strong>Farbe:&nbsp;</strong>Gelb<br><strong>Größen:&nbsp;</strong>L, XL, XXL',
            'Category1Header'     => 'Erste Hilfe & Arbeitsschutzausrüstung',
            'Category3Header'     => 'Schutzkleidung',
            'Legend'              => 'Schutzoveralls',
            'MainlinePageNumber'  => 'U-370',
            'Properties'          => 'CE-Kategorie III, Typ 3, 4, 5',
            'PubCodeRankingValue' => '13825',
            'SpaceCode'           => 'CJE: TYVEK-SCHUTZKLEIDUNG',
            'StyleNo'             => '195609',
            'StyleNoHeader'       => 'Artikel-<br>nummer',
            'SubHeader'           => 'Optimaler Schutz vor Staub, Farbe, Schadstoffen',
            'TableHead1'          => 'Geben Sie bitte die gewünschte Größe an.',
            'YNumberMaterial'     => 'Y2932705',
            'SP_STATUS'           => 'CURRENT'
        );

        // unserialize the value first time (simulate M2IF framework)
        $unserialized = $valueCsvSerializer->unserialize($value);

        // unserialize the value and assert the result
        $this->assertSame($values, $this->additionalAttributeSerializer->denormalize(array_shift($unserialized)));
    }

    /**
     * Tests if the unserialize() method with a multiselect attribute that has values that contains commas.
     *
     * @return void
     */
    public function testtDenormalizeWithComma()
    {

        // initialize the serialized value
        $value = '"""size=3,6 mm|3,8 mm"",""features_bags=Audio Pocket|Waterproof"""';

        // initialize the expected result
        $values = array(
            'size' => array('3,6 mm', '3,8 mm'),
            'features_bags' => array('Audio Pocket', 'Waterproof')
        );

        // create and initialize the CSV value serializer
        $valueCsvSerializer = new ValueCsvSerializer();
        $valueCsvSerializer->init($this->getMockSerializerConfiguration());

        // unserialize the value first time (simulate M2IF framework)
        $unserialized = $valueCsvSerializer->unserialize($value);

        // unserialize the value and assert the result
        $this->assertSame($values, $this->additionalAttributeSerializer->denormalize(array_shift($unserialized)));
    }

    /**
     * Tests if the serialize() method with simple values for a boolean, select and multiselect attribute.
     *
     * @return void
     */
    public function testNormalizeWithValueDelimiters()
    {

        // initialize the expected result
        $value = 'my_boolean_attribute=true,my_select_attribute=selected_value_01,my_multiselect_attribute=multiselected_value_01|multiselected_value_02';

        // initialize the array with the values to serializer
        $values = array(
            'my_boolean_attribute'     => true,
            'my_select_attribute'      => 'selected_value_01',
            'my_multiselect_attribute' => array('multiselected_value_01', 'multiselected_value_02')
        );

        // serialize the values and assert the result
        $this->assertSame($value, $this->additionalAttributeSerializer->normalize($values));
    }

    /**
     * Tests if the serialize() method with complex, commaseparated + delimited values for a text field.
     *
     * @return void
     */
    public function testtNormalizeWithCommaSeparatedAndValueDelimitedValues()
    {

        // initialize the expected result
        $value = '"Application=Empfangshallen,Postabteilungen,Arztpraxen,Verkaufsräume,Reisebüros","BulletText2=<strong>Material:</strong>&nbsp;Polyethylen, transparent <br><strong>Fachtiefe:</strong>&nbsp;45 mm <br><strong>Lieferumfang:</strong>&nbsp;inkl. Befestigungsmaterial"';

        // initialize the array with the values to serializer
        $values = array(
            'Application' => 'Empfangshallen,Postabteilungen,Arztpraxen,Verkaufsräume,Reisebüros',
            'BulletText2' => '<strong>Material:</strong>&nbsp;Polyethylen, transparent <br><strong>Fachtiefe:</strong>&nbsp;45 mm <br><strong>Lieferumfang:</strong>&nbsp;inkl. Befestigungsmaterial'
        );

        // serialize the values and assert the result
        $this->assertSame($value, $this->additionalAttributeSerializer->normalize($values));
    }
}
