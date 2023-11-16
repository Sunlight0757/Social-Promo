<?php

function saveDeletedLinkInFile($link)
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_deleted.json';

    // Check if the file already exists
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $existingLinks = $jsonData ? json_decode($jsonData, true) : [];
        if (!empty($existingLinks)) {
            $existingLinks = array_merge($existingLinks, [$link]);
        } else {
            $existingLinks = [$link];
        }
        $jsonData = json_encode($existingLinks, JSON_PRETTY_PRINT);
    } else {
        $jsonData = json_encode([$link], JSON_PRETTY_PRINT);
    }

    file_put_contents($filePath, $jsonData);
    return true;
}

function deleteSearchData($link)
{
    if ($link == '') throw new Exception("Link is missing", 400);

    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_data.json';
    $data = [];
    
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $data = $jsonData ? json_decode($jsonData, true) : [];
    }

    foreach ($data as $index => $item) {
        if ($item['link'] == $link) {
            unset($data[$index]);
            break;
        }
    }

    $data = array_values($data);

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $jsonData);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = $_POST['link'] ?? '';

    try {
        $latestSearchData = deleteSearchData($link);
        saveDeletedLinkInFile($link);

        $response = array(
            'message' => 'Success'
        );
    
        if(!empty($latestSearchData)){
            $response['searchData'] = $latestSearchData;
        }

        http_response_code(200);
        echo json_encode($response);
    } catch (\Throwable $th) {
        $code = $th->getCode();
        $response = array(
            'message' => 'Error'
        );

        if($code == 400){
            $response['error'] = $th->getMessage();
        }

        http_response_code($code);
        echo json_encode($response);
    }
}
