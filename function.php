<?php
if (!function_exists('array_column')) {
    function array_column($array, $column_name) {
        $result = array();
        foreach ($array as $row) {
            if (isset($row[$column_name])) {
                $result[] = $row[$column_name];
            }
        }
        return $result;
    }
}

if (!function_exists('array_keys')) {
    function array_keys($input) {
        if (!is_array($input)) {
            return false;
        }
        $result = array();
        foreach ($input as $key => $value) {
            $result[] = $key;
        }
        return $result;
    }
}