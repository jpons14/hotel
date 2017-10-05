<?php

use Httpful\Request;

class Books extends Controller {

    private $urlBookApi;

    public function __construct( $private ) {
        parent::__construct( $private );

        $this->urlBookApi = 'https://www.googleapis.com/books/v1/volumes';
    }

    // Permission = true
    public function index() {
        $user = new User( $this->session->getVar( 'userEmail' ) );
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );
        new View( [ 'searchBooks' ] );
    }

    public function home(  ) {
        $user = new User( $this->session->getVar( 'userEmail' ) );
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );


        $book = new Book();
        $what = $book->getAll();
        $return = [];
        for($i = 0; $i < 4; $i++){
            $return[] = $what[$i];
        }
        new View(['booksHome']);

        return new View( [], [], [ 'ListBooksWidget' => [
            'books' => $return
        ] ] );
    }

    public function search() {
        // if it's there an space won't work
        if( is_numeric( $_GET[ 'search' ] ) ) {
            $uri = "$this->urlBookApi/?q=isbn+$_GET[search]";
        } else {
            $_GET[ 'search' ] = str_replace( ' ', '%20', $_GET[ 'search' ] );
            $uri = "$this->urlBookApi/?q=intitle+$_GET[search]";
        }

        $request = Request::get( $uri )
            ->expects( 'json' )
            ->send();

        new View( [ 'header', 'allBooks' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );
        $result = json_decode( $request->raw_body );
        $return = [];
        $isbns = array();
        foreach( $result->items as $key => $item ) {
            $isbns[] = $item->id;
            $return[] = $item->volumeInfo->title . '  ISBN ' . $item->volumeInfo->industryIdentifiers[ 0 ]->identifier;
        }
        new View( [ 'searchBooks' ], [], [ 'AllBooksWidget' => [
            'books' => $return,
            'ids' => $isbns
        ] ] );
    }

    public function addNew() {

        $book = new Book();
        // if it's there an space won't work
        $_GET[ 'id' ] = str_replace( ' ', '%20', $_GET[ 'id' ] );
        $request = Request::get( "$this->urlBookApi/$_GET[id]" )->expects( 'json' )->send();


        $book->addBook( [ 'id' => $request->body->id, 'title' => $request->body->volumeInfo->title, 'author' => $request->body->volumeInfo->authors[ 0 ], 'description' => $request->body->volumeInfo->description ] );

        Functions::storeImageFromUrl( $request );

        header( "Location: " . FORM_ACTION . "/books/index" );
    }

    public function all() {
        $book = new Book();
        if( !isset( $_GET[ 'search' ] ) ) {
            $what = $book->getAll();
        } elseif( $_GET[ 'search' ] == '' ) {
            header( 'Location: ' . FORM_ACTION . '/books/all' );
        } else {
            if( is_numeric( $_GET[ 'search' ] ) ) {
                ## TODO: Take a look
                $what = $book->searchByISBN( $_GET[ 'search' ] );
            } else {
                $what = $book->searchByName( $_GET[ 'search' ] );
            }
        }

        if( !$this->private )
            $var = 'member';
        else
            $var = $this->session->getVar( 'userType' );

        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $var
        ] ] );

        new View( [], [], [ 'BooksSearchWidget' => [

        ] ] );

        return new View( [], [], [ 'ListBooksWidget' => [
            'books' => $what
        ] ] );
    }

    public function details() {
        $request = Request::get( "$this->urlBookApi/$_GET[id]" )->expects( 'json' )->send();
        $title = $request->body->volumeInfo->title;
        $description = $request->body->volumeInfo->description;
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        $permissions = $this->session->getVar( 'userType' );

        $book = new Book();
        $conservation = $book->getConservationById( $_GET[ 'id' ] );;


        if( $description == '' ) {
            $description = '<i><small>This book dosen\'t has any description</small>  </i>';
        }

        $button = '';

        $bookParamethers = new BookParamether();

        if( $GLOBALS[ 'usersPermission' ][ $permissions ] >= $GLOBALS[ 'usersPermission' ][ 'librarian' ] ) {
            $button = '<a class="btn btn-default" href="' . FORM_ACTION . '/bookings/by?text=' . $_GET[ 'id' ] . '">Bookings Of this Book</a>';
        }

        return new View( [ 'bookDetails' ], [ 'description' => $description,
            'title' => $title,
            'img' => FORM_ACTION . "/public/assets/img/$_GET[id].jpg",
            'id' => $_GET[ 'id' ],
            'conservation' => $conservation,
            'buttonBookings' => $button,
            'old' => $bookParamethers->old,
            'normal' => $bookParamethers->normal,
            'new' => $bookParamethers->new,
        ] );
    }

    public function by() {
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        $book = new Book();


        if( is_numeric( $_GET[ 'search' ] ) ) {
            echo '<pre>$book->searchByIsbn' . print_r( $book->searchByISBN( $_GET[ 'search' ] ), true ) . '</pre>';
        } else {
            echo '<pre>$book->searchByName' . print_r( $book->searchByName( $_GET[ 'search' ] ), true ) . '</pre>';
        }

    }

}