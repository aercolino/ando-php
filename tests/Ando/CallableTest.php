<?php

class Ando_CallableTest extends PHPUnit_Framework_TestCase {

    // callback
    public function cb_one( $first ) {
        return $first;
    }

    public function test_no_proxy_used_for_no_options() {
        $cb = Ando_Callable::def( array( $this, 'cb_one' ) );
        $this->assertTrue( is_callable( $cb ) );

        $this->assertEquals( array( $this, 'cb_one' ), $cb );
    }

    public function test_proxy_used_for_options_even_just_a_null() {
        $cb = Ando_Callable::def( array($this, 'cb_one'), array( null ) );
        $this->assertTrue(is_callable($cb));

        list( $object, $method ) = $cb;
        $this->assertInstanceOf( 'Ando_Callable', $object );
        $this->assertEquals( 'run', $method );
    }


    // callback
    public function cb_two( $first, $second ) {
        return $first . ' ' . $second;
    }

    public function test_proxy_used_for_options() {
        $cb = Ando_Callable::def( array( $this, 'cb_two' ), array( 'extra' => array( 'hey' ) ) );
        $this->assertTrue( is_callable( $cb ) );

        list( $object, $method ) = $cb;
        $this->assertInstanceOf( 'Ando_Callable', $object );
        $this->assertEquals( 'run', $method );

        $result = call_user_func( $cb, 'there' );
        $this->assertEquals( 'hey there', $result );
    }

    public function test_all_built_in_pieces() {
        $f = new Ando_Callable( null );
        $f->setCallback( array( $this, 'cb_two' ) );
        $f->setOptions( array( 'extra' => array( 'hey' ) ) );
        $f->setOptions( array( 'order' => '1' ) );
        $cb = $f->ref();
        $this->assertTrue( is_callable( $cb ) );

        list( $object, $method ) = $cb;
        $this->assertInstanceOf( 'Ando_Callable', $object );
        $this->assertEquals( 'run', $method );

        $result = call_user_func( $cb, 'there' );
        $this->assertEquals( 'there hey', $result );
    }


    // callback
    public function compress_word( $start, $body, $end, $max_chars ) {
        $args = func_get_args();
        $this->assertEquals( 4, count( $args ) );

        if ( strlen( $body ) + 2 > $max_chars ) {
            return $start . strlen($body) . $end;
        } else {
            return $start . $body . $end;
        }
    }

    public function test_extra_splat_remove_order() {
        $callable = Ando_Callable::def( array( $this, 'compress_word' ), array(
            'extra'  => array(3),   // this is the item at index 0 which 'order' refers to
            'splat'  => true,
            'remove' => '0',        // these are indexes into run-time arguments (the 0 here is unrelated to the next)
            'order'  => '1 2 3 0',  // these are indexes into prepared plus run-time non-removed arguments
        ));
        $result = preg_replace_callback( '@(\w)(\w*)(\w)@', $callable, 'internationalization and localization' );
        $this->assertEquals( 'i18n and l10n', $result );
    }

    public function test_extra_splat_retain_order() {
        $callable = Ando_Callable::def( array( $this, 'compress_word' ), array(
            'extra'  => array(3),   // this is the item at index 0 which 'order' refers to
            'splat'  => true,
            'retain' => '1-',       // these are indexes into run-time arguments (the 0 here is unrelated to the next)
            'order'  => '1 2 3 0',  // these are indexes into prepared plus run-time non-removed arguments
        ));
        $result = preg_replace_callback( '@(\w)(\w*)(\w)@', $callable, 'internationalization and localization' );
        $this->assertEquals( 'i18n and l10n', $result );
    }

}
