<?php

/**
 * TechDivision\Import\Serializers\AbstractSerializer
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
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
