<?php

$json = file_get_contents(datafile);
$data_json = json_decode($json);



if (count($data_json) > 0) {
    $delimiter = ",";
    $filename = "csv_" . rand(1, 10) . rand(5856, 9898) . ".csv";

    // Create a file pointer 
    $f = fopen('php://memory', 'w');

    // Set column headers 
    $fields = array('first_name', 'last_name', 'phone_number', 'email');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as csv and write to file pointer 
    foreach ($data_json as $res) {
        $tab = array();
        $fullname = explode(' ', $res->fullName);
        array_push($tab, $fullname[0]);
        array_push($tab, $fullname[1]);
        array_push($tab, $res->number);
        array_push($tab, $res->email);



        $lineData = $tab;
        fputcsv($f, $lineData, $delimiter);
    }

    // Move back to beginning of file 
    fseek($f, 0);

    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    //output all remaining data on a file pointer 
    fpassthru($f);
}
exit;
