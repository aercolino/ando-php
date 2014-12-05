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

    /**
     * Issue #13
     */
    public
    function test_numbered_backreferences_supported() {
        $r = Ando_Regex::def('(aa)$b(cc)\1', null)
                       ->interpolate(array('b' => '(bb)\1'));
        $this->assertEquals('(aa)(bb)\2(cc)\1', $r->expression());

        $r = Ando_Regex::def('(aa)$b(cc)\1\2', null)
                       ->interpolate(array('b' => '(bb)'));
        $this->assertEquals('(aa)(bb)(cc)\1\3', $r->expression());
    }

    /**
     * Issue #14
     */
    public
    function test_partial_interpolation()
    {
        $r = Ando_Regex::def('(aa)$b(cc)$d', null)
                       ->interpolate(array('d' => '(dd)'));
        $this->assertEquals('(aa)$b(cc)(dd)', $r->expression());

        $r->interpolate(array('b' => '(bb)'));
        $this->assertEquals('(aa)(bb)(cc)(dd)', $r->expression());
    }

    /**
     * Issue #9
     */
    public
    function test_non_capturing_groups()
    {
        $r = Ando_Regex::def('(?:aa)$b(cc)\1', null)
                       ->interpolate(array('b' => '(bb)\1'));
        $this->assertEquals('(?:aa)(bb)\1(cc)\2', $r->expression());

        $r = Ando_Regex::def('(?:(?i)aa)$b(cc)\1', null)
                       ->interpolate(array('b' => '(bb)\1'));
        $this->assertEquals('(?:(?i)aa)(bb)\1(cc)\2', $r->expression());

        $r = Ando_Regex::def('(?i:aa)$b(cc)\1', null)
                       ->interpolate(array('b' => '(bb)\1'));
        $this->assertEquals('(?i:aa)(bb)\1(cc)\2', $r->expression());
    }

    /**
     * Issue #8 (middle)
     */
    public
    function test_comments_are_ignored_in_the_middle()
    {
        $r = Ando_Regex::def('(?#a(a)$b(cc)\1', null)
                       ->interpolate(array('b' => '(bb)\1'));
        $this->assertEquals('(?#)(bb)\1(cc)\2', $r->expression());
    }

    /**
     * Issue #8 (end)
     */
    public
    function test_comments_are_ignored_at_the_end_of_the_line()
    {
        $r = Ando_Regex::def('aa $b # comment (aa)
        $c (dd)', '@@' . Ando_Regex::PCRE_EXTENDED_MODIFIER)
                       ->interpolate(array('b' => '(bb)\1', 'c' => '(cc)\1'));
        $this->assertEquals('aa (bb)\1 (?#)
        (cc)\2 (dd)', $r->expression());
    }

    /**
     * Issue #6
     */
    public
    function test_named_groups_supported()
    {
        // These tests only confirm that named_groups are counted as numbered groups too.

        $r = Ando_Regex::def('(aa)(?P<name>pattern)$bb', null)
                       ->interpolate(array('bb' => '(bb)\1'));
        $this->assertEquals('(aa)(?P<name>pattern)(bb)\3', $r->expression());

        $r = Ando_Regex::def('(aa)(?<name>pattern)$bb', null)
                       ->interpolate(array('bb' => '(bb)\1'));
        $this->assertEquals('(aa)(?<name>pattern)(bb)\3', $r->expression());

        // using double quotes instead of single ones only to properly show the naming type
        // IN GENERAL it's a bad idea to use double quotes because they confuse a lot...
        $r = Ando_Regex::def("(aa)(?'name'pattern)\$bb", null)
                       ->interpolate(array('bb' => '(bb)\1'));
        $this->assertEquals("(aa)(?'name'pattern)(bb)\\3", $r->expression());
    }

    /**
     * Issue #2
     */
    public
    function test_self_backreferences_supported()
    {
        $r = Ando_Regex::def('(aa)($bb)(cc)(a|b\4)+', null)
                       ->interpolate(array('bb' => '(a|b\1)+'));
        $this->assertEquals('(aa)((a|b\3)+)(cc)(a|b\5)+', $r->expression());
    }

    /**
     * Issue #7
     */
    public
    function test_named_backreferences_supported()
    {
        // These tests only confirm that named_backreferences are ignored when counting groups.

        $r = Ando_Regex::def('(aa)(?P<name>pattern)(bb)(?P=name)$cc', null)
                       ->interpolate(array('cc' => '(cc)\1'));
        $this->assertEquals('(aa)(?P<name>pattern)(bb)(?P=name)(cc)\4', $r->expression());

        $r = Ando_Regex::def('(aa)(?<name>pattern)(bb)\k<name>$cc', null)
                       ->interpolate(array('cc' => '(cc)\1'));
        $this->assertEquals('(aa)(?<name>pattern)(bb)\k<name>(cc)\4', $r->expression());

        $r = Ando_Regex::def('(aa)(?\'name\'pattern)(bb)\k\'name\'$cc', null)
                       ->interpolate(array('cc' => '(cc)\1'));
        $this->assertEquals('(aa)(?\'name\'pattern)(bb)\k\'name\'(cc)\4', $r->expression());

        $r = Ando_Regex::def('(aa)(?<name>pattern)(bb)\k{name}$cc', null)
                       ->interpolate(array('cc' => '(cc)\1'));
        $this->assertEquals('(aa)(?<name>pattern)(bb)\k{name}(cc)\4', $r->expression());

        $r = Ando_Regex::def('(aa)(?<name>pattern)(bb)\g{name}$cc', null)
                       ->interpolate(array('cc' => '(cc)\1'));
        $this->assertEquals('(aa)(?<name>pattern)(bb)\g{name}(cc)\4', $r->expression());
    }

    /**
     * Issue #5
     */
    public
    function test_lexical_numbered_backreferences_supported()
    {
        $r = Ando_Regex::def('$aa (sens|respons)e and (?1)ibility', null)
                       ->interpolate(array('aa' => '(bb)(cc)'));
        $this->assertEquals('(bb)(cc) (sens|respons)e and (?3)ibility', $r->expression());

        $r = Ando_Regex::def('(bb)(cc) $aa', null)
                       ->interpolate(array('aa' => '(sens|respons)e and (?1)ibility'));
        $this->assertEquals('(bb)(cc) (sens|respons)e and (?3)ibility', $r->expression());
    }

    /**
     * Issue #5
     */
    public
    function test_lexical_named_backreferences_supported()
    {
        // These tests only confirm that lexical_named_backreferences are ignored when counting groups.
        // palindromes: http://www.regular-expressions.info/recursecapture.html

        // (?&word)
        $r = Ando_Regex::def('(\b(?<word>(?<letter>[a-z])(?&word)\g{letter}|[a-z])\b)|$cc', null)
                       ->interpolate(array('cc' => '(cc)\1'));
        $this->assertEquals('(\b(?<word>(?<letter>[a-z])(?&word)\g{letter}|[a-z])\b)|(cc)\4', $r->expression());

        // (?P>word)
        $r = Ando_Regex::def('(\b(?<word>(?<letter>[a-z])(?P>word)\g{letter}|[a-z])\b)|$cc', null)
                       ->interpolate(array('cc' => '(cc)\1'));
        $this->assertEquals('(\b(?<word>(?<letter>[a-z])(?P>word)\g{letter}|[a-z])\b)|(cc)\4', $r->expression());
    }

    /**
     * Issue #5
     */
    public
    function test_lexical_relative_backreferences_supported()
    {
        $r = Ando_Regex::def('$a (xx) $b ((?-2)yy) (cc) $d (?-1) (ee)', null)
                       ->interpolate(array('a' => '(aa)', 'b' => '(bb)', 'd' => '(dd)(dd)'));
        $this->assertEquals('(aa) (xx) (bb) ((?-3)yy) (cc) (dd)(dd) (?-3) (ee)', $r->expression());

        // Notice that there is no need to test for lexical_relative_backreferences into variable values
        // because, even if some variable value contains some relative reference, under the hypothesis that each value
        // must be well formed, that implies that such a value can only refer to groups captured by that same value,
        // thus each value is atomic, and even if the value contains variables in the middle (as shown for the above
        // template), given that we do not ever replace variables appearing in values of variables but always and only
        // replace variables in the template, then the above test covers also this case (after the replacement takes
        // place, the variable value containing a relative reference with a variable in the middle becomes part ot the
        // new template).
    }

    public
    function test_count_matches_allows_to_count_broken_expressions()
    {
        // Notice that the following expression is broken at the last character.
        $count = Ando_Regex::count_matches('$a (sens|respons)e $b (');
        // In this case count_matches is supposed to count that final parenthesis as a capturing group.
        $this->assertEquals(2, $count['numbered']);
    }

    /**
     * Issue #10
     */
    public
    function test_existential_backreferences_supported()
    {
        //( \( )?    [^()]+    (?(1) \) )
        $r = Ando_Regex::def('$a (\()?[^()]+(?(1)\))', null)
                       ->interpolate(array('a' => '(aa)'));
        $this->assertEquals('(aa) (\()?[^()]+(?(2)\))', $r->expression());

        $r = Ando_Regex::def('(aa) $b', null)
                       ->interpolate(array('b' => '(\()?[^()]+(?(1)\))'));
        $this->assertEquals('(aa) (\()?[^()]+(?(2)\))', $r->expression());
    }
}
