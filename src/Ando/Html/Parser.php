<?php

class Ando_Html_Parser
{
    /**
     * HTML source.
     *
     * @var string
     */
    protected $html;

    /**
     * Tokens found in the html.
     *
     * @var Ando_Html_Token[]
     */
    protected $tokens;

    /**
     * Nodes found in the html.
     *
     * @var Ando_Html_Node[]
     */
    protected $nodes;

    /**
     * True if the parent needs fixing.
     *
     * @param integer          $index
     * @param Ando_Html_Node[] $ancestors
     *
     * @return bool
     */
    protected function must_fix_parent($index, $ancestors)
    {
        /**
         * @var Ando_Html_Node $parent
         */
        $parent = count($ancestors) ? $ancestors[count($ancestors) - 1] : null;
        if (is_null($parent)) {
            return false;
        }
        if ($parent->is_root()) {
            return false;
        }
        $current_tag = $this->tokens[$index]->tag();
        if ($parent->name() == $current_tag) {
            if ($current_tag == 'div' || $current_tag == 'span') {
                return false;  // div and span can contain themselves
            } else {
                return true;
            }
        }

        // TODO continue developing must_fix_parent

        return true;
    }

    /**
     * Fix html tokens somehow (hopefully in a smart way).
     *
     * For example, if a DIV is found inside a P, this code
     * would close that P before processing this DIV.
     *
     * @param integer          $index
     * @param Ando_Html_Node[] $ancestors
     *
     * @return Ando_Html_Node[]
     */
    protected function fix_parent($index, $ancestors)
    {
        $result = $ancestors;
        if (!$this->must_fix_parent($index, $ancestors)) {
            return $result;
        }

        // TODO continue developing fix_parent

        return $result;
    }

    /**
     * Build nodes from tokens.
     */
    protected function find_nodes()
    {
        $ancestors = array();
        foreach ($this->tokens as $index => $token) {
            /**
             * @var Ando_Html_Token $token
             */
            switch ($token->type()) {

                case Ando_Html_Token::TYPE_START:
                    $ancestors = $this->fix_parent($index, $ancestors); // like P still open before opening DIV
                    $parent = count($ancestors) ? $ancestors[count($ancestors) - 1] : null;
                    /**
                     * @var Ando_Html_Node $parent
                     */
                    $data = array(
                        'index' => $token->index(),
                        'name' => $token->tag(),
                        'parent' => $parent,
                        'ancestors' => $ancestors,
                        'attributes' => $this->parse_attributes($token->source()),
                        'children' => array(),
                        'descendants' => array()
                    );
                    $node = new Ando_Html_Node($data);
                    $this->nodes[$index] = $node;
                    $node->link_from_ancestors();
                    $this->register($node);
                    array_push($ancestors, $node);
                    break;

                case Ando_Html_Token::TYPE_END:
                    $parent = count($ancestors) ? $ancestors[count($ancestors) - 1] : null;
                    /**
                     * @var Ando_Html_Node $parent
                     */
                    if (!is_null($parent) && $parent->name() == $token->tag()) {
                        array_pop($ancestors);
                    }
                    break;

                case Ando_Html_Token::TYPE_VOID:
                    $parent = count($ancestors) ? $ancestors[count($ancestors) - 1] : null;
                    /**
                     * @var Ando_Html_Node $parent
                     */
                    $data = array(
                        'index' => $token->index(),
                        'name' => $token->tag(),
                        'parent' => $parent,
                        'ancestors' => $ancestors,
                        'attributes' => $this->parse_attributes($token->source())
                    );
                    $node = new Ando_Html_Node($data);
                    $this->nodes[$index] = $node;
                    $node->link_from_ancestors();
                    $this->register($node);
                    break;

                case Ando_Html_Token::TYPE_TEXT:
                case Ando_Html_Token::TYPE_COMMENT:
                    $parent = count($ancestors) ? $ancestors[count($ancestors) - 1] : null;
                    /**
                     * @var Ando_Html_Node $parent
                     */
                    $data = array(
                        'index' => $token->index(),
                        'name' => strtoupper($token->type()),
                        'parent' => $parent,
                        'ancestors' => $ancestors,
                        'content' => $token->source()
                    );
                    $node = new Ando_Html_Node($data);
                    $this->nodes[$index] = $node;
                    $node->link_from_ancestors();
                    $this->register($node);
                    break;

                case Ando_Html_Token::TYPE_DOCTYPE:
                    // TODO: add a doctype attribute for saving the doctype
                    break;

                case Ando_Html_Token::TYPE_IEWS:
                default:
                    // ignore
                    break;
            }
        }
    }

    /**
     * Dictionary for HTML elements, #ids, .classes, data-attributes and all other [attributes].
     *
     * @var array
     */
    protected $registry;

    /**
     * Add and entry to the registry.
     *
     * @param string         $key
     * @param Ando_Html_Node $value
     */
    protected function registry_add($key, $value)
    {
        $this->registry[$key][] = $value;
    }

    /**
     * Add every piece of a node to the registry.
     *
     * @param Ando_Html_Node $node
     */
    protected function register($node)
    {
        $this->registry_add($node->name(), $node);
        $attributes = $node->attributes();
        if (count($attributes)) {
            foreach ($attributes as $name => $value) {
                switch (true) {
                    case 0 === strpos($name, 'data-'):
                        $this->registry_add($name, $node);
                        break;
                    case 'id' === $name:
                        $this->registry_add("#$value", $node);
                        break;
                    case 'class' === $name:
                        $classes = explode(' ', $value);
                        foreach ($classes as $class) {
                            $this->registry_add(".$class", $node);
                        }
                        break;
                    default:
                        $this->registry_add("[$name]", $node);
                        break;
                }
            }
        }
    }

    /**
     * Get the registry.
     *
     * We allow direct access to the registry, so that complex operations
     * are easy to implement from client code. (in any case, easier than
     * foreseeing what would be needed and implement that from here.)
     *
     * For example, lets say that client code needs to find all divs of a
     * certain class in a given context. Let's say the context is just a
     * node. Then the solution would be an intersection like this:
     * <code>
     *   $divs = array_intersect($registry['div'], $registry['.class'],
     *       node->descendants());
     * </code>
     *
     * @return array
     */
    public function registry()
    {
        return $this->registry;
    }

    /**
     * Constructor.
     *
     * @param $html
     */
    public function __construct($html)
    {
        $this->html = $html;
        $this->tokens = array();
        $this->nodes = array();
    }

    /**
     * Parse html.
     *
     * @param string $html
     *
     * @return Ando_Html_Parser
     */
    static public function parse($html)
    {
        $lexer = Ando_Html_Lexer::parse($html);
        $parser = new self($html);
        $parser->tokens = $lexer->tokens();
        $parser->find_nodes();
        return $parser;
    }

    /**
     * Add an attribute to the buffer.
     *
     * This is a callback of parse_attributes().
     *
     * @param array $buffer
     * @param array $matches
     */
    protected function attribute_add(&$buffer, $matches)
    {
        $buffer[$matches['name']] = $matches['value'];
    }

    /**
     * Split html element attributes into an array of names and values.
     *
     * @param string $source
     *
     * @return array
     */
    protected function parse_attributes($source)
    {
        $result = array();
        $regex = Ando_Regex::create('(?<name>$name)=(?<value>$value)')->interpolate(
            array(
                'name' => '([\w-]+)\s*',
                'value' => '\s*"([^"]+)"',
            )
        );
        // use Ando_Regex::replace to scan $source
        Ando_Regex::replace($regex, Ando_StarFunc::def(array($this, 'attribute_add'), array(
            'extra' => array($result),
        )), $source);
        return $result;
    }

}
