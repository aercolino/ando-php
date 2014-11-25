<?php

class Ando_RegexTest
        extends PHPUnit_Framework_TestCase
{

    public
    function test_different_delimiters_tilde_must_match_tilde()
    {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before));
        $this->assertEquals(1, preg_match($after, $subject, $matches_after));
        $this->assertEquals($matches_before, $matches_after);
    }

    public
    function test_different_delimiters_1_slash_tilde_means_literal_tilde_must_match_tilde()
    {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before));
        $this->assertEquals(1, preg_match($after, $subject, $matches_after));
        $this->assertEquals($matches_before, $matches_after);
    }

    public
    function test_different_delimiters_2_slashes_tilde_mean_literal_tilde_must_match_tilde()
    {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before));
        $this->assertEquals(1, preg_match($after, $subject, $matches_after));
        $this->assertEquals($matches_before, $matches_after);
    }

    public
    function test_different_delimiters_3_slashes_tilde_mean_1_slash_tilde_must_not_match_tilde()
    {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before));
        $this->assertEquals(0, preg_match($after, $subject, $matches_after));
    }

    public
    function test_different_delimiters_4_slashes_tildes_mean_1_slash_tilde_must_not_match_tilde()
    {
        $subject = 'aaa~bbb';  // this means: a a a ~ b b b
        $before = '@a\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before));
        $this->assertEquals(0, preg_match($after, $subject, $matches_after));
    }

    //---

    public
    function test_different_delimiters_tilde_must_not_match_1_slash_tilde()
    {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before), 'subject with 1 slash');
        $this->assertEquals(0, preg_match($after, $subject, $matches_after), 'subject with 1 slash');

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before), 'subject with 2 slashes');
        $this->assertEquals(0, preg_match($after, $subject, $matches_after), 'subject with 2 slashes');
    }

    public
    function test_different_delimiters_1_slash_tilde_means_literal_tilde_must_not_match_1_slash_tilde()
    {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before), 'subject with 1 slash');
        $this->assertEquals(0, preg_match($after, $subject, $matches_after), 'subject with 1 slash');

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before), 'subject with 2 slashes');
        $this->assertEquals(0, preg_match($after, $subject, $matches_after), 'subject with 2 slashes');
    }

    public
    function test_different_delimiters_2_slashes_tilde_mean_literal_tilde_must_not_match_1_slash_tilde()
    {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before), 'subject with 1 slash');
        $this->assertEquals(0, preg_match($after, $subject, $matches_after), 'subject with 1 slash');

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before), 'subject with 2 slashes');
        $this->assertEquals(0, preg_match($after, $subject, $matches_after), 'subject with 2 slashes');
    }

    public
    function test_different_delimiters_3_slashes_tilde_mean_1_slash_tilde_must_match_1_slash_tilde()
    {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 1 slash');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 1 slash');
        $this->assertEquals($matches_before, $matches_after, 'subject with 1 slash');

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 2 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 2 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 2 slashes');
    }

    public
    function test_different_delimiters_4_slashes_tilde_mean_1_slash_tilde_must_match_1_slash_tilde()
    {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 1 slash');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 1 slash');
        $this->assertEquals($matches_before, $matches_after, 'subject with 1 slash');

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 2 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 2 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 2 slashes');
    }

    public
    function test_different_delimiters_5_slashes_tilde_mean_1_slash_tilde_must_match_1_slash_tilde()
    {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 1 slash');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 1 slash');
        $this->assertEquals($matches_before, $matches_after, 'subject with 1 slash');

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 2 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 2 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 2 slashes');
    }

    public
    function test_different_delimiters_6_slashes_tilde_mean_1_slash_tilde_must_match_1_slash_tilde()
    {
        $subject = 'aaa\~bbb';  // this means: a a a \ ~ b b b
        $before = '@a\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 1 slash');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 1 slash');
        $this->assertEquals($matches_before, $matches_after, 'subject with 1 slash');

        $subject = 'aaa\\~bbb';  // this too means: a a a \ ~ b b b
        $before = '@a\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 2 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 2 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 2 slashes');
    }

    //---

    public
    function test_different_delimiters_7_slashes_tilde_mean_2_slashes_tilde_must_match_2_slashes_tilde()
    {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 3 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 3 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 3 slashes');

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 4 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 4 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 4 slashes');
    }

    public
    function test_different_delimiters_8_slashes_tilde_mean_2_slashes_tilde_must_match_2_slashes_tilde()
    {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 3 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 3 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 3 slashes');

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 4 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 4 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 4 slashes');
    }

    public
    function test_different_delimiters_9_slashes_tilde_mean_2_slashes_tilde_must_match_2_slashes_tilde()
    {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 3 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 3 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 3 slashes');

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 4 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 4 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 4 slashes');
    }

    public
    function test_different_delimiters_10_slashes_tilde_mean_2_slashes_tilde_must_match_2_slashes_tilde()
    {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 3 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 3 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 3 slashes');

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(1, preg_match($before, $subject, $matches_before), 'subject with 4 slashes');
        $this->assertEquals(1, preg_match($after, $subject, $matches_after), 'subject with 4 slashes');
        $this->assertEquals($matches_before, $matches_after, 'subject with 4 slashes');
    }

    // Infinity is too much!!  We stop at 11 mean 3 mustn't match 2.
    public
    function test_different_delimiters_11_slashes_tilde_mean_3_slashes_tilde_must_not_match_2_slashes_tilde()
    {
        $subject = 'aaa\\\~bbb';  // this means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before), 'subject with 3 slashes');
        $this->assertEquals(0, preg_match($after, $subject, $matches_after), 'subject with 3 slashes');

        $subject = 'aaa\\\\~bbb';  // this too means: a a a \ \ ~ b b b
        $before = '@a\\\\\\\\\\\~b@';
        $after = Ando_Regex::wrap(Ando_Regex::unwrap($before), '~~');

        $this->assertEquals(0, preg_match($before, $subject, $matches_before), 'subject with 4 slashes');
        $this->assertEquals(0, preg_match($after, $subject, $matches_after), 'subject with 4 slashes');
    }

    //---

    public
    function test_interpolate_multiple_levels()
    {
        $before = '(?:.*?<br>)*.*?';
        $nest = '(?<start><(?<tag>\w+).*?' . '>)(?<nested>.*?)(?<end></\2>)';
        $empty = '(<!--.*?-->|<!DOCTYPE\b.*?' . '>|<\w+.*?' . '>)';

        $actual = new Ando_Regex('$before(?:$nest|$empty)', '@@s');
        $actual->interpolate(array(
                                     'before' => Ando_Regex::def('(?<before>$before)', null)
                                                           ->interpolate(array('before' => $before)),
                                     'nest'   => Ando_Regex::def('(?<nest>$nest)', null)
                                                           ->interpolate(array('nest' => $nest)),
                                     'empty'  => Ando_Regex::def('(?<empty>$empty)', null)
                                                           ->interpolate(array('empty' => $empty)),
                             ));
        $expected = '@(?<before>(?:.*?<br>)*.*?)(?:(?<nest>(?<start><(?<tag>\w+).*?>)(?<nested>.*?)(?<end></\4>))|(?<empty>(<!--.*?-->|<!DOCTYPE\b.*?>|<\w+.*?>)))@s';
        $this->assertEquals($expected, (string) $actual);
    }

    public
    function test_wrong_regex_is_not_matchable()
    {
        $this->assertFalse(Ando_Regex::is_valid('@@o'));
    }

    public
    function test_always_matching_regex_is_valid()
    {
        $this->assertTrue(Ando_Regex::is_valid('@@'));
    }

    public
    function test_never_matching_regex_is_valid()
    {
        $this->assertTrue(Ando_Regex::is_valid('@$^@'));
    }

    public
    function test_pattern_quoted_string()
    {
        $default = Ando_Regex::pattern_quoted_string();
        $this->assertEquals("'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'", $default);

        $single = "\$whatever = 'Not a \'double quoted string\' here';";
        $this->assertEquals(1, preg_match("@$default@", $single, $matches));
        $this->assertEquals("'Not a \'double quoted string\' here'", $matches[0]);
    }

    public
    function test_count_captures()
    {
        $count = Ando_Regex::count_matches('aaa\(bbb\)ccc[(x)]ddd');
        $this->assertEquals(0, $count['numbered']);
        $this->assertEquals(0, $count['named']);

        $count = Ando_Regex::count_matches('(?<before>(?:.*?<br>)*.*?)(?:(?<nest>(?<start><(?<tag>\w+).*?>)(?<nested>.*?)(?<end></\4>))|(?<empty>(<!--.*?-->|<!DOCTYPE\b.*?>|<\w+.*?>)))');
        $this->assertEquals(8, $count['numbered']);
        $this->assertEquals(7, $count['named']);
    }

    public
    function test_interpolate_ignores_escaped_variables()
    {
        $r = Ando_Regex::def('aa\$bb$cc', null)
                       ->interpolate(array(
                                             'aa' => '1',
                                             'bb' => '2',
                                             'cc' => '3',
                                     ));
        $this->assertEquals('aa\$bb3', $r->expression());
    }

    public
    function test_interpolate_adjusts_current_backreferences()
    {
        $r = Ando_Regex::def('(aa)$b(cc)\1', null)
                       ->interpolate(array('b' => '(bb)\1'));
        $this->assertEquals('(aa)(bb)\2(cc)\1', $r->expression());
    }

    /**
     * Issue #13
     */
    public
    function test_interpolate_adjusts_remaining_backreferences()
    {
        $r = Ando_Regex::def('(aa)$b(cc)\1\2', null)
                       ->interpolate(array('b' => '(bb)'));
        $this->assertEquals('(aa)(bb)(cc)\1\3', $r->expression());
    }

    /**
     * Issue #14
     */
    public function test_partial_interpolation() {
        $r = Ando_Regex::def('(aa)$b(cc)$d', null)
                       ->interpolate(array('d' => '(dd)'));
        $this->assertEquals('(aa)$b(cc)(dd)', $r->expression());
        $r->interpolate(array('b' => '(bb)'));
        $this->assertEquals('(aa)(bb)(cc)(dd)', $r->expression());
    }

}
