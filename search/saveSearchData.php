<?php

require '../config.php';
require '../processImage.php';

function getRSSFeed($search_url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $search_url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function convertRSSFeedInArray($rssFeed)
{
    // Load the XML content
    $rss = @simplexml_load_string($rssFeed);
    $data = [];

    if ($rss !== false) {
        if (isset($rss->channel->item)) {
            foreach ($rss->channel->item as $item) {
                $title = (string) $item->title;
                $link = (string) $item->link;
                $description = (string) $item->description;
                
                if(isset($item->image)) {
                    $imageUrl = (string) $item->image->url;
                } else {
                    $dom = new DOMDocument();
                    $dom->loadHTML(str_replace('&', '&amp;', $description));
                    
                    // Find the img tag and retrieve the src attribute
                    $image = $dom->getElementsByTagName('img')->item(0);
                    if ($image) {
                        $imageUrl = $image->getAttribute('src');
                    } else {
                        $imageUrl = 'src/img/default.jpg';
                    }
                    $imageUrl = processImage($imageUrl, 'instagram');
                }

                // Add the data to the array
                $data[] = [
                    'title' => $title,
                    'link' => $link,
                    'imageUrl' => $imageUrl,
                    'description' => $description
                ];
            }
        }
    }

    $data = (!empty($data)) ? array_values($data) : $data;
    return $data;
}

function getDeletedSearchLinks()
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_deleted.json';
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $data = $jsonData ? json_decode($jsonData, true) : [];
    } else {
        $data = [];
    }
    return $data;
}

function filterRSSFeedData($rssFeedInArray, $deletedSearchLinks, $currentSearchData)
{
    // For Current Links
    $currentSearchDataLinks = array_column($currentSearchData, 'link');
    foreach ($rssFeedInArray as $index => $rssFeed) {
        if (in_array($rssFeed['link'], $currentSearchDataLinks)) {
            unset($rssFeedInArray[$index]);
        }
    }

    // For Deleted Links
    foreach ($rssFeedInArray as $index => $rssFeed) {
        if (in_array($rssFeed['link'], $deletedSearchLinks)) {
            unset($rssFeedInArray[$index]);
        }
    }

    return $rssFeedInArray;
}

function generateUniqueID()
{
    $microtime = microtime(true);
    $timestamp = str_replace('.', '', $microtime);
    $uniqueID = $timestamp . mt_rand();
    return $uniqueID;
}

function appendDataInRSSFeed($data, $searchParams)
{
    $keyword = $searchParams['keyword'] ?? '';
    $type = $searchParams['type'] ?? '';
    $network = $searchParams['network'] ?? '';

    foreach ($data as &$item) {
        $item['id'] = generateUniqueID();
        $item['keyword'] = $keyword;
        $item['type'] = $type;
        $item['network'] = $network;
        $item['date'] = date('d/m/Y / H:i');
        $item['status'] = 'Pending';
        $item['notes'] = '';
    }

    return $data;
}

function saveSearchDataInFile($data)
{
    // Specify the file path to save the JSON data
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_data.json';

    // Check if the file already exists
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        $existingData = $jsonData ? json_decode($jsonData, true) : [];
        if (!empty($existingData)) {
            $data = array_merge($existingData, $data);
        }
    }

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    file_put_contents($filePath, $jsonData);
    return $data;
}

function saveSearchData()
{
    try {
        $searchParams = getSearchParams();

        if (count($searchParams)) {
            $completeData = [];
            $currentSearchData = getSearchData();
            $deletedSearchLinks = getDeletedSearchLinks();
            foreach ($searchParams as $searchParam) {
                $rssFeed = getRSSFeed($searchParam['search_url']);
                $rssFeedInArray = convertRSSFeedInArray($rssFeed);
                if (!empty($rssFeedInArray)) {
                    $filteredRSSFeedData = filterRSSFeedData($rssFeedInArray, $deletedSearchLinks, $currentSearchData);
                    if (!empty($filteredRSSFeedData)) {
                        $data = appendDataInRSSFeed($filteredRSSFeedData, $searchParam);
                        $completeData = array_merge($completeData, $data);
                    }
                }
            }

            $response = array(
                'message' => 'Success'
            );

            if (!empty($completeData)) {
                $latestSearchData = saveSearchDataInFile($completeData);
                $response['searchData'] = $latestSearchData;
            }

            http_response_code(200);
            echo json_encode($response);
        }
    } catch (\Throwable $th) {
        $response = array(
            'message' => 'Error'
        );

        http_response_code(500);
        echo json_encode($response);
    }
}

function saveManualSearchData()
{
    try {
        $searchParams = getSearchParams();

        if (count($searchParams)) {
            $completeData = [];

            $currentSearchData = getSearchData();
            $deletedSearchLinks = getDeletedSearchLinks();

            $searchParam = end($searchParams);
            
            $rssFeed = getRSSFeed($searchParam['search_url']);
            $rssFeedInArray = convertRSSFeedInArray($rssFeed);
            if (!empty($rssFeedInArray)) {
                $filteredRSSFeedData = filterRSSFeedData($rssFeedInArray, $deletedSearchLinks, $currentSearchData);
                if (!empty($filteredRSSFeedData)) {
                    $data = appendDataInRSSFeed($filteredRSSFeedData, $searchParam);
                    $completeData = array_merge($completeData, $data);
                }
            }

            $response = array(
                'message' => 'Success'
            );

            if (!empty($completeData)) {
                $latestSearchData = saveSearchDataInFile($completeData);
                $response['searchData'] = $latestSearchData;
            }

            http_response_code(200);
            echo json_encode($response);
        }
    } catch (\Throwable $th) {
        $response = array(
            'message' => 'Error'
        );

        http_response_code(500);
        echo json_encode($response);
    }
}

function saveCategoryInFile($data)
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'search_categories.json';

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

// Handle the request based on the request method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = isset( $_POST["method"] ) ? $_POST["method"] :"";
    if($method==='new'){
        saveCategory();
    } else {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        if ($action == 'manual') {
            saveManualSearchData();
        } else {
            saveSearchData();
        }
    }
}
