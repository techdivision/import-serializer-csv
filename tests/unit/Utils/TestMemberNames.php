<?php

/**
 * TechDivision\Import\Serializer\Csv\Utils\TestMemberNames
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Serializer\Csv\Utils;

/**
 * Utility class containing the entities member names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */
class TestMemberNames extends MemberNames
{

    /**
     * Name for the member 'attribute_code'.
     *
     * @var string
     */
    const ATTRIBUTE_CODE = 'attribute_code';

    /**
     * Name for the member 'entity_type_code'.
     *
     * @var string
     */
    const ENTITY_TYPE_CODE = 'entity_type_code';
}
