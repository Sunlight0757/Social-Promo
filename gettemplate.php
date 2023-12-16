<?php
require 'config.php';
$data = file_get_contents(adminTemplatesFile);
echo $data;
