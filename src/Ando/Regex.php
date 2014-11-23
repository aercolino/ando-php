<?php

class Ando_Regex
{
	/*

	TODO add support for self-backreferences (those that refers the same group they are into)
		-- http://php.net/manual/en/regexp.reference.back-references.php
		- these should simply be considered like any other, so I think all is fine

	TODO add support for numbered forward references like \1, ,, \9
		-- http://php.net/manual/en/regexp.reference.back-references.php
		- refer to groups defined later in the regex
		- only one digit

	TODO add support for numbered backreferences like \g1, .. \g99 and their synonyms \g{1}, .. \g{99}
		-- http://php.net/manual/en/regexp.reference.back-references.php

	TODO add support for relative numbered backreferences like \g-1, \g-2 .. and (their synonyms) \g{-1}, \g{-2} ..
		-- http://php.net/manual/en/regexp.reference.back-references.php
	    - capturing group that can be found by counting as many opening parentheses of named or numbered
	      capturing groups as specified by the number from right to left starting at the backreference.
		- "The use of the \g sequence with a negative number signifies a relative reference. For example,
		  (foo)(bar)\g{-1} would match the sequence "foobarbar" and (foo)(bar)\g{-2} matches "foobarfoo". This can be
		  useful in long patterns as an alternative to keeping track of the number of subpatterns in order to reference
		  a specific previous subpattern."

	TODO add support for recursive numbered backreferences like (?1), (?2), ...
		-- inside recursion (http://php.net/manual/en/regexp.reference.recursive.php)

	TODO add support for named backreferences like (?P=name), \k<name>, \k'name', \k{name} and \g{name}
		-- http://php.net/manual/en/regexp.reference.back-references.php
		- these should simply be ignored, so I think all is fine
	   recursive named backreferences like (?P>name) and (?&name)
		-- inside recursion (http://php.net/manual/en/regexp.reference.recursive.php)
		- these should simply be ignored, so I think all is fine

	TODO add support for lexical numbered backreferences like (?1), (?2), ... outside recursion
		- note that (?1), (?2), ... outside recursion work like lexical backreferences, meaning that they represent a
		   previous group as it was defined not as it will be matched: example
		     @(sens|respons)e and (?1)ibility@  is a shortcut for  @(sens|respons)e and (?:sens|respons)ibility@
		     thus both expressions match any of
		       - "sense and sensibility",
		       - "response and responsibility",
		       - "sense and responsibility",
		       - "response and sensibility",
		     while @(sens|respons)e and \1ibility@ only matches
		       - "sense and sensibility"
		       - "response and responsibility"

	TODO add support for lexical named backreferences like (?P>name) and (?&name) outside recursion
		-- for symmetry these could exist.. not sure though
		- these should simply be ignored, so I think all is fine

	TODO add support for relative numbered backreferences like (?-1), (?-2)
	    - they are mentioned in the comment at http://php.net/manual/en/regexp.reference.recursive.php#111935
	    - I tried them and they work perfectly: https://xrg.es/#1m7mxeo (link valid until 22/11/2015)
	    - comparing with (6) I wonder if these are to be considered lexically too, but for symmetry I'd say yes...
	    - under the assumption that no $variable appears in between a relative backreference and the group it refers to,
	      these (new to me) kind of backreferences could be used to solve the numbered backreferences problem when one
	      wants to reuse expressions inside other expressions, exactly like the comment above suggests.
	    - if instead a $variable appears in between a relative backreference and the group it refers to then all the
	      code of this class for composing expressions still makes sense.

	TODO add support for comments like (?# ... ) -- everything inside is ignored !!

	TODO add support for comments like # ... \n -- only when the PCRE_EXTENDED is set ('#' not escaped nor into [])

	(*1) "If any kind of assertion contains capturing subpatterns within it, these are counted for the purposes of
	     numbering the capturing subpatterns in the whole pattern. However, substring capturing is carried out only for
	     positive assertions, because it does not make sense for negative assertions."
		-- http://php.net/manual/en/regexp.reference.assertions.php
		- I've tried it at https://xrg.es/#gdoqzf
		- the part in the above note about "substring capturing" only means that each capture in negative assertions
	      will always be the empty string

	TODO add support for named groups like (?P<name>pattern), (?<name>pattern), (?'name'pattern)
		-- http://php.net/manual/en/regexp.reference.subpatterns.php
		- currently only the <name> type is supported

	TODO make sure that (?:a) is not a capturing group but neither (?i) is, nor (?i:a).

	TODO add support for conditions that are numbered backreferences (without a backslash)
		-- http://php.net/manual/en/regexp.reference.conditional.php

	TODO document the need for balanced parentheses (a requirement in ::count_matches)
        Exceptions are currently thrown if the pattern to count contains hellternations and those parentheses are not
        balanced.

	TODO see if ::find_duplicate_numbers and ::explode_alternation can work with recursive patterns
	    for matching properly balanced expressions.

	TODO add full support for templates like this '(a)$name(b)\1\2'
        If $name does not contain captures then the current code works fine, but if it does contain captures, then \2
		would not be changed and it would refer to the first capture in $name instead of referring to b.

	TODO check if partial interpolations (not all variables at once) are supported already

    TODO add support for recursive partial interpolations
		- when variables refer more variables and you want to interpolate only a bunch of them
        - prevent infinite recursion caused by variables referring themselves directly or hopping through other
		  variables

	TODO add support for additional predefined templates like '([$delimiters])(?:(?!\1).)*\1' (string)
        - Notice that the above template is a work in progress because it doesn't support the escaping character.

	*/


	/**
     * Compose regular expressions taking care of backreferences.
     */

    /**
     * We now only allow PCRE, just to be clear...
     *
     * @return string
     */
    static public function flavor()
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
    const PCRE_INFO_JCHANGED_MODIFIER = 'J'; // must be local !!
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
    static public function global_safe_modifiers()
    {
        $result = '' . // i m s x A D S U X u
            self::PCRE_CASELESS_MODIFIER . self::PCRE_MULTILINE_MODIFIER . self::PCRE_DOTALL_MODIFIER . self::PCRE_EXTENDED_MODIFIER . self::PCRE_ANCHORED_MODIFIER . self::PCRE_DOLLAR_ENDONLY_MODIFIER . self::PCRE_STUDY_EXTRA_NEEDED_MODIFIER .
            self::PCRE_UNGREEDY_MODIFIER . self::PCRE_EXTRA_MODIFIER . self::PCRE_UTF8_MODIFIER;
        return $result;
    }

    /**
     * These are the local modifiers.
     *
     * @link http://php.net/manual/en/regexp.reference.internal-options.php
     *
     * @return string
     */
    static public function local_safe_modifiers()
    {
        $result = '' . // i m s x U X J
            self::PCRE_CASELESS_MODIFIER . self::PCRE_MULTILINE_MODIFIER . self::PCRE_DOTALL_MODIFIER . self::PCRE_EXTENDED_MODIFIER . self::PCRE_UNGREEDY_MODIFIER . self::PCRE_EXTRA_MODIFIER . self::PCRE_INFO_JCHANGED_MODIFIER;
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
    static public function pattern_global_modifiers($include_eval = false)
    {
        $modifiers = self::global_safe_modifiers() . ($include_eval ? self::PREG_REPLACE_EVAL_MODIFIER : '');
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
    static public function pattern_same_delimiter()
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
    static public function option_same_name_groups_ok()
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
    static public function is_valid($regex)
    {
        $result = false !== @preg_match($regex, null);
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
    static public function pattern_quoted_string($begin = "'", $end = "'", $escape = "\\\\")
    {
        $template = '$begin[^$end$escape]*(?:$escape.[^$end$escape]*)*$end';
        $regex = new self($template);
        $regex->interpolate(array(
            'begin' => $begin,
            'end' => $end,
            'escape' => $escape
        ));
        $result = $regex->expression();
        return $result;
    }

    /**
     * A string whose first character is used as a delimiter and the rest as modifiers.
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
     * Temporary variables for the current interpolation.
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
     * Number of captures in a sub-expression.
     *
     * @var int
     */
    private $captures = 0;

    /**
     * Number of captures in interpolated variables.
     *
     * @var int
     */
    private $captures_in_variables;

    /**
     * Constructor.
     *
     * @param string           $template A pattern, possibly with $name variables to interpolate later.
     * @param null|bool|string $wrapper  Use null to not treat the wrapper in the template, if any;
     *                                   Use false to use the wrapper in the template, if any;
     *                                   Use a string (even empty) to use such a wrapper.
     */
    public function __construct($template, $wrapper = null)
    {
        $this->template_set($template);
        $this->wrapper_set($wrapper);

        if (is_null($this->wrapper)) {
            $this->expression = $this->template; // we won't unwrap it now, nor we will wrap it until we set a wrapper
        } elseif (false === $this->wrapper) {
            $this->expression = self::unwrap($this->template, $this->wrapper);
        } elseif (strlen($this->wrapper) >= 0) {
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
    public function template_set($template)
    {
        if (!self::is_valid_template($template)) {
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
    public function template()
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
    public function wrapper_set($wrapper)
    {
        if (!self::is_valid_wrapper($wrapper)) {
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
    public function wrapper()
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
    public function expression($wrapped = false)
    {
        $result = $this->expression;
        if ($wrapped && !empty($this->wrapper)) {
            $result = self::wrap($result, $this->wrapper);
        }
        return $result;
    }

    /**
     * Get the wrapped expression (if a wrapper is available).
     *
     * @return string
     */
    public function __toString()
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
    static public function def($template, $wrapper = '@@')
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
    static protected function is_valid_template($template)
    {
        if (empty($template)) {
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
    static protected function is_valid_wrapper($wrapper)
    {
        if (empty($wrapper)) {
            return true;
        }
        if (preg_match('@(?:\(\)|\[\]|\{\}|\<\>|(' . self::pattern_same_delimiter() . ')\1)' . self::pattern_global_modifiers() . '@', $wrapper)) {
            return true;
        }
        return false;
    }

    /**
     * Interpolate the variables into the template, taking care of the backreferences.
     *
     * @param array $variables
     *
     * @return Ando_Regex
     */
    public function interpolate($variables = array())
    {
        if (0 === count($variables)) {
            return $this;
        }
        foreach ($variables as $name => $value) {
            $count = self::count_matches($value);
	        $variables[$name] = array(
                'value'    => $value,
                'captures' => $count['numbered'],
            );
        }
        $this->variables = $variables;
	    $this->captures_in_variables = 0;
        $this->expression = self::replace('@(?<!\\\\)\$(\w+)@', array($this, 'substitute_variable'), $this->template);
        return $this;
    }

    /**
     * Unwrap.
     *
     * @param        $expression
     * @param string $wrapper (by reference) Used only to return the unwrapped wrapper.
     *
     * @return string
     */
    static public function unwrap($expression, &$wrapper = null)
    {
        $result = $expression;
        $wrapper = '';

        $same_delimited = '(?<delimiter_1>' . self::pattern_same_delimiter() . ')(?<expression>(?:(?!\1).)*)(?<delimiter_2>\1)'; // must be the FIRST capture!!
        $pair_delimited['()'] = '(?<delimiter_1>\()(?<expression>(?:(?!\)).)*)(?<delimiter_2>\))';
        $pair_delimited['[]'] = '(?<delimiter_1>\[)(?<expression>(?:(?!\]).)*)(?<delimiter_2>\])';
        $pair_delimited['{}'] = '(?<delimiter_1>\{)(?<expression>(?:(?!\}).)*)(?<delimiter_2>\})';
        $pair_delimited['<>'] = '(?<delimiter_1>\<)(?<expression>(?:(?!\>).)*)(?<delimiter_2>\>)';
        $delimited = $same_delimited . '|' . implode('|', $pair_delimited);

        $no_esc = preg_replace('@\\.@', '', $result); // remove escaped characters to simplify matches
        if (preg_match('@' . self::option_same_name_groups_ok() . '^(?:' . $delimited . ')' . '(?<modifiers>' . self::pattern_global_modifiers() . ')$@', $no_esc, $matches)) {
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
    static public function wrap($expression, $wrapper)
    {
        if (!self::is_valid_wrapper($wrapper)) {
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

    /**
     * Substitute a single occurrence of a variable name into the template with its value.
     *
     * @param $matches
     *
     * @return mixed
     */
    protected function substitute_variable($matches)
    {
        list($name, $offset) = $matches[1];
        $value = $this->variables[$name]['value'];
        $before = substr($this->template, 0, $offset - 1); // 1 less because of the $ prefix
	    $before_count = self::count_matches($before);
	    $this->captures = $before_count['numbered'] + $this->captures_in_variables;
        $result = preg_replace_callback('@\\\\(\d{1,2})@', array($this, 'fix_backreference'), $value);
        $this->captures_in_variables += $this->variables[$name]['captures'];
        return $result;
    }

    /**
     * Fix a single backreference into a variable value.
     *
     * WARNING: It only supports backreferences of the form <code>\1 .. \99</code>
     *
     * @param $matches
     *
     * @return string
     */
    protected function fix_backreference($matches)
    {
        $old_backreference = $matches[1];
        $backreference = $this->captures + $old_backreference;
        $result = '\\' . $backreference;
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
    static public function replace($pattern, $callback, $subject, $limit = -1, &$count = 0)
    {

        $limit = min(array(-1, $limit));
        $count = min(array(0, $count));
        $result = $subject;

        if (0 <= $limit && $limit <= $count) {
            return $result;
        }

        if (is_array($subject)) {
            foreach ($subject as &$subSubject) {
                $subSubject = self::replace($pattern, $callback, $subSubject, $limit, $subCount);
                $count += $subCount;
            }
            return $subject;
        }

        if (is_array($pattern)) {
            foreach ($pattern as $subPattern) {
                $subject = self::replace($subPattern, $callback, $subject, $limit, $subCount);
                $count += $subCount;
            }
            return $subject;
        }

        $subject_search_start = 0;
        $result_replace_start = 0;
        $found = preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, $subject_search_start);
        if (false === $found) {
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
            if (0 <= $limit && $limit <= $count) {
                return $result;
            }

            $subject_search_start = $match_offset + $match_length;
            $found = preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, $subject_search_start);
        }

        return $result;
    }

	//---

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
	static protected function remove_escaped_chars( $pattern ) {
		$result = $pattern;

		$find_explicitly_escaped = '/\\\\./';
		$result = preg_replace($find_explicitly_escaped, '%', $result);

		// Notice that $find_implicitly_escaped is much simpler than it should because
		// $find_explicitly_escaped has already removed difficulties (\) from $result.
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
	static protected function count_repeated_names( $named_groups ) {
		$seen = array();
		foreach ($named_groups as $named_group)
		{
			$name = $named_group[1][0];
			if (isset($seen[$name]))
			{
				$seen[$name] += 1;
			}
			else
			{
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
	static protected function count_groups_ignoring_duplicate_numbers( $pattern )
	{
		$find_numbered_groups  = '/\((?!\?)/';
		$numbered_groups_count = preg_match_all($find_numbered_groups, $pattern, $numbered_groups, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

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

		$find_named_groups  = '/\(\?P?(?:(?:<([^>]+)>)|(?:\'([^\']+)\'))/';
		$named_groups_count = preg_match_all($find_named_groups, $pattern, $named_groups, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
		// each named group is also addressable by a number
		// and those numbers do not repeat even if the names do
		$numbered_groups_count += $named_groups_count;

		$repeated_names_count = self::count_repeated_names($named_groups);
		// Repeated names (if any) only count once, thus subtract all found repetitions.
		$named_groups_count -= $repeated_names_count;

		$result = array( 'numbered' => $numbered_groups_count, 'named' => $named_groups_count);
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
	static protected function find_duplicate_numbers( $pattern )
	{
		$result = array();
		$token = '(?|';
		$token_len = strlen($token);
		$offset = 0;
		do
		{
			$start = strpos($pattern, $token, $offset);
			if (FALSE === $start)
			{
				return $result;
			}
			$open = 1;
			$start += $token_len;
			for ($i = $start, $iTop = strlen($pattern); $i < $iTop; $i++)
			{
				//$current = $pattern[$i];
				if ($pattern[$i] == '(')
				{
					$open += 1;
				}
				elseif ($pattern[$i] == ')')
				{
					$open -= 1;
					if (0 == $open)
					{
						$result[$start] = substr($pattern, $start, $i - $start);
						$offset = $i + 1;
						break;
					}
				}
			}
		}
		while ($i < $iTop);
		if (0 != $open)
		{
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
	static protected function explode_alternation( $pattern )
	{
		$result = array();
		$open = 0;
		$start = 0;
		for ($i = $start, $iTop = strlen($pattern); $i < $iTop; $i++)
		{
			//$current = $pattern[$i];
			if ($pattern[$i] == '(')
			{
				$open += 1;
			}
			elseif ($pattern[$i] == ')')
			{
				$open -= 1;
			}
			elseif ($pattern[$i] == '|')
			{
				if (0 == $open)
				{
					$result[$start] = substr($pattern, $start, $i - $start);
					$start = $i + 1;
				}
			}
		}
		$result[$start] = substr($pattern, $start);  // last piece of pattern
		if (0 != $open)
		{
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
	static public function count_matches( $pattern )
	{
		$simplified_pattern = self::remove_escaped_chars($pattern);
		$result = self::count_groups_ignoring_duplicate_numbers($simplified_pattern);

		$hellternations = self::find_duplicate_numbers($pattern);
		if (empty($hellternations))
		{
			return $result;
		}

		foreach ($hellternations as $hellternation)
		{
			// undo the count of the current $hellternation already added to $result ($result -= $easy)
			$easy = self::count_groups_ignoring_duplicate_numbers($hellternation);
			$result['numbered'] -= $easy['numbered'];

			// then add only the maximum number of groups captured across all the alternatives ($result += $max)
			$max = 0;
			$pieces = self::explode_alternation($hellternation);
			foreach ($pieces as $piece)
			{
				$count = self::count_matches($piece);
				if ($max < $count['numbered']) {
					$max = $count['numbered'];
				}
			}
			$result['numbered'] += $max;
		}
		return $result;
	}

}

