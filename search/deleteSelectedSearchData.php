<?php

function validateIds($ids)
{
    $error = '';

    if (empty($ids)) {
        $error = "Please select any row";
    }

    return $error;
}

function deleteIds($ids)
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_data.json';
    $data = [];
    $deletedLinks = [];
    
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $data = $jsonData ? json_decode($jsonData, true) : [];
    }

    foreach ($data as $index => $item) {
        if (in_array($item['id'], $ids)) {
            unset($data[$index]);
            if(strpos($item['imageUrl'], '/src/img/instagram')!==false){
                unlink('..' . strstr($item['imageUrl'], '/src/img/instagram'));
            }
            $deletedLinks[] = $item['link'];
        }
    }

    $data = array_values($data);

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $jsonData);

    return [
        'updatedData' => $data,
        'deletedLinks' => $deletedLinks
    ];
}

function saveDeletedLinksInFile($deletedLinks)
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_deleted.json';

    // Check if the file already exists
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $existingLinks = $jsonData ? json_decode($jsonData, true) : [];
        $existingLinks = array_merge($existingLinks, $deletedLinks);
        $jsonData = json_encode($existingLinks, JSON_PRETTY_PRINT);
    } else {
        $jsonData = json_encode($deletedLinks, JSON_PRETTY_PRINT);
    }

    file_put_contents($filePath, $jsonData);
    return true;
}

function deleteSelectedSearchData($ids){

    try {
        $validationError =  validateIds($ids);

        // Check if there are any validation errors
        if (!empty($validationError)) {
            $response = array(
                'message' => 'Error',
                'error' => $validationError
            );

            http_response_code(400);
            echo json_encode($response);
        } else {
            $results = deleteIds($ids);
            $updatedData = $results['updatedData'];
            $deletedLinks = $results['deletedLinks'];
            saveDeletedLinksInFile($deletedLinks);

            $response = array(
                'message' => 'Success',
                'searchData' => $updatedData
            );
            http_response_code(200);
            echo json_encode($response);
        }
    } catch (\Throwable $th) {
        $response = array(
            'message' => 'Error',
        );

        http_response_code(500);
        echo json_encode($response);
    }
}

// Handle the request based on the request method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ids = json_decode($_POST['ids'], true);
    deleteSelectedSearchData($ids);
}