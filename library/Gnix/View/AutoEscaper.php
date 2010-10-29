<?php
/**
 * Zend_View class for escaping HTML automatically.
 *
 * @copyright   Copyright 2010, GMO Media, Inc. (http://www.gmo-media.jp)
 * @category    Gnix
 * @package     Gnix_View
 * @license     http://www.gmo-media.jp/licence/mit.html   MIT License
 * @author      Chikara Miyake <chikara.miyake@gmo-media.jp>
 */
class Gnix_View_AutoEscaper extends Zend_View
{
    private static $_escaperClass;

    private $_strictVars = false;

    private $_vars = array();

    /**
     * There must be some ways to avoid doing this.
     *
     * @see Zend_View_Abstract::strictVars()
     */
    public function strictVars($flag = true)
    {
        $this->_strictVars = ($flag) ? true : false;

        return $this;
    }

    public static function getEscaperClass()
    {
        return self::$_escaperClass;
    }

    public static function setEscaperClass(Gnix_View_AutoEscaper_Escaper_Interface $escaperClass)
    {
        self::$_escaperClass = $escaperClass;
    }

    public function __construct($config = array())
    {
        if (!self::$_escaperClass) {
            self::$_escaperClass = new Gnix_View_AutoEscaper_Escaper();
        }

        parent::__construct($config);
    }

    public function unescape($value)
    {
        return self::$_escaperClass->unescape((string) $value);
    }

    /**
     * You can't use parent::__set() here. If you set a value into a
     * same variable twice, it won't call __set().
     * (This means the second one won't be escaped.)
     *
     * @see Zend_View_Abstract::strictVars()
     */
    public function __set($key, $value)
    {
        if ('_' != substr($key, 0, 1)) {
            $this->_vars[$key] = Gnix_View_AutoEscaper_Container::wrap($value);
            return;
        }

        $e = new Zend_View_Exception('Setting private or protected class members is not allowed');
        $e->setView($this);
        throw $e;
    }

    /**
     * @see Zend_View_Abstract::strictVars()
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->_vars)) {
            return $this->_vars[$key];
        }

        if ($this->_strictVars) {
            trigger_error('Key "' . $key . '" does not exist', E_USER_NOTICE);
        }

        return null;
    }
}
