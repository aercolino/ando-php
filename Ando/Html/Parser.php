<?php
/**
 * Basic HTML Parser
 *
 * @link http://andowebsit.es/blog/noteslog.com/
 *
 * @package Ando_Html
 */
class Ando_Html_Parser
{

    const DOCUMENT_INDEX = -1;

    /**
     *
     * @var string
     */
    protected $html;

    /**
     *
     * @var array
     */
    protected $tokens;

    /**
     *
     * @var array
     */
    protected $tree;

    /**
     *
     * @var array
     */
    protected $registry;

    var $t = array(
        0 => array(
            self::DOCUMENT_INDEX,
            array(),
            array(
                'html'
            )
        ),
        1 => array(
            self::DOCUMENT_INDEX,
            array()
        ),
        2 => array(
            self::DOCUMENT_INDEX,
            array(),
            array(),
            array(
                3,
                4,
                11,
                12,
                17
            ),
            array(
                5,
                6,
                9,
                7,
                13,
                14,
                15
            )
        ),
        3 => array(
            2,
            array(
                self::DOCUMENT_INDEX
            )
        ),
        4 => array(
            2,
            array(
                self::DOCUMENT_INDEX
            ),
            array(),
            array(
                5,
                6,
                9
            ),
            array(
                7
            )
        ),
        5 => array(
            4,
            array(
                2,
                self::DOCUMENT_INDEX
            )
        ),
        6 => array(
            4,
            array(
                2,
                self::DOCUMENT_INDEX
            ),
            array(),
            array(
                7
            ),
            array()
        ),
        7 => array(
            6,
            array(
                4,
                2,
                self::DOCUMENT_INDEX
            )
        ),
        9 => array(
            4,
            array(
                2,
                self::DOCUMENT_INDEX
            )
        ),
        11 => array(
            2,
            array(
                self::DOCUMENT_INDEX
            )
        ),
        12 => array(
            2,
            array(
                self::DOCUMENT_INDEX
            ),
            array(),
            array(
                13,
                14,
                15
            ),
            array()
        ),
        13 => array(
            12,
            array(
                2,
                self::DOCUMENT_INDEX
            )
        ),
        14 => array(
            12,
            array(
                2,
                self::DOCUMENT_INDEX
            )
        ),
        15 => array(
            12,
            array(
                2,
                self::DOCUMENT_INDEX
            )
        ),
        17 => array(
            2,
            array(
                self::DOCUMENT_INDEX
            )
        )
    );


    // reading the tokens one by one, the above tree can be built in one pass
    // all tokens but the closing tags create a node
    // an opening tag implies a push
    // a closing tag implies a pop
    // the parent is the top of the stack before pushing the current element (if a push is implied)
    // each node, after determining its parent, must be added as a child to it,
    // and as another descendant to each of its other ancestors
    // when the stack is empty the parent is self::DOCUMENT_INDEX, which means the document
    // the format for non void elements is: parent, other ancestors, attributes, children, other descendants
    // the format for void elements is: parent, other ancestors, attributes array
    // the format for texts and comments is: parent, other ancestors
    // all elements can have attributes, inluding br, e.g. style="display: none;"

    // the tree could also be easily integrated into the list of tokens by adding new keys.

    protected function must_fix_parent ($index, $ancestors)
    {
        $parent = $ancestors[count($ancestors) - 1];
        if ($parent['index'] == self::DOCUMENT_INDEX)
        {
            return false;
        }

        if ($parent['name'] == $child['name'])
        {
            if ($child['name'] == 'div' || $child['name'] == 'span')
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        // TODO continue developing must_fix_parent

        return true;
    }

    protected function fix_parent ($index, $ancestors)
    {
        if (!$this->must_fix_parent($index, $ancestors))
        {
            return $ancestors;
        }


    }

    protected function register ($key, $value)
    {
        $this->registry[$key][] = $value;
    }

    protected function add_descendant ($node)
    {
        $parent = $this->tree[$index]['parent']['index'];
        $this->tree[$parent]['children'][] = $item;

        $ancestors = $this->tree[$index]['ancestors'];
        foreach ($ancestors as $ancestor)
        {
            $this->tree[$ancestor]['descendants'][] = $item;
        }
    }

    protected function make_tree ()
    {
        $ancestors = array();
        foreach ($this->tokens as $index => $token)
        {
            /**
             * @var Ando_Html_Token $token
             */
            switch ($token->type())
            {

                case Ando_Html_Token::TYPE_START:
                    $ancestors = $this->fix_parent($index, $ancestors); // like P still open before opening DIV or BR always

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
                    $this->tree[$index] = $node;
                    $node->link_from_ancestors();
                    $this->register($node->name(), $node);
                    array_push($ancestors, $node);
                break;

                case Ando_Html_Token::TYPE_END:
                    $parent = count($ancestors) ? $ancestors[count($ancestors) - 1] : null;
                    /**
                     * @var Ando_Html_Node $parent
                     */
                    if (!is_null($parent) && $this->parent->name() == $token->tag())
                    {
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
                    $this->tree[$index] = $node;
                    $node->link_from_ancestors();
                    $this->register($node->name(), $node);
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
                    $this->tree[$index] = $node;
                    $node->link_from_ancestors();
                    $this->register($node->name(), $node);
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


    var $elements = array(
        'html' => 2,
        'head' => 4,
        'title' => 6,
        'body' => 12
    );

    // this is to later find elements in a snap
    // it is built during the same pass as the tree
    // when elements are repeated, like div, the value becomes an array

    // this and the other arrays could be integrated int the registry


    var $ids = array(); // same as $elements, but or ids

    // integrated into the registry, the keys would be like '#key'


    var $classes = array(); // same as $elements, but or classes

    // integrated into the registry, the keys would be like '.key'


    var $data = array(); // same as $elements, but or data

    // integrated into the registry, the keys would be like 'data-key'


    var $attributes = array(); // same as $elements, but or attributes

    // integrated into the registry, the keys would be like '[key]'



    // to find all divs of a certain class in a given context
                               // - take all divs
                               // - intersect with all elements of that class
                               // - intersect with all elements of that context
                               // all elements in a context are all of its descendants (children + other descendants)

    protected function key ()
    {

    }

    public function __construct ($html)
    {
        $this->html = $html;
        $this->tokens = Ando_Html_Tokenizer::tokenize($html);
    }

    public function parse ()
    {
        $this->tree = $this->make_tree();
    }

}