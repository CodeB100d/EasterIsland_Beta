<?php

class EI_Controller extends Controller {

    //get uri segments
    function getUriSegments() {
        return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    //get uri segment
    function getUriSegment($n) {
        $segs = $this->getUriSegments();
        return (count($segs) > 0 && count($segs) >= ($n - 1) && (count($segs)-1)>=$n ) ? $segs[$n] : '';
    }

}