<?php
/**
 * Container class for handling objects that will be printed in the view.
 *
 * @copyright   Copyright 2010, GMO Media, Inc. (http://www.gmo-media.jp)
 * @category    Gnix
 * @package     Gnix_View
 * @license     http://www.gmo-media.jp/licence/mit.html   MIT License
 * @author      Chikara Miyake <chikara.miyake@gmo-media.jp>
 */
class Gnix_View_AutoEscaper_Container implements IteratorAggregate, Countable, ArrayAccess
{
    private $_data;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->_data = array();
            foreach ($data as $key => $datum) {
                $this->_data[$key] = self::wrap($datum);
            }
        } else {
            $this->_data = $data;
        }
    }

    public static function wrap($value)
    {
        // Empty strings, empty arrays such as "" or array() aren't to be escaped.
        if (!$value) {
            return $value;
        }

        // Numeric values aren't to be escaped.
        if (is_numeric($value)) {
            return $value;
        }

        // $value might be '<b>aaa</b>'.
        if (is_string($value)) {
            return new self($value);
        }

        // $value might be array('<b>aaa</b>').
        if (is_array($value)) {
            return new self($value);
        }

        if ($value instanceof Gnix_View_AutoEscaper_Container) {
            return $value;
        }

        // $value->var or $value->method() might return '<b>aaa</b>'.
        if (is_object($value)) {
            return new self($value);
        }

        return $value;
    }

    public function __toString()
    {
        return (string) $this->_escape($this->_data);
    }

    public function __get($name)
    {
        return $this->_escape($this->_data->$name);
    }

    public function __set($name, $value)
    {
        throw new Gnix_View_AutoEscaper_Exception('Can\'t change view variables');
    }

    public function __call($name, $args)
    {
        return $this->_escape(call_user_func_array(array($this->_data, $name), $args));
    }

    // For IteratorAggregate

    public function getIterator()
    {
        try {
            return new ArrayIterator($this->_data);
        } catch (InvalidArgumentException $e) {
            // This happens when you set a scalar value to foreach like 'foreach ($string as $var)'
            $backtraces = debug_backtrace();
            throw new Gnix_View_AutoEscaper_Exception(
                'Invalid argument supplied for foreach() in ' . $backtraces[0]['file'] . ' on line ' . $backtraces[0]['line']
            );
        }
    }

    // For Countable

    public function count()
    {
        return count($this->_data);
    }

    // For ArrayAccess

    public function offsetGet($offset)
    {
        return $this->_data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new Gnix_View_AutoEscaper_Exception('Can\'t change view variables');
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_data);
    }

    public function offsetUnset($offset)
    {
        throw new Gnix_View_AutoEscaper_Exception('Can\'t change view variables');
    }

    // Escaper

    private function _escape($value)
    {
        if (is_array($value) || is_object($value)) {
            return self::wrap($value);
        }

        return Gnix_View_AutoEscaper::getEscaperClass()->escape((string) $value);
    }
}
