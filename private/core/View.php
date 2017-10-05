<?php


foreach( glob( 'private/widgets/*.php' ) as $item ) {
    require_once $item;
}


class View {

    private $templates;

    private $vars;

    private $dictionary;

    public function __construct( $templates, $dictionary = [], $vars = [] ) {
        $this->templates = $templates;
        $this->vars = $vars;
        $this->dictionary = $dictionary;

        $this->render();
    }


    private function render() {
        $all = '';
        extract( $this->vars );
        if( is_array( $this->templates ) ) {
            foreach( $this->templates as $template ) {
                $all .= file_get_contents( "private/templates/" . $template . ".php" );
                $all = str_replace( '[[ formAction ]]', FORM_ACTION, $all );

            }
            $this->renderDictionary( $all );
        }
        // widgets
        foreach( $this->vars as $index => $var ) {

            if( !is_array( $var ) ) {
                $all = str_replace( "{ $index }", $$index, $all );
                //                echo $all;
            } else {
                $keys = array_keys( $var );
                $keys = $keys[ 0 ];
                $all .= new $index( $var );
                //                echo $all;
            }
        }

        echo $all;
    }

    private function renderDictionary( &$all ) {
        foreach( $this->dictionary as $index => $item ) {
            $all = str_replace( "[[ $index ]]", $item, $all );
        }
    }

}