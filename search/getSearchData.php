<?php

function getSearchData()
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_data.json';
    $data = [];

    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $data = $jsonData ? json_decode($jsonData, true) : [];
    }
    
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $response = array(
        'data' => getSearchData()
    );
    echo json_encode($response);
}elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cron'])){
    http_response_code(200);
    $response = array(
        'data' => getSearchData()
    );
    
    echo json_encode($response);
}