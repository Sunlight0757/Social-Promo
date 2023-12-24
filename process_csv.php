<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csvFile"])) {
  $jsonFile = "db/data.json";
  $csvFile = $_FILES["csvFile"]["tmp_name"];
  $uploadOk = true;
  $errorMessage = "";

  // Check if a file has been imported
  if ($_FILES["csvFile"]["size"] == 0) {
    $uploadOk = false;
    $errorMessage = "file not found.";
  }

  // Check the file extension
  $csvFileType = strtolower(pathinfo($_FILES["csvFile"]["name"], PATHINFO_EXTENSION));
  if ($csvFileType != "csv") {
    $uploadOk = false;
    $errorMessage = "The file is not a csv file.";
  }

  if ($uploadOk) {
    if (($handle = fopen($csvFile, "r")) !== false) {
      $json = file_get_contents($jsonFile);
      $jsonData = json_decode($json, true);

      fgetcsv($handle, 1000, ",");

      while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        // Processing CSV data and updating JSON
        $name = $data[0];
        $website = $data[1];
        $phone = $data[2];
        $email = $data[3];
        $location = $data[4];
        $status = $data[5];
        $group = $data[6];

        // Check if an entry with the same website, phone or email already exists in the JSON
        $existingEntry = false;
        foreach ($jsonData as &$entry) {


        //   if ($entry["website"] == '' || $entry["number"] == '' || $entry["email"] == '') {
        //     break;
        //   }
        //  else if ($entry["website"] == $website || $entry["number"] == $phone || $entry["email"] == $email) {
        //     // Update existing entry
        //     $entry["fullName"] = $name;
        //     $entry["location"] = $location;
        //     $entry["status"] = $status;
        //     $entry["groups"] = $group;
        //     $existingEntry = true;
        //     break;
        //   }

          $websiteMatch = ($website !== '' && $entry["website"] !== '' && $entry["website"] == $website);
          $numberMatch = ($phone !== '' && $entry["number"] !== '' && $entry["number"] == $phone);
          $emailMatch = ($email !== '' && $entry["email"] !== '' && $entry["email"] == $email);
     
          if ($websiteMatch || $numberMatch || $emailMatch) {
              $entry["fullName"] = $name;
              $entry["location"] = $location;
              $entry["status"] = $status;
              $entry["groups"] = explode(";", $group);
              $existingEntry = true;
              break;
          }
     
      
      
        }
        $dateActu = date("d/m/Y");
        $hoursActu = date("H:i");

        $dateandhours = $dateActu . " /" . $hoursActu;

        // If the entry does not exist, create a new record
        if (!$existingEntry) {
          $newRecord = array(
            "id" => uniqid(),
            "fullName" => $name,
            "website" => $website,
            "number" => $phone,
            "email" => $email,
            "location" => $location,
            "groups" => explode(";", $group),
            "verified" => "",
            "date" => $dateandhours,
            "birthday" => 'false',
            "unsubscribed" => "",
            "status" => $status,
            "device" => "",
            "question" => [
              array(
                "question" => "",
                "answers" => [],
                "comment" => "",
              ),
            ],
            "notes" =>  "",
          );

          $jsonData[] = $newRecord;
        }
      }

      fclose($handle);

      // Save updated JSON data
      $updatedJson = json_encode($jsonData, JSON_PRETTY_PRINT);
//echo $updatedJson;
      file_put_contents($jsonFile, $updatedJson);

      $message = "The CSV file was successfully imported!";
    } else {
      $message = "An error occurred while processing the CSV file.";
    }
  } else {
    $message = $errorMessage;
  }

  echo $message;
} else {
  # code...
  echo 'File not uploaded';
}
