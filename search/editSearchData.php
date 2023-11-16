<?php

require '../config.php';

function validatePostData($postData)
{
    // Define an array to hold validation errors
    $errors = [];

    // Validating Id
    $id = $postData['id'] ?? '';
    $id = htmlspecialchars($id, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    if (empty($id) && $id != 0) {
        $errors[] = "Id is missing.";
    }

    if (isset($postData['status'])) {
        $status = $postData['status'] ?? '';
        if (empty($status)) {
            $errors[] = "Status field is required.";
        }
    } else {
        $image = $postData['search-url-picture'] ?? '';
        $title = $postData['search-url-title'] ?? '';
        $contact = $postData['search-url-contact'] ?? '';
        $description = $postData['search-url-description'] ?? '';
        $notes = $postData['search-url-notes'] ?? '';

        $image = htmlspecialchars($image, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (empty($image)) {
            $errors[] = "Image field is required.";
        } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
            $errors[] = "Invalid URL format for the image.";
        }

        $title = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (empty($title)) {
            $errors[] = " Title field is required.";
        }

        $contact = htmlspecialchars($contact, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (empty($contact)) {
            $errors[] = "Contact field is required.";
        }

        $description = htmlspecialchars($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (empty($description)) {
            $errors[] = "Description field is required.";
        }

        $notes = htmlspecialchars($notes, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (empty($notes)) {
            $errors[] = "Notes field is required.";
        }
    }

    return $errors;
}

function updateSearchData($postData)
{
    $searchData = getSearchData();
    $updatedItem = null;

    foreach ($searchData as &$item) {
        if ($item['id'] == $postData['id']) {
            $item['imageUrl'] = $postData['search-url-picture'];
            $item['title'] = $postData['search-url-title'];
            $item['link'] = $postData['search-url-contact'];
            $item['description'] = $postData['search-url-description'];
            $item['notes'] = $postData['search-url-notes'];
            $updatedItem = $item;
            break;
        }
    }

    // Update the File
    updateSearchDataInFile($searchData);

    return $updatedItem;
}

function updateSearchStatus($postData){
    $searchData = getSearchData();
    $updatedItem = null;
    $statuses = [];

    foreach ($searchData as &$item) {
        if ($item['id'] == $postData['id']) {
            $item['status'] = $postData['status'];
            $updatedItem = $item;
        }
        $statuses[] = $item['status'];
    }

    // Update the File
    updateSearchDataInFile($searchData);

    return [
        "updatedItem" => $updatedItem,
        "statuses" => $statuses
    ];
}

function updateSearchDataInFile($data)
{
    // Specify the file path to save the JSON data
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_data.json';

    // Check if the file already exists
    if (file_exists($filePath)) {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($filePath, $jsonData);
    }

    return true;
}

function editSearchData()
{
    try {
        $validationErrors = validatePostData($_POST);

        // Check if there are any validation errors
        if (!empty($validationErrors)) {
            $response = array(
                'message' => 'Error',
                'errors' => $validationErrors
            );

            http_response_code(400);
            echo json_encode($response);
        } else {
            if(isset($_POST['status'])){
                $results = updateSearchStatus($_POST);
                $updatedItem = $results['updatedItem'];
                $statuses = $results['statuses'];
                $response = array(
                    'message' => 'Success',
                    'updatedItem' => $updatedItem,
                    'statuses' => $statuses
                );
            }else{
                $updatedItem = updateSearchData($_POST);
                $response = array(
                    'message' => 'Success',
                    'updatedItem' => $updatedItem
                );
            }
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
    editSearchData();
}
