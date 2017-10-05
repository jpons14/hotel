<?php

use Httpful\Request;

class Functions {
    /**
     * Pass a Request result from httpful and the get the
     * image from the web service and store it in this app
     * @param $response
     */
    public static function storeImageFromUrl( $response ) {
        $tmp = $response->body->volumeInfo->imageLinks->thumbnail;

        $imgRoot = SYSTEM_ROOT . "/public/assets/img/{$response->body->id}.jpg";
        $t = Request::getQuick( $tmp );
        $fp = fopen( $imgRoot, "wb" );
        fwrite( $fp, $t->body );
        fclose( $fp );
    }


}