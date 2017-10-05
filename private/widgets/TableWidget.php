<?php

class TableWidget extends FatherWidget
{
    public function __construct( $vars )
    {
        parent::__construct( $vars );
    }

    public function editable( &$return, $value  ) {
        if($this->vars['editable']) {
            // delete icon
            $return .= '<td><a href="' . FORM_ACTION . $this->vars['editURI'] . $value[ $this->vars['editNum'] ] . '" ><i class="fa fa-pencil" aria-hidden="true"></i></a></td>';

        }
    }

    public function deletable( &$return, $value ) {
        if($this->vars['deletable']) {
            // edit icon
            $return .= '<td><a href="' . FORM_ACTION . $this->vars['deleteURI'] . $value[ 2 ] . '"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
        }
    }

    /**
     * @return string
     */
    public function __toString() {
        $return = '<div class="container"><table class="table table-hover"><thead><tr>';
        foreach ( $this->vars['fields'] as $field ) {
            $return .= "<th>$field</th>";
        }
        $return .= '</tr></thead><tbody>';

        foreach ( $this->vars['values'] as $index => $value ) {
            $return .= '<tr>';
            foreach ( $value as $item ) {
                $return .= "<td>$item</td>";
            }
            $this->editable($return, $value);
            $this->deletable($return, $value);
            $return .= '</tr>';
        }


        $return .= '</tbody></table></div>';
        return $return;
    }
}