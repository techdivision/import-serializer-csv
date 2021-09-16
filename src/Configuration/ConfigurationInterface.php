<?php

/**
 * TechDivision\Import\Serializer\Csv\Configuration\ConfigurationInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-serializer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Serializer\Csv\Configuration;

/**
 * The interface for serializer configuration implementations.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-serializer
 * @link      http://www.techdivision.com
 */
interface ConfigurationInterface extends CsvConfigurationInterface, \TechDivision\Import\Serializer\Configuration\ConfigurationInterface
{

    /**
     * Return's the entity type code to be used.
     *
     * @return string The entity type code to be used
     */
    public function getEntityTypeCode();

    /**
     * Returns the multiple value delimiter from the configuration.
     *
     * @return string The multiple value delimiter
     */
    public function getMultipleValueDelimiter();

    /**
     * Returns the multiple field delimiter from the configuration.
     *
     * @return string The multiple field delimiter
     */
    public function getMultipleFieldDelimiter();
}
