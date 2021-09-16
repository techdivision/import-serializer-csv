<?php

/**
 * TechDivision\Import\Serializers\Csv\AbstractSerializer
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Serializer\Csv;

use TechDivision\Import\Serializer\SerializerInterface;
use TechDivision\Import\Serializer\ConfigurationAwareSerializerInterface;
use TechDivision\Import\Serializer\Configuration\SerializerConfigurationInterface;

/**
 * Abstract serializer implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */
abstract class AbstractCsvSerializer implements SerializerInterface, ConfigurationAwareSerializerInterface
{

    /**
     * The configuration used to un-/serialize the additional attributes.
     *
     * @var \TechDivision\Import\Serializer\Csv\Configuration\CsvConfigurationInterface
     */
    private $serializerConfiguration;

    /**
     * Passes the configuration and initializes the serializer.
     *
     * @param \TechDivision\Import\Serializer\Csv\Configuration\CsvConfigurationInterface $configuration The CSV configuration
     *
     * @return void
     */
    public function init(SerializerConfigurationInterface $configuration)
    {
        $this->serializerConfiguration = $configuration;
    }

    /**
     * Returns the configuration to un-/serialize the additional attributes.
     *
     * @return \TechDivision\Import\Serializer\Configuration\SerializerConfigurationInterface The configuration
     */
    public function getSerializerConfiguration()
    {
        return $this->serializerConfiguration;
    }
}
