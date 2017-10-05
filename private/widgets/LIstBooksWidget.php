<?php

class LIstBooksWidget extends FatherWidget {
    public function __construct( $vars ) {
        parent::__construct( $vars );
    }

    public function __toString() {
        $var = '';
        foreach( $this->vars[ 'books' ] as $book ) {
            $var .= <<<CODE
<div class="container">
<div class="jumbotron">
  <h1 class="display-2">$book[1]</h1>
  <p class="lead">$book[2]</p>
  <hr class="my-4">
   <p class="lead">
   <img src="$GLOBALS[formAction]/public/assets/img/$book[0].jpg" alt="$book[1]" /><hr/>
    <a class="btn btn-primary btn-lg" href="$GLOBALS[formAction]/books/details?id=$book[0]" role="button">See more!</a>
  </p>
</div>
</div>
CODE;
        }

        return $var;
    }
}