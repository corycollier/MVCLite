<?php
/**
 * Defines the base singleton type
 *
 * @category    MvcLite
 * @package     Lib
 * @subpackage  Object
 * @since       File available since release 2.0.0
 * @author      Cory Collier <corycollier@corycollier.com>
 */

namespace \MvcLite\Object;

use \MvcLite;

/**
 * Defines the base singleton type
 *
 * @category    MvcLite
 * @package     Lib
 * @subpackage  Object
 * @since       File available since release 2.0.0
 * @author      Cory Collier <corycollier@corycollier.com>
 */
class Singleton
    extends \MvcLite\ObjectAbstract
{
    /**
     * @var Lib_Object_Singleton
     */
    protected static $_instances = array();

    /**
     * Privatizing the constructor, to enforce the singleton pattern
     */
    protected function __construct()
    {

    } // END function __construct

    /**
     * Accessor method to get to the single instance of this class.
     *
     * @return Lib_Object_Singleton
     */
    public static function getInstance()
    {
        $self = get_called_class();

        if (! @$self::$_instances[$self]) {
            $self::$_instances[$self] = new $self;
        }

        return $self::$_instances[$self];

    } // END function getInstance

} // END class Lib_Object_Singleton
