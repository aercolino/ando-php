<?php
/**
 * Basic Callable Proxy.
 *
 * Wrap a PHP callable into Ando_Callable::def to create a proxy object
 * that will call that callable with doctored arguments.
 *
 * If no extra arguments are given, no proxy is created. This means that,
 * even if the effect of the function is null in such a case, it's still a good
 * idea to use Ando_Callable::def for any PHP callback because it allows to more easily
 * tell apart PHP expressions that are used as callbacks from those that are not.
 *
 * @link http://andowebsit.es/blog/noteslog.com/
 */
class Ando_Callable {
    /**
     * Callable expression.
     *
     * @var mixed
     */
    private $callback;

    /**
     * Options.
     *
     *   'extra' => array       Additional arguments to pass to the callback.
     *   'splat' => true|false  True means the run-time arguments are flattened.
     *   'order' => string      Permutation (it allows for repetitions and/or omissions)
     *                            of prepared + run-time arguments. Format:
     *                            - '1'     <-- Place at 0 what is at 1
     *                            - '0 2 4' <-- Place at 0 what is at 0, at 1 what is at 2, at 2 what is at 4.
     *                            Notice that if you do not explicitly remove run-time arguments, they are still
     *                            passed along to the callback even if they do not appear in the new order.
     *                            They are just appended to the reordered arguments, in the same order they were.
     *   'retain' => string     List items to retain from run-time arguments. Format:
     *   'remove' => string     List items to remove from run-time arguments. Format:
     *                            - '1'     <-- Select item at offset 1.
     *                            - '0 2-4' <-- Select items at offset 0, 2, 3.
     *                            - '-3'    <-- Select items at offset 0, 1, 2.
     *                            - '1-'    <-- Select items at offset 1, 2, ... (up to the end).
     *
     * @var array
     */
    private $options;

    /**
     * Constructor.
     *
     * @param callable    $callback   Callable expression.
     * @param null|array  $options    Options.
     */
    public function __construct( $callback, $options = null ) {
        $this->callback = $callback;
        $this->options = $options;
    }

    /**
     * Permute $array according to $permutation.
     * Some values of $permutation should be some indexes into $array.
     *
     * If a value of $permutation is not an index into $array,
     * then the corresponding item of the result depends on $missing.
     * If $missing is TRUE, then a NULL item is put at that position.
     * If $missing is FALSE, then no item is put at that position.
     *
     * After selecting from $array all the items specified by $permutation,
     * any remaining unselected items of $array are appended to the result.
     *
     * @param array $array       The array to permute
     * @param array $permutation The permutation to apply
     * @param bool  $missing     The policy for missing indexes
     * @return array             The permuted array
     */
    protected static function permute($array, $permutation, $missing = TRUE) {
        $result = array();
        foreach ($permutation as $key) {
            if (array_key_exists($key, $array)) {
                $result[] = $array[$key]; // a NULL in $array is preserved
                unset($array[$key]);
            } elseif ($missing) {
                $result[] = NULL;         // a missing index is set to NULL
            }
        }
        $result = array_merge($result, $array);
        return $result;
    }

    /**
     * Flatten all values of an array.
     *
     * @param array $array
     * @return array
     */
    static protected function flatten( $array ) {
        $result = array();
        foreach ( array_values( $array ) as $value ) {
            if ( is_array( $value ) ) {
                $result = array_merge( $result, self::flatten($value) );
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }

    /**
     * Define a callback.
     *
     * @param callable    $callback   Any valid PHP callback expression
     * @param null|array  $options
     * @return callable
     */
    static public function def( $callback, $options = null ) {
        $result = new self( $callback, $options );
        $result = $result->ref();
        return $result;
    }

    /**
     * Set the callback.
     *
     * @param callable $callback
     * @return $this
     */
    public function setCallback( $callback ) {
        $this->callback = $callback;
        return $this;
    }

    /**
     * Set the options.
     *
     * @param  array  $options  Additional options.
     * @param  bool   $merge    True (default) means that new options replace those with the same key.
     * @return $this
     */
    public function setOptions( $options, $merge = true ) {
        if ( $merge ) {
            self::merge( $this->options, $options );
        } else {
            $this->options = $options;
        }
        return $this;
    }

    /**
     * Merge giver into receiver by replacing values with the same key.
     *
     * @param $receiver
     * @param $giver
     */
    static protected function merge( &$receiver, $giver ) {
        if ( ! is_array( $receiver ) ) {
            $receiver = array();
        }
        foreach ( $giver as $key => $value ) {
            $receiver[$key] = $value;
        }
    }

    /**
     * @param array $array
     * @param string $retain
     * @param string $remove
     * @return array
     */
    static protected function select( $array, $retain = '', $remove = '' ) {
        $result = array_values( $array );
        $top = count( $array );

        if ( 0 < strlen( $retain ) ) {
            $select = self::parse_select( $retain, $top );
            $result = array_intersect_key( $result, array_flip( $select ) );
            return $result;
        }

        if ( 0 < strlen( $remove ) ) {
            $select = self::parse_select( $remove, $top );
            $result = array_diff_key( $result, array_flip( $select ) );
            return $result;
        }

        return $result;
    }

    /**
     * @param $select
     * @param $top
     * @return array
     */
    static protected function parse_select( $select, $top ) {
        $result = array();
        if ( preg_match_all('@(?J)(?<min>\d+)-(?<max>\d+)|(?<min>\d+)-|-(?<max>\d+)|(?<one>\d+)?@', $select, $matches, PREG_SET_ORDER, 0) ) {
            foreach ( $matches as $block ) {
                if ( '' == $block[0] ) {
                    continue;
                }
                $keys = array();
                if ( '' != $block['min'] || '' != $block['max'] ) {
                    $min = '' != $block['min'] ? max( (integer) $block['min'], 0    ) : 0;
                    $max = '' != $block['max'] ? min( (integer) $block['max'], $top ) : $top;
                    $keys = range( $min, $max - 1 );
                } elseif ( '' != $block['one'] ) {
                    $keys = array( (integer) $block['one'] );
                }
                $result = array_merge( $result, $keys );
            }
        }
        return array_unique( $result );
    }

    /**
     * Reference the (immediate or proxy-ed) callback.
     *
     * @return array
     */
    public function ref() {
        if ( empty( $this->options ) ) {
            $result = $this->callback;
        } else {
            $result = array( $this, 'run' );
        }
        return $result;
    }

    /**
     * Run the callback, with extra arguments plus run-time arguments.
     *
     * @return mixed
     */
    public function run() {
        $arguments = func_get_args();
        if ( isset( $this->options['splat'] ) ) {
            // This is useful when the callback addresses individual items of a passed array;
            // for example, when preg_replace_callback passes $matches but the callback expects
            // $all, $group1, ... $groupN instead.
            $arguments = self::flatten( $arguments );
        }
        if ( isset( $this->options['retain'] ) ) {
            // This is useful when the callback is a predefined function which expects only so
            // many arguments and throws a warning if it gets more or less that that.
            $arguments = self::select( $arguments, $this->options['retain'] );
        } elseif ( isset( $this->options['remove'] ) ) {
            // This is useful when the callback is a predefined function which expects only so
            // many arguments and throws a warning if it gets more or less that that.
            $arguments = self::select( $arguments, null, $this->options['remove'] );
        }
        if ( isset( $this->options['extra'] ) ) {
            // We merge compile time arguments PLUS run-time arguments instead of the other way around
            // because the programmer will always know what arguments she needs at compile time,
            // because she needs to provide them before, while the number of run-time arguments
            // could vary.
            $arguments = array_merge( array_values( $this->options['extra'] ), $arguments );
        }
        if ( isset( $this->options['order'] ) ) {
            // This is useful when the callback expects arguments in a different order than the
            // one the caller is using. It also allows the programmer to "discard" certain arguments.
            // In reality, arguments are not discarded, they are just postponed, which will look
            // like discarded if the callback doesn't access them.
            $arguments = self::permute( $arguments, explode( ' ', $this->options['order'] ) );
        }
        $result = call_user_func_array( $this->callback, $arguments );
        return $result;
    }
}

