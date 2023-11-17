<?php

require './config.php';

function saveCategoryInFile($data)
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'categories.json';

    // Check if the file already exists
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $existingData = $jsonData ? json_decode($jsonData, true) : [];
        array_push($existingData, $data);
    }

    $jsonData = json_encode($existingData, JSON_PRETTY_PRINT);

    file_put_contents($filePath, $jsonData);
    return $existingData;
}

function saveCategory()
{
    $category = htmlspecialchars($_POST["search_category"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    $result = saveCategoryInFile($category);

    http_response_code(200);
    $response = array(
        'message' => 'Success',
        'category' => $result
    );
    echo json_encode($response);
}

function deleteCategoryInFile($data)
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'categories.json';

    // Check if the file already exists
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $existingData = $jsonData ? json_decode($jsonData, true) : [];
        array_splice($existingData, array_search($data, $existingData),1);
    }

    $jsonData = json_encode($existingData, JSON_PRETTY_PRINT);

    file_put_contents($filePath, $jsonData);
    return $existingData;
}

function deleteCategory()
{
    $id = htmlspecialchars($_POST["search_category_select"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    $result = deleteCategoryInFile($id);

    http_response_code(200);
    $response = array(
        'message' => 'Success',
        'category' => $result
    );
    echo json_encode($response);
}

// Handle the request based on the request method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['method']==='POST'){
    saveCategory();
  } else {
    deleteCategory();
  }
}
