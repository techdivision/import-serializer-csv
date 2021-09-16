<?php

/**
 * TechDivision\Import\Serializer\Csv\Utils\FrontentInputTypes
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
 * Utility class containing the available frontend input types.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-serializer-csv
 * @link      http://www.techdivision.com
 */
class FrontendInputTypes
{

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     */
    private function __construct()
    {
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Name for the frontend input type 'multiselect'.
     *
     * @var string
     */
    const MULTISELECT = 'multiselect';

    /**
     * Name for the frontend input type 'boolean'.
     *
     * @var string
     */
    const BOOLEAN = 'boolean';
}
