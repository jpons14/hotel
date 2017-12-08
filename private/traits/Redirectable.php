<?php
trait Redirectable{
    public function redirect($route)
    {
        header('Location: ' . FORM_ACTION . '' . $route);
    }
}