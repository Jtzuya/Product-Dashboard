<?php

// Helper helpful docs: t.ly/gCxf (shortened link)
if(!function_exists('dump')) {
    function dump($param) {
        echo '<pre>';
        var_dump($param);
        echo '</pre>';
    }
}