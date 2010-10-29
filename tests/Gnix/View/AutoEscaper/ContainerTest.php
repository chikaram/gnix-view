<?php
require_once '/path/to/gnix-view/tests/init.php';

class Gnix_View_AutoEscaper_ContainerTest extends PHPUnit_Extensions_OutputTestCase
{
    /**
     * Sets up
     */
    protected function setUp()
    {
        // Initializing Gnix_View_AutoEscaper
        new Gnix_View_AutoEscaper();
    }

    public function test()
    {
        $this->assertTrue(true);
    }

    public function testString()
    {
        $container = new Gnix_View_AutoEscaper_Container('<b>A</b>');
        $this->assertType('Gnix_View_AutoEscaper_Container', $container);

        $this->expectOutputString('&lt;b&gt;A&lt;/b&gt;');
        echo $container;
    }

    public function testArray()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(null, false, true, 1, 1.1, 'a', '<b>A</b>'));
        $this->assertType('Gnix_View_AutoEscaper_Container', $container);

        $this->expectOutputString('' . '' . '1' . '1' . '1.1' . 'a' . '&lt;b&gt;A&lt;/b&gt;');
        foreach ($container as $value) {
            echo $value;
        }
    }

    public function testArrayCount()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(1, 2, 3, 4, 5, 6, 7, 8));

        $this->assertSame(8, count($container));
    }

    public function testArrayAccess()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(
            'a' => '<b>apple</b>',
            'c' => '<b>cookie</b>',
            'e' => '<b>elbow</b>',
        ));

        $this->expectOutputString('&lt;b&gt;apple&lt;/b&gt; &lt;b&gt;elbow&lt;/b&gt;');
        echo $container['a'] . ' ' . $container['e'];
    }

    public function testArrayAccess2()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(
            'a' => '<b>apple</b>',
            'c' => '<b>cookie</b>',
            'e' => null,
        ));

        $this->assertTrue(isset($container['a']));
        $this->assertFalse(isset($container['b']));
        $this->assertTrue(isset($container['c']));
        $this->assertFalse(isset($container['d']));
        $this->assertTrue(isset($container['e']));
    }

    /**
     * @expectedException Gnix_View_AutoEscaper_Exception
     */
    public function testArrayAccess3()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(
            'a' => '<b>apple</b>',
            'c' => '<b>cookie</b>',
            'e' => null,
        ));

        $container['b'] = 'baby';
    }

    /**
     * @expectedException Gnix_View_AutoEscaper_Exception
     */
    public function testArrayAccess4()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(
            'a' => '<b>apple</b>',
            'c' => '<b>cookie</b>',
            'e' => null,
        ));

        unset($container['e']);
    }

    public function testArrayArray()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(
            array('A', '<b>B</b>', 'C'),
            array('<b>A</b>', 'B', '<b>C</b>'),
        ));

        $this->expectOutputString('A' . '&lt;b&gt;B&lt;/b&gt;' . 'C' . '&lt;b&gt;A&lt;/b&gt;' .  'B' . '&lt;b&gt;C&lt;/b&gt;');
        foreach ($container as $value) {
            foreach ($value as $value2) {
                echo $value2;
            }
        }
    }

    public function testArrayArrayCount()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(
            array(1, 2, 3),
            array(1, 2, 3, 4, 5, 6),
            array(1, 2, 3, 4, 5, 6, 7, 8, 9),
            array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
        ));

        $this->assertSame(4, count($container));
        $this->assertSame(3, count($container[0]));
        $this->assertSame(6, count($container[1]));
        $this->assertSame(9, count($container[2]));
    }

    public function testArrayArrayAccess()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(
            array('a' => '<b>apple</b>'),
            array('c' => '<b>cookie</b>'),
            array('e' => '<b>elbow</b>'),
        ));

        $this->expectOutputString('&lt;b&gt;apple&lt;/b&gt; &lt;b&gt;elbow&lt;/b&gt;');
        echo $container[0]['a'] . ' ' . $container[2]['e'];
    }

    public function testObject()
    {
        $container = new Gnix_View_AutoEscaper_Container(new Gnix_View_AutoEscaper_Container_Sample());
        $this->assertType('Gnix_View_AutoEscaper_Container', $container);

        $this->expectOutputString('&lt;b&gt;property&lt;/b&gt;');
        echo $container->property;
    }

    /**
     * @expectedException Gnix_View_AutoEscaper_Exception
     */
    public function testObject2()
    {
        $container = new Gnix_View_AutoEscaper_Container(new Gnix_View_AutoEscaper_Container_Sample());

        $container->property = 'override';
    }

    public function testObject3()
    {
        $container = new Gnix_View_AutoEscaper_Container(new Gnix_View_AutoEscaper_Container_Sample());

        $this->expectOutputString('&lt;b&gt;getString&lt;/b&gt;');
        echo $container->getString();
    }

    public function testObjectObject()
    {
        $container = new Gnix_View_AutoEscaper_Container(new Gnix_View_AutoEscaper_Container_Sample());

        $this->expectOutputString('&lt;b&gt;child property&lt;/b&gt;');
        echo $container->getObject()->property;
    }

    public function testObjectObject2()
    {
        $container = new Gnix_View_AutoEscaper_Container(new Gnix_View_AutoEscaper_Container_Sample());

        $this->expectOutputString('&lt;b&gt;child getString&lt;/b&gt;');
        echo $container->getObject()->getString();
    }

    public function testArrayObject()
    {
        $container = new Gnix_View_AutoEscaper_Container(array(
            new Gnix_View_AutoEscaper_Container_Sample(),
            new Gnix_View_AutoEscaper_Container_Sample(),
            new Gnix_View_AutoEscaper_Container_Sample()
        ));

        $this->expectOutputString(str_repeat('&lt;b&gt;child getString&lt;/b&gt;', 3));
        foreach ($container as $value) {
            echo $value->getObject()->getString();
        }
    }

    public function testObjectArray()
    {
        $container = new Gnix_View_AutoEscaper_Container(new Gnix_View_AutoEscaper_Container_Sample());

        $this->expectOutputString('&lt;b&gt;child getArray1&lt;/b&gt;&lt;b&gt;child getArray2&lt;/b&gt;');
        foreach ($container->getObject()->getArray() as $value) {
            echo $value;
        }
    }

    public function testComplex()
    {
        $this->markTestSkipped();
    }
}

/**
 * Classes for testing Gnix_View_AutoEscaperTest
 */
class Gnix_View_AutoEscaper_Container_Sample
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
        return new Gnix_View_AutoEscaper_Container_Sample_Child();
    }
}

class Gnix_View_AutoEscaper_Container_Sample_Child
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
