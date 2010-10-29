<?php
require_once '/path/to/gnix-view/tests/init.php';

class Gnix_View_AutoEscaperTest extends PHPUnit_Extensions_OutputTestCase
{
    private $view;

    /**
     * Sets up
     */
    protected function setUp()
    {
        $this->view = new Gnix_View_AutoEscaper();
    }

    public function testSetNull()
    {
        $this->view->var = null;
        $this->assertNull($this->view->var);
    }

    public function testSetBooleanFalse()
    {
        $this->view->var = false;
        $this->assertFalse($this->view->var);
    }

    public function testSetBooleanTrue()
    {
        $this->view->var = true;
        $this->assertTrue($this->view->var);
    }

    public function testSetInteger()
    {
        $this->view->var = 1;
        $this->assertSame(1, $this->view->var);
    }

    public function testSetFloat()
    {
        $this->view->var = 1.1;
        $this->assertSame(1.1, $this->view->var);
    }

    public function testSetString()
    {
        $this->view->var = '<b>A</b>';
        $this->assertType('Gnix_View_AutoEscaper_Container', $this->view->var);

        $this->expectOutputString('&lt;b&gt;A&lt;/b&gt;');
        echo $this->view->var;
    }

    public function testSetArray()
    {
        $this->view->var = array('<b>A</b>', '<b>B</b>', '<b>C</b>');
        $this->assertType('Gnix_View_AutoEscaper_Container', $this->view->var);

        $this->expectOutputString('&lt;b&gt;A&lt;/b&gt;&lt;b&gt;B&lt;/b&gt;&lt;b&gt;C&lt;/b&gt;');
        foreach ($this->view->var as $value) {
            echo $value;
        }
    }

    public function testSetObject()
    {
        $this->view->var = new Gnix_View_AutoEscaper_Sample();
        $this->assertType('Gnix_View_AutoEscaper_Container', $this->view->var);

        $this->expectOutputString('&lt;b&gt;property&lt;/b&gt;');
        echo $this->view->var->property;
    }

    public function testSetObject2()
    {
        $this->view->var = new Gnix_View_AutoEscaper_Sample();

        $this->expectOutputString('&lt;b&gt;getString&lt;/b&gt;');
        echo $this->view->var->getString();
    }

    public function testSetObject3()
    {
        $this->view->var = new Gnix_View_AutoEscaper_Sample();

        $this->expectOutputString('&lt;b&gt;getArray1&lt;/b&gt;&lt;b&gt;getArray2&lt;/b&gt;');
        foreach ($this->view->var->getArray() as $value) {
            echo $value;
        }
    }

    public function testSetObject4()
    {
        $this->view->var = new Gnix_View_AutoEscaper_Sample();

        $this->expectOutputString('&lt;b&gt;child property&lt;/b&gt;');
        echo $this->view->var->getObject()->property;
    }

    public function testSetObject5()
    {
        $this->view->var = new Gnix_View_AutoEscaper_Sample();

        $this->expectOutputString('&lt;b&gt;child getString&lt;/b&gt;');
        echo $this->view->var->getObject()->getString();
    }

    public function testSetObject6()
    {
        $this->view->var = new Gnix_View_AutoEscaper_Sample();

        $this->expectOutputString('&lt;b&gt;child getArray1&lt;/b&gt;&lt;b&gt;child getArray2&lt;/b&gt;');
        foreach ($this->view->var->getObject()->getArray() as $value) {
            echo $value;
        }
    }

    public function testSetContainer()
    {
        $this->view->var = new Gnix_View_AutoEscaper_Container('<b>abc</b>');
        $this->assertType('Gnix_View_AutoEscaper_Container', $this->view->var);

        $this->expectOutputString('&lt;b&gt;abc&lt;/b&gt;');
        echo $this->view->var;
    }

    public function testUnescape()
    {
        $this->view->var = new Gnix_View_AutoEscaper_Container('<b>abc</b>');

        $this->expectOutputString('<b>abc</b>');
        echo $this->view->unescape($this->view->var);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testUnescapeCustom()
    {
        $this->view->setEscaperClass(new Gnix_View_AutoEscaper_Sample_Escaper_Wrong());
    }

    public function testUnescapeCustom2()
    {
        $this->view->setEscaperClass(new Gnix_View_AutoEscaper_Sample_Escaper());

        $this->view->var = new Gnix_View_AutoEscaper_Container('<b>abc</b>');

        $this->expectOutputString('<b>abc</b>-customized');
        echo $this->view->unescape($this->view->var);
    }
}

/**
 * Classes for testing Gnix_View_AutoEscaperTest
 */
class Gnix_View_AutoEscaper_Sample
{
    public $property = '<b>property</b>';

    public function getString()
    {
        return '<b>getString</b>';
    }

    public function getArray()
    {
        return array('<b>getArray1</b>', '<b>getArray2</b>');
    }

    public function getObject()
    {
        return new Gnix_View_AutoEscaper_Sample_Child();
    }
}

class Gnix_View_AutoEscaper_Sample_Child
{
    public $property = '<b>child property</b>';

    public function getString()
    {
        return '<b>child getString</b>';
    }

    public function getArray()
    {
        return array('<b>child getArray1</b>', '<b>child getArray2</b>');
    }
}

class Gnix_View_AutoEscaper_Sample_Escaper_Wrong
{
}

class Gnix_View_AutoEscaper_Sample_Escaper implements Gnix_View_AutoEscaper_Escaper_Interface
{
    public function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    public function unescape($value)
    {
        return htmlspecialchars_decode($value, ENT_QUOTES) . '-customized';
    }
}
