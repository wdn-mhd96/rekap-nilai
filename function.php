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


function get_json($sheetsLink)
{
    $scriptId = 'AKfycbzDSIAjtnU8nUngQK0Nd5DSEJ47woJk2ccJpz2Yh2MET74j_HDcQ4zHut1P5aLNM7UF7A';
    
    $expSheets = explode('/', $sheetsLink);
    $sheetsId = $expSheets[5];
    $endPointUrl = "https://script.google.com/macros/s/".$scriptId."/exec?id=".$sheetsId;
    try {
        $response = @file_get_contents($endPointUrl);

        if ($response === false) {
            throw new Exception('Link tidak sesuai');
        }

        $data = json_decode($response, true);
        $prodi = array_unique(array_column($data, 'Prodi'));
        $tingkat = array_unique(array_column($data, 'Tingkat'));
        if ($data === null) {
            throw new Exception('Tidak Ada Data');
        }
        return array(
            'data' => $data,
            'prodi'  => $prodi,
            'tingkat' => $tingkat,
            'sheets' => $sheetsLink,
            'sheetsId' => $sheetsId,
            'exc' =>null
        );
    } catch (Exception $e) {
        $exc =  "<div class='alert alert-danger'>" .$e->getMessage()."</div>";
        return array(
            'data' => null,
            'prodi'  => null,
            'tingkat' => null,
            'sheets' => null,
            'exc' =>$exc
        );
    }
}