<?php
require dirname( dirname( dirname( dirname( __FILE__ ) ) ) )
        . DIRECTORY_SEPARATOR . 'Ando'
        . DIRECTORY_SEPARATOR . 'Html'
        . DIRECTORY_SEPARATOR . 'Tokenizer.php';

class Ando_TokenizerTest extends PHPUnit_Framework_TestCase {

    public function minimal_page() {
        $result = <<<HTML
<!DOCTYPE html>
<html>
 <head>
  <title>minimal_page</title>
 </head>
 <body>
 </body>
</html>
HTML;
        return $result;
    }

    public function html_comment_p_script() {
        $result = <<<HTML
<!DOCTYPE html>
<html>
 <head>
  <title>html_comment_p_script</title>
 </head>
 <body>

<!--
  <div class="demo" style="zoom: 1; border: none; position: relative;">nothing here...</div>
-->

  <p id="demo"></p>

  <script>
    var b = "<b>hey</b>";
    document.getElementById("demo").innerHTML = "Hello --> Body!";
  </script>

 </body>
</html>
HTML;
        return $result;
    }

    public function test_minimal_page_has_17_tokens() {
        $html = $this->minimal_page();
        $tokens = Ando_HTml_Tokenizer::tokenize($html);
        $this->assertEquals(17, count($tokens));
    }

}
