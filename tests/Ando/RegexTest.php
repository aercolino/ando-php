<?php
require dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR . 'Ando' . DIRECTORY_SEPARATOR . 'Regex.php';

class Ando_RegexTest extends PHPUnit_Framework_TestCase {

    public function test_different_delimiters_tilde_must_match_tilde() {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ) );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ) );
        $this->assertEquals( $matches_before, $matches_after );
    }

    public function test_different_delimiters_1_slash_tilde_means_literal_tilde_must_match_tilde() {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ) );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ) );
        $this->assertEquals( $matches_before, $matches_after );
    }

    public function test_different_delimiters_2_slashes_tilde_mean_literal_tilde_must_match_tilde() {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ) );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ) );
        $this->assertEquals( $matches_before, $matches_after );
    }

    public function test_different_delimiters_3_slashes_tilde_mean_1_slash_tilde_must_not_match_tilde() {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ) );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ) );
    }

    public function test_different_delimiters_4_slashes_tildes_mean_1_slash_tilde_must_not_match_tilde() {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ) );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ) );
    }

    //---

    public function test_different_delimiters_tilde_must_not_match_1_slash_tilde() {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ), 'subject with 1 slash' );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ), 'subject with 1 slash' );

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ), 'subject with 2 slashes' );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ), 'subject with 2 slashes' );
    }

    public function test_different_delimiters_1_slash_tilde_means_literal_tilde_must_not_match_1_slash_tilde() {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ), 'subject with 1 slash' );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ), 'subject with 1 slash' );

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ), 'subject with 2 slashes' );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ), 'subject with 2 slashes' );
    }

    public function test_different_delimiters_2_slashes_tilde_mean_literal_tilde_must_not_match_1_slash_tilde() {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ), 'subject with 1 slash' );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ), 'subject with 1 slash' );

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ), 'subject with 2 slashes' );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ), 'subject with 2 slashes' );
    }

    public function test_different_delimiters_3_slashes_tilde_mean_1_slash_tilde_must_match_1_slash_tilde() {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 1 slash' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 1 slash' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 1 slash' );

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 2 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 2 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 2 slashes' );
    }

    public function test_different_delimiters_4_slashes_tilde_mean_1_slash_tilde_must_match_1_slash_tilde() {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 1 slash' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 1 slash' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 1 slash' );

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 2 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 2 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 2 slashes' );
    }

    public function test_different_delimiters_5_slashes_tilde_mean_1_slash_tilde_must_match_1_slash_tilde() {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 1 slash' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 1 slash' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 1 slash' );

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 2 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 2 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 2 slashes' );
    }

    public function test_different_delimiters_6_slashes_tilde_mean_1_slash_tilde_must_match_1_slash_tilde() {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 1 slash' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 1 slash' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 1 slash' );

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 2 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 2 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 2 slashes' );
    }

    //---

    public function test_different_delimiters_7_slashes_tilde_mean_2_slashes_tilde_must_match_2_slashes_tilde() {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 3 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 3 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 3 slashes' );

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 4 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 4 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 4 slashes' );
    }

    public function test_different_delimiters_8_slashes_tilde_mean_2_slashes_tilde_must_match_2_slashes_tilde() {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 3 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 3 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 3 slashes' );

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 4 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 4 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 4 slashes' );
    }

    public function test_different_delimiters_9_slashes_tilde_mean_2_slashes_tilde_must_match_2_slashes_tilde() {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 3 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 3 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 3 slashes' );

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 4 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 4 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 4 slashes' );
    }

    public function test_different_delimiters_10_slashes_tilde_mean_2_slashes_tilde_must_match_2_slashes_tilde() {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 3 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 3 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 3 slashes' );

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 1, preg_match( $before, $subject, $matches_before ), 'subject with 4 slashes' );
        $this->assertEquals( 1, preg_match( $after, $subject, $matches_after ), 'subject with 4 slashes' );
        $this->assertEquals( $matches_before, $matches_after, 'subject with 4 slashes' );
    }

    // Infinity is too much!!  We stop at 11 mean 3 mustn't match 2.
    public function test_different_delimiters_11_slashes_tilde_mean_3_slashes_tilde_must_not_match_2_slashes_tilde() {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ), 'subject with 3 slashes' );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ), 'subject with 3 slashes' );

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\\\~b@';
        $after  = Ando_Regex::wrap( Ando_Regex::unwrap( $before ), '~~' );

        $this->assertEquals( 0, preg_match( $before, $subject, $matches_before ), 'subject with 4 slashes' );
        $this->assertEquals( 0, preg_match( $after, $subject, $matches_after ), 'subject with 4 slashes' );
    }

    //---

    public function test_interpolated_variables() {
        $before = '(?:.*?<br>)*.*?';
        $nest   = '(?<start><(?<tag>\w+).*?' . '>)(?<nested>.*?)(?<end></\2>)';
        $empty  = '(<!--.*?-->|<!DOCTYPE\b.*?' . '>|<\w+.*?' . '>)';

        $actual = new Ando_Regex( '$before(?:$nest|$empty)', '@@s' );
        $actual->interpolate( array(
            'before' => Ando_Regex::create( '(?<before>$before)' )->interpolate( array( 'before' => $before ) )->expression(),
            'nest'   => Ando_Regex::create( '(?<nest>$nest)'     )->interpolate( array( 'nest'   => $nest   ) )->expression(),
            'empty'  => Ando_Regex::create( '(?<empty>$empty)'   )->interpolate( array( 'empty'  => $empty  ) )->expression(),
        ) );
        $expected = '@(?<before>(?:.*?<br>)*.*?)(?:(?<nest>(?<start><(?<tag>\w+).*?>)(?<nested>.*?)(?<end></\4>))|(?<empty>(<!--.*?-->|<!DOCTYPE\b.*?>|<\w+.*?>)))@s';
        $this->assertEquals( $expected, $actual );
    }

    public function test_wrong_regex_is_not_matchable() {
        $this->assertFalse( Ando_Regex::is_matchable( '@@o' ) );
    }

    public function test_always_matching_regex_is_matchable() {
        $this->assertTrue( Ando_Regex::is_matchable( '@@' ) );
    }

    public function test_never_matching_regex_is_matchable() {
        $this->assertTrue( Ando_Regex::is_matchable( '@$^@' ) );
    }

    public function test_pattern_quoted_string() {
        $default = Ando_Regex::pattern_quoted_string();
        $this->assertEquals( "'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'", $default );

        $single = "\$whatever = 'Not a \'double quoted string\' here';";
        $this->assertEquals( 1, preg_match( "@$default@", $single, $matches ) );
        $this->assertEquals( "'Not a \'double quoted string\' here'", $matches[0] );
    }

}
