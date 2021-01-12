<?php

/**
 * TechDivision\Import\Serializer\Csv\\AbstractSerializerTest
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
*
* PHP version 5
*
* @author    Tim Wagner <t.wagner@techdivision.com>
* @copyright 2021 TechDivision GmbH <info@techdivision.com>
* @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
* @link      https://github.com/techdivision/import-serializer-csv
* @link      http://www.techdivision.com
*/

namespace TechDivision\Import\Serializer\Csv;

use PHPUnit\Framework\TestCase;
use TechDivision\Import\Serializer\Csv\Configuration\ConfigurationInterface;
use TechDivision\Import\Serializer\Csv\Configuration\CsvConfigurationInterface;
use TechDivision\Import\Serializer\Csv\Utils\TestMemberNames;
use TechDivision\Import\Serializer\Csv\Utils\TestEntityTypeCodes;
use TechDivision\Import\Serializer\Csv\Utils\TestFrontendInputTypes;

/**
 * Test class for the SQL statement implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */
abstract class AbstractSerializerTest extends TestCase
{

    /**
     * The default configuration values.
     *
     * @var array
     */
    protected $defaultConfiguration = array(
        'getEntityTypeCode'         => TestEntityTypeCodes::CATALOG_PRODUCT,
        'getMultipleFieldDelimiter' => ',',
        'getMultipleValueDelimiter' => '|'
    );

    /**
     * The default CSV configuration values.
     *
     * @var array
     */
    protected $defaultCsvConfiguration = array(
        'getDelimiter' => ',',
        'getEnclosure' => '"',
        'getEscape'    => '\\'
    );

    /**
     * Returns the array with virtual entity types for testing purposes.
     *
     * @param array $entityTypes An array with additional entity types to merge
     *
     * @return array The array with the entity types
     */
    protected function getEntityTypes(array $entityTypes = array())
    {
        return array_merge(
            array(
                TestEntityTypeCodes::CATALOG_PRODUCT => array(
                    TestMemberNames::ENTITY_TYPE_ID   => 4,
                    TestMemberNames::ENTITY_TYPE_CODE => TestEntityTypeCodes::CATALOG_PRODUCT
                )
            ),
            $entityTypes
        );
    }

    /**
     * Returns an array with virtual attributes for testing purposes.
     *
     * @param array $attributes An array with additional attributes to merge
     *
     * @return array The array with the attributes
     */
    protected function getAttributes(array $attributes = array())
    {
        return array_merge(
            array(
                'size' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'size',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::MULTISELECT
                ),
                'features_bags' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'features_bags',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::MULTISELECT
                ),
                'ac_01' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'ac_01',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'ac_02' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'ac_02',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'delivery_date_1' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'delivery_date_1',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'my_boolean_attribute' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'my_boolean_attribute',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::BOOLEAN
                ),
                'my_select_attribute' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'my_select_attribute',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'my_multiselect_attribute' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'my_multiselect_attribute',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::MULTISELECT
                ),
                'Application' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Application',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'BulletText2' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'BulletText2',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'ClothingSize' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'ClothingSize',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'Colours' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Colours',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'Description' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Description',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'FlagNew' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'FlagNew',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'FlagSample' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'FlagSample',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'Manufacturer' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Manufacturer',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'Material' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Material',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'MergeUomFactor' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'MergeUomFactor',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'Packaging' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Packaging',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'PublishTo' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'PublishTo',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'Type' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Type',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => TestFrontendInputTypes::SELECT
                ),
                'BulletText2' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'BulletText2',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'Category1Header' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Category1Header',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'Category3Header' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Category3Header',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'Legend' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Legend',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'MainlinePageNumber' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'MainlinePageNumber',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'Properties' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'Properties',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'PubCodeRankingValue' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'PubCodeRankingValue',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'SpaceCode' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'SpaceCode',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'StyleNo' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'StyleNo',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'StyleNoHeader' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'StyleNoHeader',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'SubHeader' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'SubHeader',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'TableHead1' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'TableHead1',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'YNumberMaterial' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'YNumberMaterial',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                ),
                'SP_STATUS' => array(
                    TestMemberNames::ATTRIBUTE_CODE => 'SP_STATUS',
                    TestMemberNames::ENTITY_TYPE_ID => 4,
                    TestMemberNames::FRONTEND_INPUT => 'text'
                )
            ),
            $attributes
        );
    }

    /**
     * Create and return a mock configuration instance.
     *
     * @param array $configuration The configuration to use (will override with the default one)
     *
     * @return \TechDivision\Import\Serializer\Csv\Configuration\ConfigurationInterface The configuration instance
     */
    protected function getMockConfiguration(array $configuration = array())
    {

        // merge the default configuration with the passed on
        $configuration = array_merge($this->defaultConfiguration, $configuration);

        // create a mock configuration instance
        $mockConfiguration = $this->getMockBuilder(ConfigurationInterface::class)->getMock();

        // mock the methods
        foreach ($configuration as $methodName => $returnValue) {
            // mock the methods
            $mockConfiguration->expects($this->any())
                ->method($methodName)
                ->willReturn($returnValue);
        }

        // return the mock configuration
        return $mockConfiguration;
    }

    /**
     * Create and return a mock CSV configuration instance.
     *
     * @param array $csvConfiguration The CSV configuration to use (will override with the default one)
     *
     * @return \TechDivision\Import\Serializer\Csv\Configuration\CsvConfigurationInterface The configuration instance
     */
    protected function getMockSerializerConfiguration(array $csvConfiguration = array())
    {

        // merge the default configuration with the passed on
        $csvConfiguration = array_merge($this->defaultCsvConfiguration, $csvConfiguration);

        // create a mock configuration instance
        $mockCsvConfiguration = $this->getMockBuilder(CsvConfigurationInterface::class)->getMock();

        // mock the methods
        foreach ($csvConfiguration as $methodName => $returnValue) {
            // mock the methods
            $mockCsvConfiguration->expects($this->any())
                ->method($methodName)
                ->willReturn($returnValue);
        }

        // return the mock configuration
        return $mockCsvConfiguration;
    }
}
