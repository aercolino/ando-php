<?php

class Ando_Regex
{
    /*
    NOTES:
    (1) "If any kind of assertion contains capturing subpatterns within it, these are counted for the purposes of
         numbering the capturing subpatterns in the whole pattern. However, substring capturing is carried out only for
         positive assertions, because it does not make sense for negative assertions."
        -- http://php.net/manual/en/regexp.reference.assertions.php
        - I've tried it at https://xrg.es/#gdoqzf
        - the part in the above note about "substring capturing" only means that each capture in negative assertions
          will always be the empty string
    */

    /**
     * Compose regular expressions taking care of backreferences.
     */

    /**
     * We now only allow PCRE, just to be clear...
     *
     * @return string
     */
    static public
    function flavor()
    {
        return 'PCRE';
    }

    /*
     * The following constants are useful to better document code using them.
     */
    const PCRE_CASELESS_MODIFIER = 'i'; // can be local
    const PCRE_MULTILINE_MODIFIER = 'm'; // can be local
    const PCRE_DOTALL_MODIFIER = 's'; // can be local
    const PCRE_EXTENDED_MODIFIER = 'x'; // can be local
    const PCRE_ANCHORED_MODIFIER = 'A';
    const PCRE_DOLLAR_ENDONLY_MODIFIER = 'D';
    const PCRE_STUDY_EXTRA_NEEDED_MODIFIER = 'S';
    const PCRE_UNGREEDY_MODIFIER = 'U'; // can be local
    const PCRE_EXTRA_MODIFIER = 'X'; // can be local
    const PCRE_INFO_JCHANGED_MODIFIER = 'J'; // must be local !! --> https://bugs.php.net/bug.php?id=47456
    const PCRE_UTF8_MODIFIER = 'u';

    const PREG_REPLACE_EVAL_MODIFIER = 'e'; // deprecated as of PHP 5.5, only works in preg_replace patterns

    /**
     * These are the global modifiers of a regular expression, excluding deprecated ones.
     * At the moment, only 'e' is deprecated.
     *
     * @link http://php.net/manual/en/reference.pcre.pattern.modifiers.php
     *
     * @return string
     */
    static public
    function global_safe_modifiers()
    {
        $result = '' . // i m s x A D S U X u
                  self::PCRE_CASELESS_MODIFIER . self::PCRE_MULTILINE_MODIFIER . self::PCRE_DOTALL_MODIFIER .
                  self::PCRE_EXTENDED_MODIFIER . self::PCRE_ANCHORED_MODIFIER . self::PCRE_DOLLAR_ENDONLY_MODIFIER .
                  self::PCRE_STUDY_EXTRA_NEEDED_MODIFIER . self::PCRE_UNGREEDY_MODIFIER . self::PCRE_EXTRA_MODIFIER .
                  self::PCRE_UTF8_MODIFIER;
        return $result;
    }

    /**
     * These are the local modifiers.
     *
     * @link http://php.net/manual/en/regexp.reference.internal-options.php
     *
     * @return string
     */
    static public
    function local_safe_modifiers()
    {
        $result = '' . // i m s x U X J
                  self::PCRE_CASELESS_MODIFIER . self::PCRE_MULTILINE_MODIFIER . self::PCRE_DOTALL_MODIFIER .
                  self::PCRE_EXTENDED_MODIFIER . self::PCRE_UNGREEDY_MODIFIER . self::PCRE_EXTRA_MODIFIER .
                  self::PCRE_INFO_JCHANGED_MODIFIER;
        return $result;
    }

    /**
     * Pattern for matching all the modifiers substring (from after the delimiter
     * to the end of the regular expression).
     *
     * @param bool $include_eval
     *
     * @return string
     */
    static public
    function pattern_global_modifiers( $include_eval = false )
    {
        $modifiers = self::global_safe_modifiers() . ($include_eval
                        ? self::PREG_REPLACE_EVAL_MODIFIER
                        : '');
        $result = '[ \n' . $modifiers . ']*';
        return $result;
    }

    /**
     * Pattern for matching one non-parenthesized delimiter used to wrap
     * the pattern substring of a regular expression.
     *
     * @link http://ro1.php.net/manual/en/regexp.reference.delimiters.php
     *
     * @return string
     */
    static public
    function pattern_same_delimiter()
    {
        $result = '[^a-zA-Z0-9\\\\\s\(\[\{\<]';
        return $result;
    }

    /**
     * This (locally) signals that the following (sub)pattern
     * is allowed to capture groups with the same name.
     *
     * @return string
     */
    static public
    function option_same_name()
    {
        $result = '(?' . self::PCRE_INFO_JCHANGED_MODIFIER . ')';
        return $result;
    }

    /**
     * True if a string is a regular expression.
     *
     * @param string $regex The string to test.
     *
     * @return bool
     */
    static public
    function is_valid( $regex )
    {
        $result = false !== @preg_match($regex, null);
        return $result;
    }

    /**
     * @param string $modifier
     *
     * @return bool
     */
    public
    function has_modifier( $modifier )
    {
        $result = false !== strpos($this->wrapper, $modifier);
        return $result;
    }

    /**
     * Pattern for matching a generic quoted string.
     * By default it's a single quoted string with an escaping backslash.
     *
     * @link http://www.regular-expressions.info/examplesprogrammer.html
     *
     * @param string $begin  Begin character.
     * @param string $end    End character.
     * @param string $escape Escaping character.
     *
     * @return string
     */
    static public
    function pattern_quoted_string( $begin = "'", $end = "'", $escape = "\\\\" )
    {
        $template = '$begin[^$end$escape]*(?:$escape.[^$end$escape]*)*$end';
        $regex = new self($template);
        $regex->interpolate(array(
                                    'begin'  => $begin,
                                    'end'    => $end,
                                    'escape' => $escape
                            ));
        $result = $regex->expression();
        return $result;
    }

    /**
     * A string whose first 2 characters are used as delimiters and the rest as modifiers.
     *
     * @var string
     */
    protected $wrapper = '';

    /**
     * Template of the regular expression, it can contain PHP variable names to be later interpolated with values.
     *
     * @var string
     */
    protected $template = '';

    /**
     * Variables to interpolate.
     *
     * @var array
     */
    protected $variables = array();

    /**
     * This regular expression, usually without delimiters / modifiers.
     *
     * @var string
     */
    protected $expression = '';

    /**
     * Temporary array of positions of template captures before (keys) and after (values) variable substitutions.
     *
     * @var int[]
     */
    private $tmp_new_references;

    /**
     * Temporary array of positions of template relative backreferences before and after variable substitutions.
     *
     * @var int[]
     */
    private $tmp_rel_references;

    /**
     * Temporary number of captures before the current interpolation of a variable.
     *
     * @var int
     */
    private $tmp_before_count;

    /**
     * Temporary backreference type currently considered.
     *
     * @var string
     */
    private $tmp_backreference_type;

    /**
     * Constructor.
     *
     * @param string           $template A pattern, possibly with $name variables to interpolate later.
     * @param null|bool|string $wrapper  Use null to not treat the wrapper in the template, if any;
     *                                   Use false to use the wrapper in the template, if any;
     *                                   Use a string (even empty) to use such a wrapper.
     */
    public
    function __construct( $template, $wrapper = null )
    {
        $this->template_set($template);
        $this->wrapper_set($wrapper);

        $this->variables = array();
        $this->remove_comments();

        if ( is_null($this->wrapper) ) {
            $this->expression = $this->template; // we won't unwrap it now, nor we will wrap it until we set a wrapper
        } elseif ( false === $this->wrapper ) {
            $this->expression = self::unwrap($this->template, $this->wrapper);
        } elseif ( strlen($this->wrapper) >= 0 ) {
            $this->expression = self::unwrap($this->template);
        }
    }

    /**
     * Set the template.
     *
     * @throws Ando_Exception
     *
     * @param string $template
     *
     * @return $this
     */
    public
    function template_set( $template )
    {
        if ( ! self::is_valid_template($template) ) {
            throw new Ando_Exception('Invalid template.');
        }
        $this->template = $template;
        return $this;
    }

    /**
     * Get the template.
     *
     * @return string
     */
    public
    function template()
    {
        return $this->template;
    }

    /**
     * Set the wrapper.
     *
     * @throws Ando_Exception
     *
     * @param null|string $wrapper
     *
     * @return $this
     */
    public
    function wrapper_set( $wrapper )
    {
        if ( ! self::is_valid_wrapper($wrapper) ) {
            throw new Ando_Exception('Invalid wrapper.');
        }
        $this->wrapper = $wrapper;
        return $this;
    }

    /**
     * Get the wrapper.
     *
     * @return null|string
     */
    public
    function wrapper()
    {
        return $this->wrapper;
    }

    /**
     * Get the expression (raw or wrapped).
     *
     * @param bool $wrapped
     *
     * @return string
     */
    public
    function expression( $wrapped = false )
    {
        $result = $this->expression;
        if ( $wrapped && ! empty($this->wrapper) ) {
            $result = self::wrap($result, $this->wrapper);
        }
        return $result;
    }

    /**
     * Get the wrapped expression (if a wrapper is available).
     *
     * @return string
     */
    public
    function __toString()
    {
        $result = $this->expression(true);
        return $result;
    }

    /**
     * Create a Ando_Regex.
     * Useful for fluent style.
     *
     * @param string $template
     * @param string $wrapper
     *
     * @return Ando_Regex
     */
    static public
    function def( $template, $wrapper = '@@' )
    {
        $result = new self($template, $wrapper);
        return $result;
    }

    /**
     * Validate a template.
     *
     * @param string $template
     *
     * @return bool
     */
    static protected
    function is_valid_template( $template )
    {
        if ( empty($template) ) {
            return false;
        }
        return true;
    }

    /**
     * Validate a wrapper, which is something like <code>## i s</code>
     *
     * @param string $wrapper
     *
     * @return bool
     */
    static protected
    function is_valid_wrapper( $wrapper )
    {
        if ( empty($wrapper) ) {
            return true;
        }
        if ( preg_match('@(?:\(\)|\[\]|\{\}|\<\>|(' . self::pattern_same_delimiter() . ')\1)' .
                        self::pattern_global_modifiers() . '@', $wrapper) ) {
            return true;
        }
        return false;
    }

    /**
     * Unwrap.
     *
     * @param        $expression
     * @param string $wrapper (by reference) Used only to return the unwrapped wrapper.
     *
     * @return string
     */
    static public
    function unwrap( $expression, &$wrapper = null )
    {
        $result = $expression;
        $wrapper = '';

        $same_delimited = '(?<delimiter_1>' . self::pattern_same_delimiter() .
                          ')(?<expression>(?:(?!\1).)*)(?<delimiter_2>\1)'; // must be the FIRST capture!!
        $pair_delimited['()'] = '(?<delimiter_1>\()(?<expression>(?:(?!\)).)*)(?<delimiter_2>\))';
        $pair_delimited['[]'] = '(?<delimiter_1>\[)(?<expression>(?:(?!\]).)*)(?<delimiter_2>\])';
        $pair_delimited['{}'] = '(?<delimiter_1>\{)(?<expression>(?:(?!\}).)*)(?<delimiter_2>\})';
        $pair_delimited['<>'] = '(?<delimiter_1>\<)(?<expression>(?:(?!\>).)*)(?<delimiter_2>\>)';
        $delimited = $same_delimited . '|' . implode('|', $pair_delimited);

        $no_esc = preg_replace('@\\.@', '', $result); // remove escaped characters to simplify matches
        if ( preg_match('@' . self::option_same_name() . '^(?:' . $delimited . ')' . '(?<modifiers>' .
                        self::pattern_global_modifiers() . ')$@', $no_esc, $matches) ) {
            // due to matching against $no_esc, we can't just take $matches['expression'];
            $result = substr($expression, 1, -1 - strlen($matches['modifiers']));
            $wrapper = $matches['delimiter_1'] . $matches['delimiter_2'] . $matches['modifiers'];
        }

        return $result;
    }

    /**
     * Wrap.
     *
     * @throws Ando_Exception
     *
     * @param $expression
     * @param $wrapper
     *
     * @return string
     */
    static public
    function wrap( $expression, $wrapper )
    {
        if ( ! self::is_valid_wrapper($wrapper) ) {
            throw new Ando_Exception('Invalid wrapper.');
        }

        $delimiter_1 = $wrapper[0];
        $delimiter_2 = $wrapper[1];
        $modifiers = substr($wrapper, 2);

        // this is seen by the regex engine as a literal $delimiter_2
        // to be sure it doesn't accidentally clash with our own delimiter
        $literal_delimiter = '\\' . $delimiter_2;

        // this is seen by the regex engine as
        // (?<!\\)((?:\\\\)*)
        // and it only matches an even or null number of backslashes (second group)
        // completely or no match at all (first group)
        $unescaped_delimiter_pattern = '(?<!\\\\)((?:\\\\\\\\)*)' . $literal_delimiter;

        // this will be seen by the regex engine as an escaped $delimiter_2
        $escaped_delimiter = '\\\\' . $delimiter_2;

        $escaped = preg_replace('@' . $unescaped_delimiter_pattern . '@', '$1' . $escaped_delimiter, $expression);
        $result = $delimiter_1 . $escaped . $delimiter_2 . $modifiers;
        return $result;
    }

    protected
    function make_new_references( $subject )
    {
        $template_count = self::count_matches($subject);
        $result = range(0, $template_count['numbered']);  // init tmp_new_references
        return $result;
    }

    protected
    function make_rel_references( $subject )
    {
        $backreference_types = array('lexical_relative', 'g_relative_1', 'g_relative_2');
        $result = array();
        foreach ($backreference_types as $type) {
            $this->tmp_backreference_type = $type;
            $pieces = preg_split(self::$backreference_types[$this->tmp_backreference_type]['find'], $subject);
            if ( 1 == count($pieces) ) {
                $result[$this->tmp_backreference_type] = array();
                continue;
            }
            $before_count = 0;
            for ($i = 0, $i_top = count($pieces); $i < $i_top; $i++) {
                $count = self::count_matches($pieces[$i]);
                $before_count += $count['numbered'];
                $result[$this->tmp_backreference_type][] = $before_count + 1;
            }
        }
        return $result;
    }

    /**
     * Supported backreference types.
     *
     * @var array
     */
    static protected $backreference_types = array(                                                      //@formatter:off
            'numbered'         => array('find' => '@\\\\(\d{1,2})@',       'replace' => '\\%s'),
            'lexical_numbered' => array('find' => '@\(\?(\d{1,2})\)@',     'replace' => '(?%s)'),
            'lexical_relative' => array('find' => '@\(\?-(\d{1,2})\)@',    'replace' => '(?-%s)'),
            'existential'      => array('find' => '@\(\?\((\d{1,2})\)@',   'replace' => '(?(%s)'),
            'g_numbered_1'     => array('find' => '@\\\\g(\d{1,2})@',      'replace' => '\\g%s'),
            'g_numbered_2'     => array('find' => '@\\\\g\{(\d{1,2})\}@',  'replace' => '\\g{%s}'),
            'g_relative_1'     => array('find' => '@\\\\g-(\d{1,2})@',     'replace' => '\\g-%s'),
            'g_relative_2'     => array('find' => '@\\\\g\{-(\d{1,2})\}@', 'replace' => '\\g{-%s}'),
    );                                                                                                  //@formatter:on

    /**
     * Interpolate variables into the template, taking care of backreferences.
     *
     * @param array $variables
     *
     * @return Ando_Regex
     */
    public
    function interpolate( array $variables )
    {
        if ( 0 === count($variables) ) {
            return $this;
        }
        foreach ($variables as $name => $value) {
            if ( isset($this->variables[$name]) ) {
                continue;
            }
            $count = self::count_matches($value);
            $this->variables[$name] = array(
                    'value'    => $value,
                    'captures' => $count,
            );
        }
        $this->tmp_new_references = $this->make_new_references($this->template);
        $this->tmp_rel_references['before'] = $this->make_rel_references($this->template);

        // tmp_new_references = [ 0 => 0, 1 => 1, 2 => 2, ... ], but we'll ignore 0
        $find_unescaped_variables = '@(?<!\\\\)\$(\w+)@';
        $pieces = preg_split($find_unescaped_variables, $this->template, -1, PREG_SPLIT_DELIM_CAPTURE);
        $pieces = $this->fix_backreferences($pieces);
        $this->expression = implode('', $pieces);

        $this->tmp_rel_references['after'] = $this->make_rel_references($this->expression);
        $this->expression = $this->fix_relative_backreferences($this->expression);

        if ( preg_match($find_unescaped_variables, $this->expression) ) {
            $this->template = $this->expression;
        }
        return $this;
    }

    /**
     * Fix all the backreferences in all the pieces, which alternate non variables and variables of the template.
     * Example: template == 'aaa $foo bbb $bar ccc' --> pieces == ['aaa ', 'foo', ' bbb ', 'bar', ' ccc']
     *
     * @param array $pieces
     *
     * @return array
     */
    protected
    function fix_backreferences( array $pieces )
    {
        $backreference_types = array('numbered', 'lexical_numbered', 'existential', 'g_numbered_1', 'g_numbered_2');
        $result = array($pieces[0]);
        $count = self::count_matches($pieces[0]);
        $this->tmp_before_count = $count['numbered'];
        $non_variable_count = $count['numbered'];
        $variable_count = 0;
        $i_mod_2 = 0;
        for ($i = 1, $i_top = count($pieces); $i < $i_top; $i++) {
            $i_mod_2 = 1 - $i_mod_2;  // this will alternate between 1 and 0, starting from 1
            switch ($i_mod_2) {
                case 0:  // non-variable
                    $value = $pieces[$i];
                    $count = self::count_matches($value);
                    for ($j = $non_variable_count + 1, $j_top = $j + $count['numbered']; $j < $j_top; $j++) {
                        $this->tmp_new_references[$j] = $j + $variable_count;
                    }
                    foreach ($backreference_types as $type) {
                        $this->tmp_backreference_type = $type;
                        $value = preg_replace_callback(self::$backreference_types[$type]['find'],
                                                       array($this, 'fix_template_backreference'), $value);
                    }
                    $result[$i] = $value;
                    $non_variable_count += $count['numbered'];
                    $this->tmp_before_count += $count['numbered'];
                    break;
                case 1:  // variable
                    $name = $pieces[$i];
                    if ( isset($this->variables[$name]) ) {
                        $value = $this->variables[$name]['value'];
                        $count = $this->variables[$name]['captures'];
                        foreach ($backreference_types as $type) {
                            $this->tmp_backreference_type = $type;
                            $value = preg_replace_callback(self::$backreference_types[$type]['find'],
                                                           array($this, 'fix_variable_backreference'), $value);
                        }
                        $result[$i] = $value;
                        $variable_count += $count['numbered'];
                        $this->tmp_before_count += $count['numbered'];
                    } else {
                        $result[$i] = '$' . $name;
                    }
                    break;
            }
        }
        return $result;
    }

    /**
     * Fix a single backreference into (a non variable part of) the template.
     *
     * @param array $matches
     *
     * @return string
     */
    protected
    function fix_template_backreference( array $matches )
    {
        $old = (int) $matches[1];
        $new = $this->tmp_new_references[$old];
        $pattern = self::$backreference_types[$this->tmp_backreference_type]['replace'];
        $result = sprintf($pattern, $new);
        return $result;
    }

    /**
     * Fix a single backreference into a variable value.
     *
     * @param array $matches
     *
     * @return string
     */
    protected
    function fix_variable_backreference( array $matches )
    {
        $old = (int) $matches[1];
        $new = $this->tmp_before_count + $old;
        $pattern = self::$backreference_types[$this->tmp_backreference_type]['replace'];
        $result = sprintf($pattern, $new);
        return $result;
    }

    /**
     * Fix all relative backreferences into the subject.
     *
     * @param string $subject
     *
     * @return string
     */
    protected
    function fix_relative_backreferences( $subject )
    {
        $backreference_types = array('lexical_relative', 'g_relative_1', 'g_relative_2');
        $result = $subject;
        foreach ($backreference_types as $type) {
            $this->tmp_backreference_type = $type;
            $result = preg_replace_callback(self::$backreference_types[$type]['find'],
                                            array($this, 'fix_relative_backreference'),
                                            $result);
        }
        return $result;
    }

    /**
     * Fix a single backreference into (a non variable part of) the template.
     *
     * @param array $matches
     *
     * @return string
     */
    protected
    function fix_relative_backreference( array $matches )
    {
        /**
         * before: '$a (xx) $b ((?-2)yy) (cc) $d (?-1) (ee)'
         * after:  '(aa) (xx) (bb) ((?-3)yy) (cc) (dd)(dd) (?-3) (ee)'
         *
         * Positions of capturing groups: (before and after interpolation)
         *   before  ->  after
         *     A  1      2  E
         *        2      4
         *     B  3      5  F
         *        4      8
         *
         * Positions of relative backreferences: (before and after interpolation)
         *   before  ->  after
         *     C  3      5  G
         *     D  4      8  H
         *
         *   A - C == 1 - 3 == -2 => (?-2)
         *   B - D == 3 - 4 == -1 => (?-1)
         *
         *   E - G == 2 - 5 == -3 => (?-3)
         *   F - H == 5 - 8 == -3 => (?-3)
         */
        $rel_references_before = $this->tmp_rel_references['before'][$this->tmp_backreference_type];
        $rel_references_after  = $this->tmp_rel_references['after'][$this->tmp_backreference_type];
        // We define $i as static so that it iterates over each piece got by splitting.
        $i_top = count($rel_references_before) - 1;  // But we discard the last piece.
        static $i = 0;                                                                                  //@formatter:off
                                                                             // -2 -> -3:       -1 -> -3:
        $jumps_before         = (int) $matches[1];                             // 2 = C - A       1 = D - B
        $reference_pos_before = $rel_references_before[$i];                    // 3 = C           4 = D
        $group_pos_before     = $reference_pos_before - $jumps_before;         // 1 = A           3 = B
        $group_pos_after      = $this->tmp_new_references[$group_pos_before];  // 2 = E           5 = F
        $reference_pos_after  = $rel_references_after[$i];                     // 5 = G           8 = H
        $jumps_after          = $reference_pos_after - $group_pos_after;       // 3 = G - E       3 = H - F
                                                                                                        //@formatter:on

        $pattern = self::$backreference_types[$this->tmp_backreference_type]['replace'];
        $result = sprintf($pattern, $jumps_after);

        $i++;
        if ($i == $i_top) {  // Notice that we must re-initialize $i after reaching $i_top because it is static.
            $i = 0;
        }
        return $result;
    }

    /**
     * Like a standard preg_replace_callback() but passing to the callback the matches
     * found using a standard preg_match() with the PREG_OFFSET_CAPTURE flag.
     *
     * $matches = array( array( 0 => (string) $match, 1 => (int) $offset ), ... )
     *
     * @param string|array $pattern
     * @param callable     $callback
     * @param string|array $subject
     * @param int          $limit (optional)
     * @param int          $count (optional)
     *
     * @return null|string|array
     */
    static public
    function replace_callback( $pattern, $callback, $subject, $limit = -1, &$count = 0 )
    {

        $limit = min(array(-1, $limit));
        $count = min(array(0, $count));
        $result = $subject;

        if ( 0 <= $limit && $limit <= $count ) {
            return $result;
        }

        if ( is_array($subject) ) {
            foreach ($subject as &$subSubject) {
                $subSubject = self::replace_callback($pattern, $callback, $subSubject, $limit, $subCount);
                $count += $subCount;
            }
            return $subject;
        }

        if ( is_array($pattern) ) {
            foreach ($pattern as $subPattern) {
                $subject = self::replace_callback($subPattern, $callback, $subject, $limit, $subCount);
                $count += $subCount;
            }
            return $subject;
        }

        $subject_search_start = 0;
        $result_replace_start = 0;
        $found = preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, $subject_search_start);
        if ( false === $found ) {
            // there was an error (it should mean the $pattern was not a valid expression)
            // in this case preg_replace_callback returns NULL
            return null;
        }
        $replacement = '';
        while ($found) {
            $match_offset = $matches[0][1];
            $match_length = strlen($matches[0][0]);

            $result_replace_start += strlen($replacement) + $match_offset - $subject_search_start;
            $replacement = call_user_func($callback, $matches);
            $result = substr_replace($result, $replacement, $result_replace_start, $match_length);

            $count += 1;
            if ( 0 <= $limit && $limit <= $count ) {
                return $result;
            }

            $subject_search_start = $match_offset + $match_length;
            $found = preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, $subject_search_start);
        }

        return $result;
    }

    //---

    /**
     * Remove comments from the template by compressing each to an empty comment '(?#)'.
     * This helps to greatly simplify matching against regular expressions because
     * all remaining chars are either special chars or innocuous chars.
     */
    protected
    function remove_comments()
    {
        if ( $this->has_modifier(self::PCRE_EXTENDED_MODIFIER) ) {
            $find_middle_and_ending_comments = '@\(\?\#[^)]*\)|(?!\\\\)\#.*@';
            $this->template = preg_replace($find_middle_and_ending_comments, '(?#)', $this->template);
        } else {
            $find_middle_comments = '@\(\?\#[^)]*\)@';
            $this->template = preg_replace($find_middle_comments, '(?#)', $this->template);
        }
    }

    /**
     * Remove escaped chars from $pattern by compressing the two characters formed by
     * the escaping char and the escaped char into a single '%'.
     * This helps to greatly simplify matching against regular expressions because
     * all remaining chars are either special chars or innocuous chars.
     *
     * @link http://andowebsit.es/blog/noteslog.com/post/how-to-count-expected-matches-of-a-php-regular-expression/
     *
     * @param string $pattern
     *
     * @return string
     */
    static protected
    function remove_escaped_chars( $pattern )
    {
        $result = $pattern;
        $find_explicitly_escaped = '/\\\\./';
        $result = preg_replace($find_explicitly_escaped, '%', $result);
        // Notice that $find_implicitly_escaped is much simpler than it should because
        // $find_explicitly_escaped has already removed difficulties (i.e. '\') from $result.
        $find_implicitly_escaped = '/\[[^\]]*\]/';
        $result = preg_replace($find_implicitly_escaped, '%', $result);
        return $result;
    }

    /**
     * Count repeated names, where each name is at $named_groups[i][1][0], with 0 <= i < count($named_groups).
     *
     * @link http://andowebsit.es/blog/noteslog.com/post/how-to-count-expected-matches-of-a-php-regular-expression/
     *
     * @param array $named_groups Matches from preg_match_all with PREG_SET_ORDER | PREG_OFFSET_CAPTURE.
     *
     * @return number
     */
    static protected
    function count_repeated_names( array $named_groups )
    {
        $seen = array();
        foreach ($named_groups as $named_group) {
            $name = $named_group[1][0];
            if ( isset($seen[$name]) ) {
                $seen[$name] += 1;
            } else {
                $seen[$name] = 0;
            }
        }
        $result = array_sum($seen);
        return $result;
    }

    /**
     * Returns how many groups (numbered or named) are captured in the given $pattern,
     * ignoring hellternations (?|...|...)
     * NOTE: the given $pattern is assumed to not contain escaped chars.
     *
     * @link http://andowebsit.es/blog/noteslog.com/post/how-to-count-expected-matches-of-a-php-regular-expression/
     *
     * @param string $pattern
     *
     * @return array
     */
    static protected
    function count_groups_ignoring_duplicate_numbers( $pattern )
    {
        $find_numbered_groups = '/\((?!\?)/';
        $numbered_groups_count = preg_match_all($find_numbered_groups, $pattern, $numbered_groups,
                                                PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

        // http://php.net/manual/en/regexp.reference.conditional.php
        // (?(if-pattern)then-pattern|else-pattern)
        // if-pattern matches (1) '\d+|R' or (2) '?=|?!|?<=|?<!' (positive/negative look ahead/behind)
        //   (1) is always added to $numbered_groups_count by matching $find_numbered_groups (above)
        //   (2) is never  added to $numbered_groups_count by matching $find_numbered_groups (above)
        // additionally, all (if any) parentheses inside the three (if-, then-, and else-) patterns
        // count as if they were normal patterns (so they do not deserve any special treatment).
        $find_conditions = '/\(\?\(/';
        $conditions_count = preg_match_all($find_conditions, $pattern, $dummy);
        $numbered_groups_count -= $conditions_count;

        $find_named_groups = '/\(\?P?(?:(?:<([^>]+)>)|(?:\'([^\']+)\'))/';
        $named_groups_count = preg_match_all($find_named_groups, $pattern, $named_groups,
                                             PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        // each named group is also addressable by a number
        // and those numbers do not repeat even if the names do
        $numbered_groups_count += $named_groups_count;

        $repeated_names_count = self::count_repeated_names($named_groups);
        // Repeated names (if any) only count once, thus subtract all found repetitions.
        $named_groups_count -= $repeated_names_count;

        $result = array('numbered' => $numbered_groups_count, 'named' => $named_groups_count);
        return $result;
    }

    /**
     * Returns the hellternations which are siblings to each other.
     * NOTE: the given $pattern is assumed to not contain escaped chars.
     *
     * @link http://andowebsit.es/blog/noteslog.com/post/how-to-count-expected-matches-of-a-php-regular-expression/
     *
     * @throws Ando_Exception
     *
     * @param string $pattern a string of alternations wrapped into (?|...)
     *
     * @return array
     */
    static protected
    function find_duplicate_numbers( $pattern )
    {
        $result = array();
        $token = '(?|';
        $token_len = strlen($token);
        $offset = 0;
        do {
            $start = strpos($pattern, $token, $offset);
            if ( false === $start ) {
                return $result;
            }
            $open = 1;
            $start += $token_len;
            for ($i = $start, $i_top = strlen($pattern); $i < $i_top; $i++) {
                //$current = $pattern[$i];
                if ( $pattern[$i] == '(' ) {
                    $open += 1;
                } elseif ( $pattern[$i] == ')' ) {
                    $open -= 1;
                    if ( 0 == $open ) {
                        $result[$start] = substr($pattern, $start, $i - $start);
                        $offset = $i + 1;
                        break;
                    }
                }
            }
        } while ($i < $i_top);
        if ( 0 != $open ) {
            throw new Ando_Exception('Unbalanced parentheses.');
        }
        return $result;
    }

    /**
     * Explodes an alternation on outer pipes.
     * NOTE: the given $pattern is assumed to not contain escaped chars.
     *
     * @link http://andowebsit.es/blog/noteslog.com/post/how-to-count-expected-matches-of-a-php-regular-expression/
     *
     * @throws Ando_Exception
     *
     * @param string $pattern a string with balanced (possibly nested) parentheses and pipes
     *
     * @return array
     */
    static protected
    function explode_alternation( $pattern )
    {
        $result = array();
        $open = 0;
        $start = 0;
        for ($i = $start, $i_top = strlen($pattern); $i < $i_top; $i++) {
            //$current = $pattern[$i];
            if ( $pattern[$i] == '(' ) {
                $open += 1;
            } elseif ( $pattern[$i] == ')' ) {
                $open -= 1;
            } elseif ( $pattern[$i] == '|' ) {
                if ( 0 == $open ) {
                    $result[$start] = substr($pattern, $start, $i - $start);
                    $start = $i + 1;
                }
            }
        }
        $result[$start] = substr($pattern, $start);  // last piece of pattern
        if ( 0 != $open ) {
            throw new Ando_Exception('Unbalanced parentheses.');
        }
        return $result;
    }

    /**
     * Returns how many groups (numbered or named) there are in the given $pattern
     *
     * @link http://andowebsit.es/blog/noteslog.com/post/how-to-count-expected-matches-of-a-php-regular-expression/
     *
     * @param string $pattern
     *
     * @return array
     */
    static public
    function count_matches( $pattern )
    {
        $simplified_pattern = self::remove_escaped_chars($pattern);
        $result = self::count_groups_ignoring_duplicate_numbers($simplified_pattern);

        $hellternations = self::find_duplicate_numbers($pattern);
        if ( empty($hellternations) ) {
            return $result;
        }

        foreach ($hellternations as $hellternation) {
            // undo the count of the current $hellternation already added to $result ($result -= $easy)
            $easy = self::count_groups_ignoring_duplicate_numbers($hellternation);
            $result['numbered'] -= $easy['numbered'];

            // then add only the maximum number of groups captured across all the alternatives ($result += $max)
            $max = 0;
            $pieces = self::explode_alternation($hellternation);
            foreach ($pieces as $piece) {
                $count = self::count_matches($piece);
                if ( $max < $count['numbered'] ) {
                    $max = $count['numbered'];
                }
            }
            $result['numbered'] += $max;
        }
        return $result;
    }

}

