<?php

class Ando_Html_Lexer
{

    /**
     * HTML to parse.
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
     * Get the tokens.
     *
     * @return Ando_Html_Token[]
     */
    public function tokens()
    {
        return $this->tokens;
    }

    /**
     * Classify and store matched stuff as a token.
     *
     * @throws Ando_Exception
     * @param array $matches
     */
    public function tokens_add($matches)
    {
        $all = 0;
        $source = 0;
        $offset = 1;
        switch (true) {
            case $matches['comment'][$offset] > -1:
                $type = Ando_Html_Token::TYPE_COMMENT;
                break;
            case $matches['doctype'][$offset] > -1:
                $type = Ando_Html_Token::TYPE_DOCTYPE;
                break;
            case $matches['void'][$offset] > -1:
                $type = Ando_Html_Token::TYPE_VOID;
                break;
            case $matches['script'][$offset] > -1:
                $type = Ando_Html_Token::TYPE_SCRIPT;
                break;
            case $matches['start'][$offset] > -1:
                $type = Ando_Html_Token::TYPE_START;
                break;
            case $matches['end'][$offset] > -1:
                $type = Ando_Html_Token::TYPE_END;
                break;
            case $matches['iews'][$offset] > -1:
                $type = Ando_Html_Token::TYPE_IEWS;
                break;
            case $matches['text'][$offset] > -1:
                $type = Ando_Html_Token::TYPE_TEXT;
                break;
            default:
                throw new Ando_Exception('Invalid parser regex match.');
        }


        $index = count($this->tokens);
        $data = array(
            'index' => $index,
            'source' => $matches[$all][$source],
            'offset' => $matches[$all][$offset],
            'length' => strlen($matches[$all][$source]),
            'type' => $type
        );
        if (isset($matches['tag'])) {
            $data['tag'] = $matches['tag'][$source];
            if ($type == Ando_Html_Token::TYPE_START && Ando_Html_Spec::is_void_but_looks_like_a_start($data['tag'])) {
                $data['type'] = Ando_Html_Token::TYPE_VOID;
            }
        }
        $this->tokens[$index] = new Ando_Html_Token($data);
    }

    /**
     * Split html into bits of text and tags.
     */
    protected function find_tokens()
    {
        $regex = Ando_Regex::create('(?J)(?<comment>$comment)|(?<doctype>$doctype)|(?<void>$void)' . '|(?<script>$script)|(?<start>$start)|(?<end>$end)|(?<iews>$iews)|(?<text>$text)', '@@is')->interpolate(
            array(

                // the browser does the same: a comment goes from a start up to the next end
                'comment' => '<!--.*?-->',

                // capture doctype on its own because it's different..
                'doctype' => '<!doctype(?:(?!>).)*>',

                // capture explicitly void elements
                'void' => '<(?<tag>\w+)(?:(?!/>).)*/>',

                // the browser does the same: a script goes from a start up to the next end
                'script' => '<script(?:(?!>).)*>.*?</script\s*>',

                // capture both start tags of non-void elements and void elements like <br>
                'start' => '<(?<tag>\w+)(?:(?!>).)*>',

                // capture end tags
                'end' => '</(?<tag>\w+)\s*>',

                // capture inter element white space
                // note that this white space is surely "inter element" due to how we match (tag / non-tag)
                'iews' => '\s+',

                // capture anything else as text
                'text' => '(?:(?!<!--|<!doctype\b|<\w|</\w).)+'
            )
        );
        // use Ando_Regex::replace to scan $this->html
        Ando_Regex::replace($regex, array(
            $this,
            'tokens_add'
        ), $this->html);
    }

    /**
     * Constructor.
     *
     * @param string $html
     */
    protected function __construct($html)
    {
        $this->html = $html;
        $this->tokens = array();
    }

    /**
     * Get the tokens of the html.
     *
     * @param string $html
     * @return Ando_Html_Lexer
     */
    static public function parse($html)
    {
        $lexer = new self($html);
        $lexer->find_tokens();
        return $lexer;
    }

}
