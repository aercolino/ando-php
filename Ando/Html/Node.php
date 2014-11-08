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
     *
     * @var integer
     */
    protected $index;

    /**
     *
     * @return integer
     */
    public function index ()
    {
        return $this->index;
    }

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @return string
     */
    public function name ()
    {
        return $this->name;
    }

    /**
     *
     * @var Ando_Html_Node
     */
    protected $parent;

    /**
     *
     * @return Ando_Html_Node
     */
    public function parent ()
    {
        return $this->parent;
    }

    /**
     *
     * @var array( Ando_Html_Node )
     */
    protected $ancestors;

    /**
     *
     * @return array( Ando_Html_Node )
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
     *
     * @var array
     */
    protected $attributes;

    /**
     *
     * @return array
     */
    public function attributes ()
    {
        return $this->attributes;
    }

    /**
     *
     * @var array( Ando_Html_Node )
     */
    protected $children;

    /**
     *
     * @return array( Ando_Html_Node )
     */
    public function children ()
    {
        return $this->children;
    }

    /**
     *
     * @var array( Ando_Html_Node )
     */
    protected $descendants;

    /**
     *
     * @return array( Ando_Html_Node )
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
     *
     * @var string
     */
    protected $content;

    /**
     *
     * @return string
     */
    public function content ()
    {
        return $this->content;
    }

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

    public function is_root ()
    {
        return is_null($this->parent);
    }

    public function is_leaf ()
    {
        return 0 == count($this->children);
    }

    public function is_sibling ($other)
    {
        return $other->parent == $this->parent;
    }

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
