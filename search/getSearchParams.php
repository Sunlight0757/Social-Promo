<?php

function getSearchParams()
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_params.json';
    $data = [];

    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $data = $jsonData ? json_decode($jsonData, true) : [];
    }

    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    getSearchParams();
}