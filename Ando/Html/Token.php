<?php
/**
 * Basic HTML Token
 *
 * @link http://andowebsit.es/blog/noteslog.com/
 *
 * @package Ando_Html
 */
class Ando_Html_Token
{

    const TYPE_COMMENT = 'comment';
    const TYPE_DOCTYPE = 'doctype';
    const TYPE_VOID = 'void';
    const TYPE_SCRIPT = 'script';
    const TYPE_START = 'start';
    const TYPE_END = 'end';
    const TYPE_IEWS = 'iews'; // inter element white space
    const TYPE_TEXT = 'text';

    /**
     * Position this token was found at.
     *
     * @var integer
     */
    protected $index;

    /**
     * Get the index.
     *
     * @return unknown
     */
    public function index ()
    {
        return $this->index;
    }

    /**
     * Captured text of this token.
     *
     * @var string
     */
    protected $source;

    /**
     * Get the captured text.
     *
     * @return string
     */
    public function source ()
    {
        return $this->source;
    }

    /**
     * Offset of the source of this token.
     *
     * @var integer
     */
    protected $offset;

    /**
     * Get the offset.
     *
     * @return integer
     */
    public function offset ()
    {
        return $this->offset;
    }

    /**
     * Length of the source of this token.
     *
     * @var integer
     */
    protected $length;

    /**
     * Get the length.
     *
     * @return integer
     */
    public function length ()
    {
        return $this->length;
    }

    /**
     * Type of this token.
     *
     * @var string
     */
    protected $type;

    /**
     * Get the type.
     *
     * @return string
     */
    public function type ()
    {
        return $this->type;
    }

    /**
     * HTML tag of this token, if any.
     *
     * @var string
     */
    protected $tag;

    /**
     * Get the HTML tag.
     *
     * @return string
     */
    public function tag ()
    {
        return $this->tag;
    }

    /**
     * Create a token from a data array.
     *
     * @param array $data
     */
    public function __construct ($data)
    {
        $this->index = isset($data['index']) ? $data['index'] : null;
        $this->source = isset($data['source']) ? $data['source'] : null;
        $this->offset = isset($data['offset']) ? $data['offset'] : null;
        $this->length = isset($data['length']) ? $data['length'] : null;
        $this->type = isset($data['type']) ? $data['type'] : null;
        $this->tag = isset($data['tag']) ? $data['tag'] : null;
    }

}
