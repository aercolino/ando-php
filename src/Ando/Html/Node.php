<?php
/**
 * Basic HTML Node
 *
 * @link http://andowebsit.es/blog/noteslog.com/
 *
 * @package    Ando_Html
 */
class Ando_Html_Node
{

    /**
     * Index of the node.
     * If the node comes from a token, it's the same index.
     *
     * @var integer
     */
    protected $index;

    /**
     * Get the index.
     *
     * @return integer
     */
    public function index ()
    {
        return $this->index;
    }

    /**
     * Name of the node.
     * - For an element other than text and comment, it's the tag name.
     * - For a text or comment it's TEXT or COMMENT.
     * - Text which was inter element white space is never a node.
     *
     * @var string
     */
    protected $name;

    /**
     * Get the name.
     *
     * @return string
     */
    public function name ()
    {
        return $this->name;
    }

    /**
     * Parent of the node.
     *
     * @var Ando_Html_Node
     */
    protected $parent;

    /**
     * Get the parent.
     *
     * @return Ando_Html_Node
     */
    public function parent ()
    {
        return $this->parent;
    }

    /**
     * Ancestors of the node, including its parent.
     *
     * @var Ando_Html_Node[]
     */
    protected $ancestors;

    /**
     * Get the ancestors.
     *
     * @return Ando_Html_Node[]
     */
    public function ancestors ($and_parent = true)
    {
        $result = $this->ancestors;
        if (!$and_parent)
        {
            $result = array_values(array_diff($result, array(
                    $this->parent
            )));
        }
        return $result;
    }

    /**
     * Attributes of the node.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function attributes ()
    {
        return $this->attributes;
    }

    /**
     * Children of the node.
     *
     * @var Ando_Html_Node[]
     */
    protected $children;

    /**
     * Get the children.
     *
     * @return Ando_Html_Node[]
     */
    public function children ()
    {
        return $this->children;
    }

    /**
     * Descendants of the node, including its children.
     *
     * @var Ando_Html_Node[]
     */
    protected $descendants;

    /**
     * Get the descendants.
     *
     * @param boolean $and_children
     * @return Ando_Html_Node[]
     */
    public function descendants ($and_children = true)
    {
        $result = $this->descendants;
        if (!$and_children)
        {
            $result = array_values(array_diff($result, $this->children));
        }
        return $result;
    }

    /**
     * Content of the node, only meaningful if the node is TEXT or COMMENT.
     *
     * @var string
     */
    protected $content;

    /**
     * Get the content.
     *
     * @return string
     */
    public function content ()
    {
        return $this->content;
    }

    /**
     * Constructor.
     *
     * @param array $data  An associative array for specifying node properties.
     */
    public function __construct ($data)
    {
        $this->index = isset($data['index']) ? $data['index'] : null;
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->parent = isset($data['parent']) ? $data['parent'] : null;
        $this->ancestors = isset($data['ancestors']) ? $data['ancestors'] : null;
        $this->attributes = isset($data['attributes']) ? $data['attributes'] : null;
        $this->children = isset($data['children']) ? $data['children'] : null;
        $this->descendants = isset($data['descendants']) ? $data['descendants'] : null;
        $this->content = isset($data['content']) ? $data['content'] : null;
    }

    /**
     * True if this node is a root node.
     *
     * @return bool
     */
    public function is_root ()
    {
        return is_null($this->parent);
    }

    /**
     * True if this node is a leaf node.
     *
     * @return bool
     */
    public function is_leaf ()
    {
        return 0 == count($this->children);
    }

    /**
     * True if the other node is a sibling of this one.
     *
     * @param Ando_Html_Node $other
     * @return bool
     */
    public function is_sibling ($other)
    {
        return $other->parent == $this->parent;
    }

    /**
     * Get the siblings of this node.
     *
     * @param bool $and_self  True if this node is to be included or not.
     * @return Ando_Html_Node[]
     */
    public function siblings ($and_self = false)
    {
        if ($this->is_root())
        {
            return array();
        }
        $result = $this->parent->children;
        if (!$and_self)
        {
            $result = array_values(array_diff($result, array(
                    $this
            )));
        }
        return $result;
    }

    /**
     * Add this node to each of its ancestors, both as a child of its parent
     * and as a descendant of any ancestor, including its parent.
     *
     * @return Ando_Html_Node
     */
    public function link_from_ancestors ()
    {
        foreach ($this->ancestors as $ancestor)
        {
            $ancestor->descendants[] = $this;
            array_unique($ancestor->descendants);
        }
        if (!$this->is_root())
        {
            $this->parent->children[] = $this;
            array_unique($this->parent->children);
        }
        return $this;
    }

}
