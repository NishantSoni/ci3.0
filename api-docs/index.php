<?php
$hostname = gethostname();
$basePath = 'http://localhost/~karvin/ci3.0/api-docs';

$data = '{
    "apiVersion": "1.0",
    "swaggerVersion": "1.0",
    "basePath": "'.$basePath.'",
    "apis": [
        {
            "path": "/apis",
            "description": "List of all Order management APIs..!!"
        }
    ]
}';





echo $data;


?>
