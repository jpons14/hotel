<?php

class TableWidget extends FatherWidget
{
    public function __construct($vars)
    {
        parent::__construct($vars);
    }

    public function viewable(&$return, $value)
    {
        if ($this->vars['viewable']) {
            $return .= '<td><a  href="' . FORM_ACTION . $this->vars['viewURI'] . ($value[$this->vars['viewNum']] ?? 0) . '" ><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
        }
    }

    public function editable(&$return, $value)
    {
        if ($this->vars['editable']) {
            // delete icon
            $return .= '<td><a  href="' . FORM_ACTION . $this->vars['editURI'] . ($value[$this->vars['editNum']] ?? 0) . '" ><i class="fa fa-pencil" aria-hidden="true"></i></a></td>';

        }
    }

    public function deletable(&$return, $value)
    {
        if ($this->vars['deletable']) {
            // edit icon
            $return .= '<td><a class="delete" href="' . FORM_ACTION . $this->vars['deleteURI'] . ($value[$this->vars['deleteNum']] ?? 0) . '"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $return = '<div class="container"><table class="table table-hover"><thead><tr>';
        foreach ($this->vars['fields'] as $field) {
            $return .= "<th>$field</th>";
        }
        $return .= '</tr></thead><tbody>';

        foreach ($this->vars['values'] as $index => $value) {
            $return .= '<tr>';
            # TODO: I have to check the instance of the class
            if (is_object($value)) {
                $value = $value->toArray();
            }
            foreach ($value as $item) {
                $return .= "<td>$item</td>";
            }
            $this->viewable($return, $value);
            $this->editable($return, $value);
            $this->deletable($return, $value);
            $return .= '</tr>';
        }


        $return .= '</tbody></table></div>';
        return $return;
    }
}