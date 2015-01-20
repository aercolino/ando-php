<?php

class Ando_ErrorFactoryTest
        extends PHPUnit_Framework_TestCase
{
    protected
    function assertSameValues( $expected, $actual )
    {
        $lacks = array_diff($expected, $actual);
        $extra = array_diff($actual, $expected);
        $this->assertEmpty(array_merge($lacks, $extra));
    }

    protected
    function select_error( $key, $value )
    {
        return strpos($key, 'E_') === 0
                ? $value
                : null;
    }

    public
    function test_all_errors()
    {
        $constants = get_defined_constants();
        $errors    = array_filter(array_map(array($this, 'select_error'), array_keys($constants),
                array_values($constants)));
        $expected  = array_diff($errors, array(E_ALL));

        $actual = Ando_ErrorFactory::all_errors();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_all_errors_to_str()
    {
        $constants = get_defined_constants();
        $errors    = array_filter(array_map(array($this, 'select_error'), array_keys($constants),
                array_keys($constants)));
        $expected  = array_diff($errors, array('E_ALL'));

        $actual = Ando_ErrorFactory::all_errors_to_str();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_non_catchable_errors()
    {
        $expected = array(
                E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING
        );
        $actual   = Ando_ErrorFactory::non_catchable_errors();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_non_shutdown_errors()
    {
        $expected = array(
                E_WARNING, E_PARSE, E_NOTICE, E_CORE_WARNING, E_COMPILE_WARNING, E_USER_WARNING, E_USER_NOTICE,
                E_STRICT, E_DEPRECATED, E_USER_DEPRECATED
        );
        $actual   = Ando_ErrorFactory::non_shutdown_errors();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_catchable_errors()
    {
        $expected = array(
                E_WARNING, E_NOTICE, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, E_STRICT, E_RECOVERABLE_ERROR,
                E_DEPRECATED, E_USER_DEPRECATED
        );
        $actual   = Ando_ErrorFactory::catchable_errors();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_shutdown_errors()
    {
        $expected = array(
                E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_RECOVERABLE_ERROR, E_USER_ERROR
        );
        $actual   = Ando_ErrorFactory::shutdown_errors();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_non_catchable_non_shutdown_errors()
    {
        $expected = array(
                E_PARSE, E_CORE_WARNING, E_COMPILE_WARNING
        );
        $actual   = Ando_ErrorFactory::non_catchable_non_shutdown_errors();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_non_catchable_shutdown_errors()
    {
        $expected = array(
                E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR
        );
        $actual   = Ando_ErrorFactory::non_catchable_shutdown_errors();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_catchable_non_shutdown_errors()
    {
        $expected = array(
                E_WARNING, E_NOTICE, E_USER_WARNING, E_USER_NOTICE, E_STRICT, E_DEPRECATED, E_USER_DEPRECATED
        );
        $actual   = Ando_ErrorFactory::catchable_non_shutdown_errors();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_catchable_shutdown_errors()
    {
        $expected = array(
                E_RECOVERABLE_ERROR, E_USER_ERROR
        );
        $actual   = Ando_ErrorFactory::catchable_shutdown_errors();
        $this->assertSameValues($expected, $actual);
    }

    public
    function test_to_str()
    {
        $expected = Ando_ErrorFactory::all_errors_to_str();
        $actual   = Ando_ErrorFactory::to_str(Ando_ErrorFactory::all_errors());
        $this->assertSameValues($expected, $actual);

        $this->assertEquals('E_ERROR', Ando_ErrorFactory::to_str(E_ERROR));
    }

    public
    function test_to_int()
    {
        $expected = Ando_ErrorFactory::all_errors();
        $actual   = Ando_ErrorFactory::to_int(Ando_ErrorFactory::all_errors_to_str());
        $this->assertSameValues($expected, $actual);

        $this->assertEquals(E_ERROR, Ando_ErrorFactory::to_int('E_ERROR'));
    }

    public
    function test_to_mask()
    {
        $expected = E_ALL;
        $actual   = Ando_ErrorFactory::to_mask(Ando_ErrorFactory::all_errors());
        $this->assertEquals($expected, $actual);

        $this->assertEquals(E_ERROR, Ando_ErrorFactory::to_mask(E_ERROR));
    }

    public
    function test_to_array()
    {
        $expected = Ando_ErrorFactory::all_errors();
        $actual   = Ando_ErrorFactory::to_array(E_ALL);
        $this->assertSameValues($expected, $actual);

        $this->assertEquals(array(E_ERROR), Ando_ErrorFactory::to_array(E_ERROR));
    }

    // -----------------------------------------------------------------------------------------------------------------
    // Ando_ErrorFactory::catchable_errors():
    //   E_WARNING,
    //   E_NOTICE,
    //   E_USER_ERROR,
    //   E_USER_WARNING,
    //   E_USER_NOTICE,
    //   E_STRICT,
    //   E_RECOVERABLE_ERROR,
    //   E_DEPRECATED,
    //   E_USER_DEPRECATED

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionCode E_WARNING
     */
    public
    function test_E_WARNING()
    {
        Ando_ErrorFactory::E_WARNING();
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionCode E_NOTICE
     */
    public
    function test_E_NOTICE()
    {
        Ando_ErrorFactory::E_NOTICE();
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionCode E_USER_ERROR
     */
    public
    function test_E_USER_ERROR()
    {
        Ando_ErrorFactory::E_USER_ERROR();
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionCode E_USER_WARNING
     */
    public
    function test_E_USER_WARNING()
    {
        Ando_ErrorFactory::E_USER_WARNING();
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionCode E_USER_NOTICE
     */
    public
    function test_E_USER_NOTICE()
    {
        Ando_ErrorFactory::E_USER_NOTICE();
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionCode E_STRICT
     */
    public
    function test_E_STRICT()
    {
        Ando_ErrorFactory::E_STRICT();
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionCode E_RECOVERABLE_ERROR
     */
    public
    function test_E_RECOVERABLE_ERROR()
    {
        Ando_ErrorFactory::E_RECOVERABLE_ERROR();
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionCode E_DEPRECATED
     */
    public
    function test_E_DEPRECATED()
    {
        Ando_ErrorFactory::E_DEPRECATED();
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionCode E_USER_DEPRECATED
     */
    public
    function test_E_USER_DEPRECATED()
    {
        Ando_ErrorFactory::E_USER_DEPRECATED();
    }

    // -----------------------------------------------------------------------------------------------------------------
    // For the following errors, which by definition are non catchable, @runInSeparateProcess allows testing to continue
    // but I couldn't find any way to signal to PHPUnit that I'm expecting those errors, so they are marked 'E', not '.'
    //
    // Ando_ErrorFactory::non_catchable_errors():
    //   E_ERROR,
    //   E_PARSE,
    //   E_CORE_ERROR,
    //   E_CORE_WARNING,
    //   E_COMPILE_ERROR,
    //   E_COMPILE_WARNING

//    /**
//     * @runInSeparateProcess
//     * @expectedException PHPUnit_Framework_Exception
//     * @expectedExceptionCode E_ERROR
//     */
//    public
//    function test_E_ERROR()
//    {
//        Ando_ErrorFactory::E_ERROR();
//    }

}
