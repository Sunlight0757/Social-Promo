<?php
$groups = [];
$data = file_get_contents('db/templates.json');

$data = json_decode($data, true);


foreach ($data as $key => $value) {
    // array_push($groups,$value['group']);
    if (!in_array($value['group'], $groups) and $value['group'] != '') {
        array_push($groups, $value['group']);
    }
}

echo json_encode($groups);
