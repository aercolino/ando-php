<?php
/**
 * Basic HTML Tokenizer
 *
 * @link http://andowebsit.es/blog/noteslog.com/
 *
 * @package Ando_Html
 */
class Ando_HTml_Tokenizer
{

    /**
     *
     * @var array
     */
    protected $html;

    /**
     *
     * @var array
     */
    protected $tokens;

    /**
     *
     * @return array
     */
    protected function tokens ()
    {
        return $this->tokens;
    }

    /**
     *
     * @param array $matches
     */
    public function tokens_add ($matches)
    {
        switch (true)
        {
            case $matches['comment'][1] > -1:
                $type = Ando_Html_Token::TYPE_COMMENT;
            break;
            case $matches['doctype'][1] > -1:
                $type = Ando_Html_Token::TYPE_DOCTYPE;
            break;
            case $matches['void'][1] > -1:
                $type = Ando_Html_Token::TYPE_VOID;
            break;
            case $matches['script'][1] > -1:
                $type = Ando_Html_Token::TYPE_SCRIPT;
            break;
            case $matches['start'][1] > -1:
                $type = Ando_Html_Token::TYPE_START;
            break;
            case $matches['end'][1] > -1:
                $type = Ando_Html_Token::TYPE_END;
            break;
            case $matches['iews'][1] > -1:
                $type = Ando_Html_Token::TYPE_IEWS;
            break;
            case $matches['text'][1] > -1:
                $type = Ando_Html_Token::TYPE_TEXT;
            break;
            default:
                throw new Ando_Exception('Invalid tokenizer regex match.');
        }


        $index = count($this->tokens);
        $data = array(
            'index' => $index,
            'source' => $matches[0][0],
            'offset' => $matches[0][1],
            'length' => strlen($matches[0][0]),
            'type' => $type
        );
        if ('' != $matches['tag'][0])
        {
            $data['tag'] = $matches['tag'][0];
            if ($type == Ando_Html_Token::TYPE_START && Ando_Html_Spec::is_void_but_looks_like_a_start($data['tag']))
            {
                $data['type'] = Ando_Html_Token::TYPE_VOID;
            }
        }
        $this->tokens[$index] = new Ando_Html_Token($data);
    }

    /**
     * Split HTML into bits of text and tags.
     *
     * @param string $html
     */
    protected function find_tokens ()
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
                    // note that this white space is "inter element" due to how we match (tag / not-tag)
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

    protected function __construct ($html)
    {
        $this->html = $html;
        $this->tokens = array();
    }

    static public function tokenize ($html)
    {
        $tokenizer = new self($html);
        $tokenizer->find_tokens();
        return $tokenizer->tokens();
    }

}

$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<title>Title of the document</title>
</head>

<body>
The content of the document......
<!--
<div class="demo" style="zoom: 1; border: none; position: relative;"><div class="jquery-corner" style="position: relative; margin: -20px -20px 10px;"><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 10px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 10px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 10px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 10px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 9px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 9px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 8px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 7px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 6px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 4px; background-color: transparent;"></div></div><h1>Bite</h1>  <code><p>$(this).corner("bite");</p></code><div class="jquery-corner" style="position: absolute; margin: 0px; padding: 0px; left: 0px; bottom: 0px; width: 100%;"><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 4px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 6px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 7px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 8px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 9px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 9px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 10px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 10px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 10px; background-color: transparent;"></div><div style="overflow: hidden; height: 1px; min-height: 1px; font-size: 1px; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0px 10px; background-color: transparent;"></div></div></div>
-->

<p id="demo"></p>

<script>
var b = "<b>hey</b>";
document.getElementById("demo").innerHTML = "Hello --> JavaScript!";
</script>

</body>

</html>
HTML;

$result = Ando_HTml_Tokenizer::tokenize($html);

print_r($result);
