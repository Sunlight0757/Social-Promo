<?php

function extractImage($url, $site)
{
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)\r\n",
        ],
    ];

    $context = stream_context_create($options);
    $html = file_get_contents($url, false, $context);
    
    if ($html === false) {
        throw new Exception('Failed to fetch HTML content from the URL.');
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // Disable HTML errors output
    $dom->loadHTML($html);
    libxml_use_internal_errors(false); // Enable HTML errors output

    $xpath = new DOMXPath($dom);

    if($site == 'instagram'){
        $expression = "//img[contains(@class, 'EmbeddedMediaImage')]/@src";
    }elseif($site == 'pinterest'){
        $expression = "//img[1]/@src";
    }
    $srcNodes = $xpath->query($expression);

    $imageSrc = '';
    foreach ($srcNodes as $key => $srcNode) {
        if($key == 0){
            $imageSrc = $srcNode->nodeValue;
        }
    }

    return $imageSrc;
}

function downloadImage($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");

    $rawData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return [
        'rawData' => $rawData,
        'httpCode' => $httpCode,
    ];
}

function saveImageToFile($rawData, $saveAs)
{
    $fp = fopen($saveAs, 'x');
    if ($fp === false) {
        throw new Exception('Failed to open file for writing.');
    }

    if (fwrite($fp, $rawData) === false) {
        fclose($fp);
        throw new Exception('Failed to write data to the file.');
    }

    fclose($fp);
}

function processImage($imageURL, $site)
{
    if (empty($imageURL)) {
        return 'Error: No image URL provided.';
    }

    $url = 'src/img/instagram/' . uniqid() . '.jpg';

    try {
        $imageSrc = extractImage($imageURL, $site);
        if (empty($imageSrc)) {
            throw new Exception('No image found in the provided URL.');
        }

        $result = downloadImage($imageSrc);
        $rawData = $result['rawData'];
        $httpCode = $result['httpCode'];

        if ($httpCode !== 200) {
            throw new Exception('HTTP request failed with status code ' . $httpCode);
        }

        saveImageToFile($rawData, '../' . $url);

        return domain . $url;
    } catch(Exception $e) {
        $errorMessage = 'Error: ' . $e->getMessage();
        return [$errorMessage];
    }
}
