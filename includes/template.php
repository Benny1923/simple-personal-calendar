<?php

//自幹簡單樣板系統
//其實就是尋找取代而已

class Content {
    var $template;
    function __construct($file) {
        $this->template = file_get_contents(__DIR__.'/../template/'.$file);
    }

    function put($target, $content) {
        $this->template = str_replace("{{".$target."}}", $content, $this->template);
    }

    function get() {
        return $this->template;
    }
}

?>