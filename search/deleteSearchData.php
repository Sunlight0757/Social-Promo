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

function deleteSearchDataByCategory($category)
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_data.json';
    $data = [];
    
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $data = $jsonData ? json_decode($jsonData, true) : [];
    }

    foreach ($data as $index => $item) {
        if ($item['category'] == $category) {
            unset($data[$index]);
        }
    }

    $data = array_values($data);

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $jsonData);
    return $data;
}

function deleteCategoryInFile($data)
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_categories.json';

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
    
    $result1 = deleteCategoryInFile($id);
    $result2 = deleteSearchDataByCategory($id);

    http_response_code(200);
    $response = array(
        'message' => 'Success',
        'category' => $result1,
        'data' => $result2
    );
    echo json_encode($response);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST['method']==='delete'){
        deleteCategory();
    } else {
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
}
