<?php

/**
 * TechDivision\Import\Serializers\Csv\CategoryCsvSerializer
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
use TechDivision\Import\Serializer\CategorySerializerInterface;
use TechDivision\Import\Serializer\Configuration\SerializerConfigurationInterface;

/**
 * Serializer implementation that un-/serializes the categories found in the CSV file
 * in the row 'path'.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */
class CategoryCsvSerializer extends AbstractCsvSerializer implements CategorySerializerInterface
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
     *  The configuration instance.
     *
     * @var \TechDivision\Import\Serializer\Configuration\SerializerConfigurationInterface
     */
    private $configuration;

    /**
     * Initialize the serializer with the passed CSV value serializer factory.
     *
     * @param \TechDivision\Import\Serializer\Configuration\SerializerConfigurationInterface $configuration             The configuration instance
     * @param \TechDivision\Import\Serializer\SerializerFactoryInterface                     $valueCsvSerializerFactory The CSV value serializer factory
     */
    public function __construct(
        SerializerConfigurationInterface $configuration,
        SerializerFactoryInterface $valueCsvSerializerFactory
    ) {

        // set the passed instances
        $this->configuration = $configuration;
        $this->valueCsvSerializerFactory = $valueCsvSerializerFactory;

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
     * Return's the delimiter character for categories, default value is comma (/).
     *
     * @return string The delimiter character for categories
     */
    protected function getCategoryDelimiter()
    {
        return $this->getConfiguration()->getCategoryDelimiter();
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
        return $this->getValueCsvSerializer()->explode($serialized, $delimiter ? $delimiter : $this->getCategoryDelimiter());
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
        return $this->getValueCsvSerializer()->implode($unserialized, $delimiter ? $delimiter : $this->getCategoryDelimiter());
    }

    /**
     * Denormalizes the passed path.
     *
     * @param string $path The path that has to be normalized
     *
     * @return string The denormalized path
     * @throws \Exception Is thrown, because the method has not yet been implemented
     */
    public function denormalize(string $path) : string
    {
        throw new \Exception(sprintf('Method "%s" has not been implemented yet', __METHOD__));
    }

    /**
     * Normalizes the category path in a standard representation.
     *
     * For example this means, that a category  path `Default Category/Gear`
     * will be normalized into `"Default Category"/Gear`.
     *
     * @param string $path The category path that has to be normalized
     *
     * @return string The normalized category path
     */
    public function normalize(string $path) : string
    {
        return $this->implode($this->explode($path));
    }
}
