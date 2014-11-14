<?php

class Ando_Html_Spec
{

    /**
     * HTML elements.
     * This is initialized here with notes only, but it is completed by the constructor.
     *
     * @link http://www.w3schools.com/tags/ (taken at 2014/10/17 13:00 UTC)
     *
     * @var array
     */
    protected $elements = array(
        'TEXT' => array(
            'notes' => 'Any string of text that is not inter-element whitespace.'
        ),
        'COMMENT' => array(
            'notes' => 'Defines a comment.'
        ),
        'DOCTYPE' => array(
            'notes' => 'Defines the document type.'
        ),
        'a' => array(
            'notes' => 'Defines a hyperlink.'
        ),
        'abbr' => array(
            'notes' => 'Defines an abbreviation.'
        ),
        'acronym' => array(
            'notes' => 'Not supported in HTML5. Use <abbr> instead. Defines an acronym.'
        ),
        'address' => array(
            'notes' => 'Defines contact information for the author/owner of a document.'
        ),
        'applet' => array(
            'notes' => 'Not supported in HTML5. Use <object> instead. Defines an embedded applet.'
        ),
        'area' => array(
            'notes' => 'Defines an area inside an image-map.'
        ),
        'article' => array(
            'notes' => 'Defines an article.'
        ),
        'aside' => array(
            'notes' => 'Defines content aside from the page content.'
        ),
        'audio' => array(
            'notes' => 'Defines sound content.'
        ),
        'b' => array(
            'notes' => 'Defines bold text.'
        ),
        'base' => array(
            'notes' => 'Specifies the base URL/target for all relative URLs in a document.'
        ),
        'basefont' => array(
            'notes' => 'Not supported in HTML5. Use CSS instead. Specifies a default color, size, and font for all text in a document.'
        ),
        'bdi' => array(
            'notes' => 'Isolates a part of text that might be formatted in a different direction from other text outside it.'
        ),
        'bdo' => array(
            'notes' => 'Overrides the current text direction.'
        ),
        'big' => array(
            'notes' => 'Not supported in HTML5. Use CSS instead. Defines big text.'
        ),
        'blockquote' => array(
            'notes' => 'Defines a section that is quoted from another source.'
        ),
        'body' => array(
            'notes' => 'Defines the document\'s body.'
        ),
        'br' => array(
            'notes' => 'Defines a single line break.'
        ),
        'button' => array(
            'notes' => 'Defines a clickable button.'
        ),
        'canvas' => array(
            'notes' => 'Used to draw graphics, on the fly, via scripting (usually JavaScript).'
        ),
        'caption' => array(
            'notes' => 'Defines a table caption.'
        ),
        'center' => array(
            'notes' => 'Not supported in HTML5. Use CSS instead. Defines centered text.'
        ),
        'cite' => array(
            'notes' => 'Defines the title of a work.'
        ),
        'code' => array(
            'notes' => 'Defines a piece of computer code.'
        ),
        'col' => array(
            'notes' => 'Specifies column properties for each column within a <colgroup> element.'
        ),
        'colgroup' => array(
            'notes' => 'Specifies a group of one or more columns in a table for formatting.'
        ),
        'datalist' => array(
            'notes' => 'Specifies a list of pre-defined options for input controls.'
        ),
        'dd' => array(
            'notes' => 'Defines a description/value of a term in a description list.'
        ),
        'del' => array(
            'notes' => 'Defines text that has been deleted from a document.'
        ),
        'details' => array(
            'notes' => 'Defines additional details that the user can view or hide.'
        ),
        'dfn' => array(
            'notes' => 'Defines a definition term.'
        ),
        'dialog' => array(
            'notes' => 'Defines a dialog box or window.'
        ),
        'dir' => array(
            'notes' => 'Not supported in HTML5. Use <ul> instead. Defines a directory list.'
        ),
        'div' => array(
            'notes' => 'Defines a section in a document.'
        ),
        'dl' => array(
            'notes' => 'Defines a description list.'
        ),
        'dt' => array(
            'notes' => 'Defines a term/name in a description list.'
        ),
        'em' => array(
            'notes' => 'Defines emphasized text.'
        ),
        'embed' => array(
            'notes' => 'Defines a container for an external (non-HTML) application.'
        ),
        'fieldset' => array(
            'notes' => 'Groups related elements in a form.'
        ),
        'figcaption' => array(
            'notes' => 'Defines a caption for a <figure> element.'
        ),
        'figure' => array(
            'notes' => 'Specifies self-contained content.'
        ),
        'font' => array(
            'notes' => 'Not supported in HTML5. Use CSS instead. Defines font, color, and size for text.'
        ),
        'footer' => array(
            'notes' => 'Defines a footer for a document or section.'
        ),
        'form' => array(
            'notes' => 'Defines an HTML form for user input.'
        ),
        'frame' => array(
            'notes' => 'Not supported in HTML5. Defines a window (a frame) in a frameset.'
        ),
        'frameset' => array(
            'notes' => 'Not supported in HTML5. Defines a set of frames.'
        ),
        'h1' => array(
            'notes' => 'Defines HTML headings.'
        ),
        'h2' => array(
            'notes' => 'Defines HTML headings.'
        ),
        'h3' => array(
            'notes' => 'Defines HTML headings.'
        ),
        'h4' => array(
            'notes' => 'Defines HTML headings.'
        ),
        'h5' => array(
            'notes' => 'Defines HTML headings.'
        ),
        'h6' => array(
            'notes' => 'Defines HTML headings.'
        ),
        'head' => array(
            'notes' => 'Defines information about the document.'
        ),
        'header' => array(
            'notes' => 'Defines a header for a document or section.'
        ),
        'hgroup' => array(
            'notes' => 'Defines a group of headings.'
        ),
        'hr' => array(
            'notes' => 'Defines a thematic change in the content.'
        ),
        'html' => array(
            'notes' => 'Defines the root of an HTML document.'
        ),
        'i' => array(
            'notes' => 'Defines a part of text in an alternate voice or mood.'
        ),
        'iframe' => array(
            'notes' => 'Defines an inline frame.'
        ),
        'img' => array(
            'notes' => 'Defines an image.'
        ),
        'input' => array(
            'notes' => 'Defines an input control.'
        ),
        'ins' => array(
            'notes' => 'Defines a text that has been inserted into a document.'
        ),
        'kbd' => array(
            'notes' => 'Defines keyboard input.'
        ),
        'keygen' => array(
            'notes' => 'Defines a key-pair generator field (for forms).'
        ),
        'label' => array(
            'notes' => 'Defines a label for an <input> element.'
        ),
        'legend' => array(
            'notes' => 'Defines a caption for a <fieldset> element.'
        ),
        'li' => array(
            'notes' => 'Defines a list item.'
        ),
        'link' => array(
            'notes' => 'Defines the relationship between a document and an external resource (most used to link to style sheets).'
        ),
        'main' => array(
            'notes' => 'Specifies the main content of a document.'
        ),
        'map' => array(
            'notes' => 'Defines a client-side image-map.'
        ),
        'mark' => array(
            'notes' => 'Defines marked/highlighted text.'
        ),
        'menu' => array(
            'notes' => 'Defines a list/menu of commands.'
        ),
        'menuitem' => array(
            'notes' => 'Defines a command/menu item that the user can invoke from a popup menu.'
        ),
        'meta' => array(
            'notes' => 'Defines metadata about an HTML document.'
        ),
        'meter' => array(
            'notes' => 'Defines a scalar measurement within a known range (a gauge).'
        ),
        'nav' => array(
            'notes' => 'Defines navigation links.'
        ),
        'noframes' => array(
            'notes' => 'Not supported in HTML5. Defines an alternate content for users that do not support frames.'
        ),
        'noscript' => array(
            'notes' => 'Defines an alternate content for users that do not support client-side scripts.'
        ),
        'object' => array(
            'notes' => 'Defines an embedded object.'
        ),
        'ol' => array(
            'notes' => 'Defines an ordered list.'
        ),
        'optgroup' => array(
            'notes' => 'Defines a group of related options in a drop-down list.'
        ),
        'option' => array(
            'notes' => 'Defines an option in a drop-down list.'
        ),
        'output' => array(
            'notes' => 'Defines the result of a calculation.'
        ),
        'p' => array(
            'notes' => 'Defines a paragraph.'
        ),
        'param' => array(
            'notes' => 'Defines a parameter for an object.'
        ),
        'pre' => array(
            'notes' => 'Defines preformatted text.'
        ),
        'progress' => array(
            'notes' => 'Represents the progress of a task.'
        ),
        'q' => array(
            'notes' => 'Defines a short quotation.'
        ),
        'rp' => array(
            'notes' => 'Defines what to show in browsers that do not support ruby annotations.'
        ),
        'rt' => array(
            'notes' => 'Defines an explanation/pronunciation of characters (for East Asian typography).'
        ),
        'ruby' => array(
            'notes' => 'Defines a ruby annotation (for East Asian typography).'
        ),
        's' => array(
            'notes' => 'Defines text that is no longer correct.'
        ),
        'samp' => array(
            'notes' => 'Defines sample output from a computer program.'
        ),
        'script' => array(
            'notes' => 'Defines a client-side script.'
        ),
        'section' => array(
            'notes' => 'Defines a section in a document.'
        ),
        'select' => array(
            'notes' => 'Defines a drop-down list.'
        ),
        'small' => array(
            'notes' => 'Defines smaller text.'
        ),
        'source' => array(
            'notes' => 'Defines multiple media resources for media elements (<video> and <audio>).'
        ),
        'span' => array(
            'notes' => 'Defines a section in a document.'
        ),
        'strike' => array(
            'notes' => 'Not supported in HTML5. Use <del> instead. Defines strikethrough text.'
        ),
        'strong' => array(
            'notes' => 'Defines important text.'
        ),
        'style' => array(
            'notes' => 'Defines style information for a document.'
        ),
        'sub' => array(
            'notes' => 'Defines subscripted text.'
        ),
        'summary' => array(
            'notes' => 'Defines a visible heading for a <details> element.'
        ),
        'sup' => array(
            'notes' => 'Defines superscripted text.'
        ),
        'table' => array(
            'notes' => 'Defines a table.'
        ),
        'tbody' => array(
            'notes' => 'Groups the body content in a table.'
        ),
        'td' => array(
            'notes' => 'Defines a cell in a table.'
        ),
        'textarea' => array(
            'notes' => 'Defines a multiline input control (text area).'
        ),
        'tfoot' => array(
            'notes' => 'Groups the footer content in a table.'
        ),
        'th' => array(
            'notes' => 'Defines a header cell in a table.'
        ),
        'thead' => array(
            'notes' => 'Groups the header content in a table.'
        ),
        'time' => array(
            'notes' => 'Defines a date/time.'
        ),
        'title' => array(
            'notes' => 'Defines a title for the document.'
        ),
        'tr' => array(
            'notes' => 'Defines a row in a table.'
        ),
        'track' => array(
            'notes' => 'Defines text tracks for media elements (<video> and <audio>).'
        ),
        'tt' => array(
            'notes' => 'Not supported in HTML5. Use CSS instead. Defines teletype text.'
        ),
        'u' => array(
            'notes' => 'Defines text that should be stylistically different from normal text.'
        ),
        'ul' => array(
            'notes' => 'Defines an unordered list.'
        ),
        'var' => array(
            'notes' => 'Defines a variable.'
        ),
        'video' => array(
            'notes' => 'Defines a video or movie.'
        ),
        'wbr' => array(
            'notes' => 'Defines a possible line-break.'
        )
    );

    /**
     * Categories each HTML element belongs to (can be more than one).
     *
     * @var array
     */
    protected $categories = array(
        'metadata',
        'flow',
        'sectioning',
        'heading',
        'phrasing',
        'embedded',
        'interactive',
        'form-associated',
        'listed',
        'submittable',
        'resettable',
        'reassociateable',
        'labelable',
        'palpable',
        'script-supporting'
    );

    /**
     * List of HTML elements per category.
     *
     * @var array
     */
    protected $category = array();

    /**
     * Set each category to that list.
     *
     * @param string $category
     * @param string $list
     */
    protected function category_set($category, $list)
    {
        $instance = self::instance();
        $list = explode(', ', $list);
        $instance->category[$category] = $list;
        foreach ($list as $name) {
            $if = ' if ';
            $if_offset = strpos($name, $if);
            if (-1 < $if_offset) {
                $real_name = substr($name, 0, $if_offset);
                $real_category = $category . ' ' . substr($name, $if_offset + strlen($if));
            } else {
                $real_name = $name;
                $real_category = $category;
            }
            $instance->elements[$real_name]['categories'][] = $real_category;
        }
    }

    /**
     * Set all categories to their respective lists.
     */
    protected function categories_set()
    {
        $this->category_set('metadata', 'base, command, link, meta, noscript, script, style, title');
        $this->category_set('flow',
            'a, abbr, address, article, aside, audio, b,bdo, bdi, blockquote, br, button, canvas, cite, code, command, data, datalist, del, details, dfn, div, dl, em, embed, fieldset, figure, footer, form, h1, h2, h3, h4, h5, h6, header, hgroup, hr, i, iframe, img, input, ins, kbd, keygen, label, main, map, mark, math, menu, meter, nav, noscript, object, ol, output, p, pre, progress, q, ruby, s, samp, script, section, select, small, span, strong, sub, sup, svg, table, template, textarea, time, ul, var, video, wbr, text');
        $this->category_set('sectioning', 'article, aside, nav, section');
        $this->category_set('heading', 'h1, h2, h3, h4, h5, h6, hgroup');
        $this->category_set('phrasing',
            'abbr, audio, b, bdo, br, button, canvas, cite, code, command, datalist, dfn, em, embed, i, iframe, img, input, kbd, keygen, label, mark, math, meter, noscript, object, output, progress, q, ruby, samp, script, select, small, span, strong, sub, sup, svg, textarea, time, var, video, wbr, text');
        $this->category_set('embedded', 'audio, canvas, embed, iframe, img, math, object, svg, video');
        $this->category_set('interactive', 'a, button, details, embed, iframe, keygen, label, select, textarea');

        $this->category_set('form-associated', 'button, fieldset, input, keygen, label, object, output, select, textarea, img');
        $this->category_set('listed', 'button, fieldset, input, keygen, object, output, select, textarea');
        $this->category_set('submittable', 'button, input, keygen, object, select, textarea');
        $this->category_set('resettable', 'input, keygen, output, select, textarea');
        $this->category_set('reassociateable', 'button, fieldset, input, keygen, label, object, output, select, textarea');
        $this->category_set('labelable', 'button, keygen, meter, output, progress, select, textarea');

        $this->category_set('transparent', '');
        $this->category_set('palpable',
            'a, abbr, address, article, aside, controls, b, bdi, bdo, blockquote, button, canvas, cite, code, data, details, dfn, div, em, embed, fieldset, figure, footer, form, h1, h2, h3, h4, h5, h6, header, hgroup, i, iframe, img, ins, kbd, keygen, label, main, map, mark, math, meter, nav, object, output, p, pre, progress, q, ruby, s, samp, section, select, small, span, strong, sub, sup, svg, table, textarea, time, u, var, video, text');
        $this->category_set('script-supporting', 'script, template');

        $this->category_set('flow-if', 'area if descendant of map element, link if itemprop attribute present, meta if itemprop attribute present, style if itemprop attribute present');
        $this->category_set('phrasing-if', 'area if descendant of map element, link if itemprop attribute present, meta if itemprop attribute present');
        $this->category_set('interactive-if', 'audio if controls attribute present, img if usemap attribute present, input if type attribute not hidden, object if usemap attribute present, video if controls attribute present');
        $this->category_set('labelable-if', 'input if type attribute not hidden');
        $this->category_set('palpable-if',
            'audio if controls attribute present, dl if children include at least one name-value group, input if type attribute not hidden, menu if type attribute toolbar, ol if children include at least one li element, ul if children include at least one li element');
    }

    /**
     * Constructor (singleton)
     */
    protected function __construct()
    {
        $this->categories_set();
    }

    /**
     * The instance of this singleton.
     *
     * @var Ando_Html_Spec
     */
    protected static $instance;

    /**
     * Get the instance.
     *
     * @return Ando_Html_Spec
     */
    static public function instance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * All the HTML info about an element.
     *
     * @param string $name
     *
     * @return array
     */
    static public function info($name)
    {
        $instance = self::instance();
        if (isset($instance->elements[$name])) {
            return $instance->elements[$name];
        } else {
            return array();
        }
    }

    /**
     * True if the node has the category.
     *
     * @throws Ando_Exception
     *
     * @param Ando_Html_Node $node
     * @param string         $category
     *
     * @return boolean
     */
    static public function has_category($node, $category)
    {
        $instance = self::instance();
        $name = $node->name();
        if (!isset($instance->elements[$name])) {
            throw new Ando_Exception('Expected a valid HTML element name. (got instead "' . $name . '")');
        }
        if (!in_array($category, $instance->categories)) {
            throw new Ando_Exception('Expected a valid HTML element category. (got instead "' . $category . '")');
        }
        if (in_array($category, $instance->elements[$name]['categories'])) {
            return true;
        }

        $result = false;
        switch ($name) {

            case 'area':
                if ($category == 'flow' || $category == 'phrasing') {
                    $ancestors = Ando_Collection::def($node->ancestors())->pluck('name');
                    $result = in_array('map', $ancestors);
                }
                break;

            case 'link':
            case 'meta':
                if ($category == 'flow' || $category == 'phrasing') {
                    $attrs = $node->attributes();
                    $result = isset($attrs['itemprop']);
                }
                break;

            case 'style':
                if ($category == 'flow') {
                    $attrs = $node->attributes();
                    $result = isset($attrs['itemprop']);
                }
                break;

            case 'audio':
                if ($category == 'interactive' || $category == 'palpable') {
                    $attrs = $node->attributes();
                    $result = isset($attrs['controls']);
                }
                break;

            case 'img':
                if ($category == 'interactive') {
                    $attrs = $node->attributes();
                    $result = isset($attrs['usemap']);
                }
                break;

            case 'input':
                if (in_array($category, array(
                    'interactive',
                    'labelable',
                    'palpable'
                ))) {
                    $attrs = $node->attributes();
                    $result = $attrs['type'] != 'hidden';
                }
                break;

            case 'object':
                if ($category == 'interactive') {
                    $attrs = $node->attributes();
                    $result = isset($attrs['usemap']);
                }
                break;

            case 'video':
                if ($category == 'interactive') {
                    $attrs = $node->attributes();
                    $result = isset($attrs['controls']);
                }
                break;

            case 'dl':
                if ($category == 'palpable') {
                    $children = Ando_Collection::def($node->children())->pluck('name');
                    $result = in_array('dt', $children) && in_array('dd', $children);
                }
                break;

            case 'menu':
                if ($category == 'palpable') {
                    $attrs = $node->attributes();
                    $result = $attrs['type'] == 'toolbar';
                }
                break;

            case 'ol':
            case 'ul':
                if ($category == 'palpable') {
                    $children = Ando_Collection::def($node->children())->pluck('name');
                    $result = in_array('li', $children);
                }
                break;

            default:
                break;
        }
        return $result;
    }

    /**
     * True if an element with that name is void but looks like a start.
     *
     * @param string $name
     *
     * @return boolean
     */
    static public function is_void_but_looks_like_a_start($name)
    {
        if (in_array($name, array(
            'br',
            'hr'
        ))) {
            return true;
        }
        return false;
    }

    /**
     * True if the node has valid context.
     *
     * @param Ando_Html_Node $node
     *
     * @return boolean
     */
    static public function has_valid_context($node)
    {
        $instance = self::instance();
        $name = $node->name();
        $method = $name . '_' . __METHOD__;
        if (method_exists($instance, $method)) {
            $result = $instance->$method($node);
        } else {
            $result = true; // this is for ignoring anything we don't know about
        }
        return $result;
    }

    /**
     * True if the node has valid content.
     *
     * @param Ando_Html_Node $node
     *
     * @return boolean
     */
    static public function has_valid_content($node)
    {
        $instance = self::instance();
        $name = $node->name();
        $method = $name . '_' . __METHOD__;
        if (method_exists($instance, $method)) {
            $result = $instance->$method($node);
        } else {
            $result = true; // this is for ignoring anything we don't know about
        }
        return $result;
    }

    /**
     * True if node has valid context.
     *
     * @throws Ando_Exception
     *
     * @param Ando_Html_Node $node
     *
     * @return boolean
     */
    protected function html_has_valid_context($node)
    {
        if ($node->name() != 'html') {
            throw new Ando_Exception('Expected a "html" node. (got instead "' . $node->name() . '")');
        }
        $result = $node->is_root();
        return $result;
    }

    /**
     * True if the node has valid content.
     *
     * @throws Ando_Exception
     *
     * @param Ando_Html_Node $node
     *
     * @return boolean
     */
    protected function html_has_valid_content($node)
    {
        if ($node->name() != 'html') {
            throw new Ando_Exception('Expected a "html" node. (got instead "' . $node->name() . '")');
        }
        $children = $node->children();
        $result = count($children) == 2 && $children[0]->name() == 'head' && $children[1]->name() == 'body';
        return $result;
    }

}