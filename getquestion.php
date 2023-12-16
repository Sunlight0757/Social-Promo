<?php
require 'config.php';
$data = file_get_contents(adminQuestionsFile);
echo $data;
