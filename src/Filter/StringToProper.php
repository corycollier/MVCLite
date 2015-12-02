<?php
/**
 * string to upper filter
 *
 * @category    PHP
 * @package     MvcLite
 * @subpackage  Filter
 * @since       File available since release 1.1.x
 * @author      Cory Collier <corycollier@corycollier.com>
 */

namespace MvcLite\Filter;

/**
 * string to upper filter
 *
 * @category    PHP
 * @package     MvcLite
 * @subpackage  Filter
 * @since       Class available since release 1.1.x
 * @author      Cory Collier <corycollier@corycollier.com>
 */

class StringToProper extends \MvcLite\FilterAbstract
{
    /**
     * (non-PHPdoc)
     * @see \MvcLite\FilterAbstract::filter()
     */
    public function filter ($word = '')
    {
        return ucwords($word);
    }

} // END class Lib_Filter_StringToUpper
