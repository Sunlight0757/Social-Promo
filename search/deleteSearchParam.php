<?php

function deleteSearchParam($searchId)
{
    try {
        if($searchId == '') throw new Exception("Id is missing", 400);
        
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_params.json';
        $data = [];
        
        if (file_exists($filePath)) {
            $jsonData = file_get_contents($filePath);
            $data = $jsonData ? json_decode($jsonData, true) : [];
        }

        foreach ($data as $index => $item) {
            if ($item['id'] == $searchId) {
                unset($data[$index]);
                break; 
            }
        }

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($filePath, $jsonData);

        $response = array(
            'message' => 'Success'
        );
        http_response_code(200);
        echo json_encode($response);
    } catch (\Throwable $th) {
        $error = [$th->getMessage()];
        $response = array(
            'message' => 'Error',
            'error' => $error
        );

        http_response_code(400);
        echo json_encode($response);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchId = $_POST['searchId'] ?? '';
    deleteSearchParam($searchId);
}
