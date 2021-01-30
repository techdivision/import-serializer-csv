<?php

/**
 * TechDivision\Import\Serializers\Csv\AdditionalAttributeCsvSerializer
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

use TechDivision\Import\Serializer\SerializerInterface;
use TechDivision\Import\Serializer\SerializerFactoryInterface;
use TechDivision\Import\Serializer\AdditionalAttributeSerializerInterface;
use TechDivision\Import\Serializer\Configuration\SerializerConfigurationInterface;
use TechDivision\Import\Serializer\Csv\Utils\MemberNames;
use TechDivision\Import\Serializer\Csv\Utils\FrontendInputTypes;
use TechDivision\Import\Serializer\Csv\Configuration\ConfigurationInterface;
use TechDivision\Import\Serializer\Csv\Services\EavAttributeAwareProcessorInterface;

/**
 * Serializer implementation that un-/serializes the additional product attribues found in the CSV file
 * in the row 'additional_attributes'.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */
class AdditionalAttributeCsvSerializer extends AbstractCsvSerializer implements AdditionalAttributeSerializerInterface
{

    /**
     * The factory instance for the CSV value serializer.
     *
     * @var \TechDivision\Import\Serializer\SerializerFactoryInterface
     */
    private $valueCsvSerializerFactory;

    /**
     * The CSV value serializer instance.
     *
     * @var \TechDivision\Import\Serializer\SerializerInterface
     */
    private $valueCsvSerializer;

    /**
     * The entity type from the configuration.
     *
     * @var array
     */
    private $entityType = array();

    /**
     *  The configuration instance.
     *
     * @var \TechDivision\Import\Serializer\Configuration\ConfigurationInterface
     */
    private $configuration;

    /**
     * The attribute loader instance.
     *
     * @var \TechDivision\Import\Serializer\Csv\Services\EavAttributeAwareProcessorInterface
     */
    private $eavAttributeAwareProcessor;

    /**
     * Initialize the serializer with the passed CSV value serializer factory.
     *
     * @param \TechDivision\Import\Serializer\Csv\Configuration\ConfigurationInterface         $configuration             The configuration instance
     * @param \TechDivision\Import\Serializer\Csv\Services\EavAttributeAwareProcessorInterface $attributeLoader           The attribute loader instance
     * @param \TechDivision\Import\Serializer\SerializerFactoryInterface                       $valueCsvSerializerFactory The CSV value serializer factory
     */
    public function __construct(
        ConfigurationInterface $configuration,
        EavAttributeAwareProcessorInterface $attributeLoader,
        SerializerFactoryInterface $valueCsvSerializerFactory
    ) {

        // set the passed instances
        $this->configuration = $configuration;
        $this->eavAttributeAwareProcessor = $attributeLoader;
        $this->valueCsvSerializerFactory = $valueCsvSerializerFactory;

        // load the entity type for the entity type defined in the configuration
        $this->entityType = $attributeLoader->getEavEntityTypeByEntityTypeCode($configuration->getEntityTypeCode());

        // pre-initialize the serialize with the values
        // found in the main configuration
        $this->init($configuration);
    }

    /**
     * Returns the configuration instance.
     *
     * @return \TechDivision\Import\Serializer\Configuration\SerializerConfigurationInterface The configuration instance
     */
    protected function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Returns the factory instance for the CSV value serializer.
     *
     * @return \TechDivision\Import\Serializer\SerializerFactoryInterface The CSV value serializer factory instance
     */
    protected function getValueCsvSerializerFactory()
    {
        return $this->valueCsvSerializerFactory;
    }

    /**
     * Returns the CSV value serializer instance.
     *
     * @param \TechDivision\Import\Serializer\SerializerInterface $valueCsvSerializer The CSV value serializer instance
     *
     * @return void
     */
    protected function setValueCsvSerializer(SerializerInterface $valueCsvSerializer)
    {
        $this->valueCsvSerializer = $valueCsvSerializer;
    }

    /**
     * Returns the CSV value serializer instance.
     *
     * @return \TechDivision\Import\Serializer\SerializerInterface The CSV value serializer instance
     */
    protected function getValueCsvSerializer()
    {
        return $this->valueCsvSerializer;
    }

    /**
     * Returns the EAV attribute aware processor instance.
     *
     * @return \TechDivision\Import\Serializer\Csv\Services\EavAttributeAwareProcessorInterface The EAV attribute aware processor instance
     */
    protected function getEavAttributeAwareProcessor() : EavAttributeAwareProcessorInterface
    {
        return $this->eavAttributeAwareProcessor;
    }

    /**
     * Returns entity type ID mapped from the configuration.
     *
     * @return integer The mapped entity type ID
     */
    protected function getEntityTypeId()
    {
        return $this->entityType[MemberNames::ENTITY_TYPE_ID];
    }

    /**
     * Returns the multiple value delimiter from the configuration.
     *
     * @return string The multiple value delimiter
     */
    protected function getMultipleValueDelimiter()
    {
        return $this->getConfiguration()->getMultipleValueDelimiter();
    }

    /**
     * Returns the multiple field delimiter from the configuration.
     *
     * @return string The multiple field delimiter
     */
    protected function getMultipleFieldDelimiter()
    {
        return $this->getConfiguration()->getMultipleFieldDelimiter();
    }

    /**
     * Loads and returns the attribute with the passed code from the database.
     *
     * @param string $attributeCode The code of the attribute to return
     *
     * @return array The attribute
     */
    protected function loadAttributeByAttributeCode($attributeCode)
    {
        return $this->getEavAttributeAwareProcessor()->getEavAttributeByEntityTypeIdAndAttributeCode($this->getEntityTypeId(), $attributeCode);
    }

    /**
     * Packs the passed value according to the frontend input type of the attribute with the passed code.
     *
     * @param string $attributeCode The code of the attribute to pack the passed value for
     * @param mixed  $value         The value to pack
     *
     * @return string The packed value
     */
    protected function pack($attributeCode, $value)
    {

        // load the attibute with the passed code
        $attribute = $this->loadAttributeByAttributeCode($attributeCode);

        // pack the value according to the attribute's frontend input type
        switch ($attribute[MemberNames::FRONTEND_INPUT]) {
            case FrontendInputTypes::MULTISELECT:
                return $this->implode($value, $this->getMultipleValueDelimiter());
                break;

            case FrontendInputTypes::BOOLEAN:
                return $value === true ? 'true' : 'false';
                break;

            default:
                return $value;
        }
    }

    /**
     * Unpacks the passed value according to the frontend input type of the attribute with the passed code.
     *
     * @param string $attributeCode The code of the attribute to pack the passed value for
     * @param string $value         The value to unpack
     *
     * @return mixed The unpacked value
     */
    protected function unpack($attributeCode, $value)
    {

        // load the attibute with the passed code
        $attribute = $this->loadAttributeByAttributeCode($attributeCode);

        // unpack the value according to the attribute's frontend input type
        switch ($attribute[MemberNames::FRONTEND_INPUT]) {
            case FrontendInputTypes::MULTISELECT:
                return $this->explode($value, $this->getMultipleValueDelimiter());
                break;

            case FrontendInputTypes::BOOLEAN:
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
                break;

            default:
                return $value;
        }
    }

    /**
     * Passes the configuration and initializes the serializer.
     *
     * @param \TechDivision\Import\Serializer\Configuration\SerializerConfigurationInterface $configuration The CSV configuration
     *
     * @return void
     */
    public function init(SerializerConfigurationInterface $configuration)
    {

        // pass the configuration to the parent instance
        parent::init($configuration);

        // create the CSV value serializer instance
        $this->setValueCsvSerializer($this->getValueCsvSerializerFactory()->createSerializer($configuration));
    }

    /**
     * Unserializes the elements of the passed string.
     *
     * @param string|null $serialized The value to unserialize
     * @param string|null $delimiter  The delimiter used to unserialize the elements
     *
     * @return array The unserialized values
     * @see \TechDivision\Import\Serializer\SerializerInterface::unserialize()
     */
    public function unserialize($serialized = null, $delimiter = null)
    {
        return $this->getValueCsvSerializer()->explode($serialized, $delimiter ? $delimiter : $this->getMultipleFieldDelimiter());
    }

    /**
     * Serializes the elements of the passed array.
     *
     * @param array|null  $unserialized The serialized data
     * @param string|null $delimiter    The delimiter used to serialize the values
     *
     * @return string The serialized array
     * @see \TechDivision\Import\Serializer\SerializerInterface::serialize()
     */
    public function serialize(array $unserialized = null, $delimiter = null)
    {
        return $this->getValueCsvSerializer()->implode($unserialized, $delimiter ? $delimiter : $this->getMultipleFieldDelimiter());
    }

    /**
     * Extracts the elements of the passed value by exploding them
     * with the also passed delimiter.
     *
     * @param string|null $value     The value to extract
     * @param string|null $delimiter The delimiter used to extrace the elements
     *
     * @return array|null The exploded values
     * @see \TechDivision\Import\Serializer\SerializerInterface::unserialize()
     */
    public function explode($value = null, $delimiter = null)
    {
        return $this->unserialize($value, $delimiter);
    }

    /**
     * Compacts the elements of the passed value by imploding them
     * with the also passed delimiter.
     *
     * @param array|null  $value     The values to compact
     * @param string|null $delimiter The delimiter use to implode the values
     *
     * @return string|null The compatected value
     * @see \TechDivision\Import\Serializer\SerializerInterface::serialize()
     */
    public function implode(array $value = null, $delimiter = null)
    {
        return $this->serialize($value, $delimiter);
    }

    /**
     * Create a CSV compatible string from the passed category path.
     *
     * @param string|null $value  The normalized category path (usually from the DB)
     * @param bool        $unpack TRUE if the option values has to be unpacked, in case of a multiselect attribute
     *
     * @return array The array with the denormalized attribute values
     */
    public function denormalize(string $value = null, bool $unpack = true) : array
    {

        // initialize the array for the attributes
        $attrs = array();

        // explode the additional attributes and iterate
        // over the attributes and append them to the row
        if (is_array($additionalAttributes = $this->unserialize($value))) {
            foreach ($additionalAttributes as $additionalAttribute) {
                // initialize the option value
                $optionValue = '';
                // explode attribute code/option value from the attribute
                $exploded = $this->explode($additionalAttribute, '=');
                // initialize attribute code and option value, depending on what we've exploded
                if (sizeof($exploded) < 1) {
                    continue;
                } elseif (sizeof($exploded) === 1) {
                    list ($attributeCode) = $exploded;
                } else {
                    list ($attributeCode, $optionValue) = $exploded;
                }
                // query whether or not we've to pack the option
                // values in case we've a multiselect input field
                $optionValue = $unpack ? $this->unpack($attributeCode, $optionValue) : $optionValue;
                // unpack the attribute values and add them to the array
                $attrs[$attributeCode] = $optionValue;
            }
        }

        // return the extracted array with the additional attributes
        return $attrs;
    }

    /**
     * Normalizes the category path in a standard representation.
     *
     * For example this means, that a category  path `Default Category/Gear`
     * will be normalized into `"Default Category"/Gear`.
     *
     * @param array $values The category path that has to be normalized
     * @param bool  $pack   TRUE if the option values has to be packed, in case of a multiselect attribute
     *
     * @return string The normalized category path
     */
    public function normalize(array $values, bool $pack = true) : string
    {

        // initialize the array for the attributes
        $attrs = array();

        // iterate over the attributes and append them to the row
        if (is_array($values)) {
            foreach ($values as $attributeCode => $optionValue) {
                // query whether or not we've to unpack the option
                // values in case we've a multiselect input field
                $optionValue = $pack ? $this->pack($attributeCode, $optionValue) : $optionValue;
                // append th eption value to the array
                $attrs[] = sprintf('%s=%s', $attributeCode, $optionValue);
            }
        }

        // implode the array with the packed additional attributes and return it
        return $this->serialize($attrs);
    }
}
