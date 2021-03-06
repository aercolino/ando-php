<?php
/**
 * @link https://github.com/aercolino/ando-php
 * @copyright Copyright (c) 2015 Andrea Ercolino
 * @license https://github.com/aercolino/ando-php/blob/master/LICENSE
 */

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

    protected $transparent = 'a, ins, del, object, video, audio, map, noscript, canvas';

    protected function transparent_init() {
        $this->transparent = explode(', ', $this->transparent);
    }

    /**
     * List of HTML elements per category.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#kinds-of-content (taken at 2014/10/17 13:00 UTC)
     *
     * @var array
     */
    protected $category = array(
        'metadata'          => 'base, command, link, meta, noscript, script, style, title',
        'flow'              => 'a, abbr, address, article, aside, audio, b,bdo, bdi, blockquote, br, button, canvas, cite, code, command, data, datalist, del, details, dfn, div, dl, em, embed, fieldset, figure, footer, form, h1, h2, h3, h4, h5, h6, header, hgroup, hr, i, iframe, img, input, ins, kbd, keygen, label, main, map, mark, math, menu, meter, nav, noscript, object, ol, output, p, pre, progress, q, ruby, s, samp, script, section, select, small, span, strong, sub, sup, svg, table, template, textarea, time, ul, var, video, wbr, text',
        'sectioning'        => 'article, aside, nav, section',
        'heading'           => 'h1, h2, h3, h4, h5, h6, hgroup',
        'phrasing'          => 'abbr, audio, b, bdo, br, button, canvas, cite, code, command, datalist, dfn, em, embed, i, iframe, img, input, kbd, keygen, label, mark, math, meter, noscript, object, output, progress, q, ruby, samp, script, select, small, span, strong, sub, sup, svg, textarea, time, var, video, wbr, text',
        'embedded'          => 'audio, canvas, embed, iframe, img, math, object, svg, video',
        'interactive'       => 'a, button, details, embed, iframe, keygen, label, select, textarea',

        'form-associated'   => 'button, fieldset, input, keygen, label, object, output, select, textarea, img',
        'listed'            => 'button, fieldset, input, keygen, object, output, select, textarea',
        'submittable'       => 'button, input, keygen, object, select, textarea',
        'resettable'        => 'input, keygen, output, select, textarea',
        'reassociateable'   => 'button, fieldset, input, keygen, label, object, output, select, textarea',
        'labelable'         => 'button, keygen, meter, output, progress, select, textarea',

        'palpable'          => 'a, abbr, address, article, aside, controls, b, bdi, bdo, blockquote, button, canvas, cite, code, data, details, dfn, div, em, embed, fieldset, figure, footer, form, h1, h2, h3, h4, h5, h6, header, hgroup, i, iframe, img, ins, kbd, keygen, label, main, map, mark, math, meter, nav, object, output, p, pre, progress, q, ruby, s, samp, section, select, small, span, strong, sub, sup, svg, table, textarea, time, u, var, video, text',
        'script-supporting' => 'script, template',

        'flow-if'           => 'area if descendant of map element, link if itemprop attribute present, meta if itemprop attribute present, style if itemprop attribute present',
        'phrasing-if'       => 'area if descendant of map element, link if itemprop attribute present, meta if itemprop attribute present',
        'interactive-if'    => 'audio if controls attribute present, img if usemap attribute present, input if type attribute not hidden, object if usemap attribute present, video if controls attribute present',
        'labelable-if'      => 'input if type attribute not hidden',
        'palpable-if'       => 'audio if controls attribute present, dl if children include at least one name-value group, input if type attribute not hidden, menu if type attribute toolbar, ol if children include at least one li element, ul if children include at least one li element',
    );

    /**
     * Set each category to that list.
     */
    protected function category_init()
    {
        foreach ($this->category as $category => $list) {
            $list = explode(', ', $list);
            $this->category[$category] = $list;
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
                $this->elements[$real_name]['categories'][] = $real_category;
            }
        }
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/semantics.html
     *
     * @var array
     */
    protected $semantics = array(
        'root'       => 'html',

        'metadata'   => 'head, title, base, link, meta, style',

        /*
         * These all have a context "Where flow content is expected." except for
         * 'body', which has "As the second element in an html element."
         * 'h1' to 'h6' have an additional context "As a child of an hgroup element."
         */
        'section'    => 'body, article, section, nav, aside, h1, h2, h3, h4, h5, h6, hgroup, header, footer, address',

        /*
         * These all have a context "Where flow content is expected."
         */
        'grouping'   => 'p, hr, pre, blockquote, ol, ul, li, dl, dt, dd, figure, figcaption, main, div',

        /*
         * These all have a context "Where phrasing content is expected."
         */
        'text_level' => 'a, em, strong, small, s, cite, q, dfn, abbr, ruby, rt, rp, data, time, code, var, samp, kbd, sub, i, b, u, mark, bdi, bdo, span, br, wbr',

        'link'       => 'link, a, area',

        'edit'       => 'ins, del',
    );

    /**
     * Set each category to that list.
     */
    protected function semantics_init()
    {
        foreach ($this->semantics as $category => $list) {
            $list = explode(', ', $list);
            $this->semantics[$category] = $list;
        }
    }
    
    protected $global_attributes;

    protected function global_attributes_set() {
        $attributes = 'accesskey, class, contenteditable, contextmenu, dir, draggable, dropzone, hidden, id, itemid,
        itemprop, itemref, itemscope, itemtype, lang, spellcheck, style, tabindex, title, translate';

        $event_attributes = 'onabort, onautocomplete, onautocompleteerror, onblur, oncancel, oncanplay, oncanplaythrough,
        onchange, onclick, onclose, oncontextmenu, oncuechange, ondblclick, ondrag, ondragend, ondragenter, ondragexit,
        ondragleave, ondragover, ondragstart, ondrop, ondurationchange, onemptied, onended, onerror, onfocus,
        oninput, oninvalid, onkeydown, onkeypress, onkeyup, onload, onloadeddata, onloadedmetadata, onloadstart,
        onmousedown, onmouseenter, onmouseleave, onmousemove, onmouseout, onmouseover, onmouseup, onmousewheel,
        onpause, onplay, onplaying, onprogress, onratechange, onreset, onresize, onscroll, onseeked, onseeking,
        onselect, onshow, onsort, onstalled, onsubmit, onsuspend, ontimeupdate, ontoggle, onvolumechange, onwaiting';

        $body_special_event_attributes = 'onblur, onerror, onfocus, onload, onresize, onscroll';

        // see BNF below
        $data_attributes = '@^data-(?<name>...)@';  // Hyphenated names become camel-cased in 'dataset'.
        /*
         * NameStartChar ::= "_" | [a-z] | [#xC0-#xD6] | [#xD8-#xF6] | [#xF8-#x2FF] | [#x370-#x37D] | [#x37F-#x1FFF] | [#x200C-#x200D] | [#x2070-#x218F] | [#x2C00-#x2FEF] | [#x3001-#xD7FF] | [#xF900-#xFDCF] | [#xFDF0-#xFFFD] | [#x10000-#xEFFFF]
         * NameChar	     ::= NameStartChar | "-" | "." | [0-9] | #xB7 | [#x0300-#x036F] | [#x203F-#x2040]
         * Name	         ::= NameStartChar (NameChar)*
         */

        // Pages that use extension and experimental attributes are by definition non-conforming !!

        // I'm not sure yet, but the name could follow the data-name format.
        $extension_attributes = '@^x-(?<name>...)@i';

        // I'm not sure yet, but these names could follow the data-name format
        // but the spec says they contain at least one underscore !!
        $experimental_attributes = '@(?<name>...)@';

        // This attribute, if present, can only have this name and value, but it's ignored.
        $xmlns_attribute = array('xmlns' => 'http://www.w3.org/1999/xhtml');  // this is the HTML namespace !!

        $xml_space_attribute = 'xml:space';  // possible but ignored !!


        // other classifications:

        $boolean_attributes = '';

        $enumerated_attributes = '';
    }

    /**
     * Constructor (singleton)
     */
    protected function __construct()
    {
        $this->category_init();
        $this->semantics_init();
        $this->transparent_init();
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
        $categories = array_keys($instance->category);
        if (!in_array($category, $categories)) {
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
                    $attributes = $node->attributes();
                    $result = isset($attributes['itemprop']);
                }
                break;

            case 'style':
                if ($category == 'flow') {
                    $attributes = $node->attributes();
                    $result = isset($attributes['itemprop']);
                }
                break;

            case 'audio':
                if ($category == 'interactive' || $category == 'palpable') {
                    $attributes = $node->attributes();
                    $result = isset($attributes['controls']);
                }
                break;

            case 'img':
                if ($category == 'interactive') {
                    $attributes = $node->attributes();
                    $result = isset($attributes['usemap']);
                }
                break;

            case 'input':
                if (in_array($category, array(
                    'interactive',
                    'labelable',
                    'palpable'
                ))) {
                    $attributes = $node->attributes();
                    $result = !isset($attributes['type']) || $attributes['type'] != 'hidden';
                }
                break;

            case 'object':
                if ($category == 'interactive') {
                    $attributes = $node->attributes();
                    $result = isset($attributes['usemap']);
                }
                break;

            case 'video':
                if ($category == 'interactive') {
                    $attributes = $node->attributes();
                    $result = isset($attributes['controls']);
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
                    $attributes = $node->attributes();
                    $result = $attributes['type'] == 'toolbar';
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
        $result = in_array($name, array(
            'br',
            'hr'
        ));
        return $result;
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
     * True if the html node has valid context.
     *
     * @param Ando_Html_Node $node
     *
     * @return boolean
     */
    protected function html_has_valid_context($node)
    {
        $result = $node->is_root();
        return $result;
    }

    /**
     * True if the html node has valid content.
     *
     * @param Ando_Html_Node $node
     *
     * @return boolean
     */
    protected function html_has_valid_content($node)
    {
        $children = $node->children();
        $result = count($children) == 2 && $children[0]->name() == 'head' && $children[1]->name() == 'body';
        return $result;
    }

}
