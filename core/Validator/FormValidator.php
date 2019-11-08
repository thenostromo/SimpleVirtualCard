<?php
namespace Validator;

class FormValidator
{
    /**
     * @param string $data
     * @return string
     */
    public static function prepareData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}