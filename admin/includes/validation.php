<?php

function validate($val)
{
        $val = trim($val);
        $val = strip_tags($val);
        $val = stripcslashes($val);
        $val = str_replace("'", "\'", $val);

        return $val;
}
