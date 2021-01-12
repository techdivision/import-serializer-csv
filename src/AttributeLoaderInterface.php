<?php

/**
 * TechDivision\Import\Serializers\AttributeLoaderInterface
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

/**
 * Interface for attribute loader implementations.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */
interface AttributeLoaderInterface
{

    /**
     * Loads and returns the attribute with the passed code from the database.
     *
     * @param string $attributeCode The code of the attribute to return
     *
     * @return array The attribute
     */
    public function loadAttributeByAttributeCode(string $attributeCode) : array;



    /**
     * Return's an EAV entity type with the passed entity type code.
     *
     * @param string $entityTypeCode The code of the entity type to return
     *
     * @return array The entity type with the passed entity type code
     */
    public function getEavEntityTypeByEntityTypeCode(string $entityTypeCode) : array;


    /**
     * Return's the EAV attribute with the passed entity type ID and code.
     *
     * @param int    $entityTypeId  The entity type ID of the EAV attribute to return
     * @param string $attributeCode The code of the EAV attribute to return
     *
     * @return array The EAV attribute
     */
    public function getEavAttributeByEntityTypeIdAndAttributeCode(int $entityTypeId, string $attributeCode) : array;
}
