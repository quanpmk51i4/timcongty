<?php

// Lấy tên công ty từ biến GET
$company_name = $_GET['company_name'];

// API key của bạn
$api_key = getenv("OPENAI_API_KEY");

// Thực hiện yêu cầu API để tìm kiếm thông tin công ty
$url = "https://api.openai.com/v1/engines/davinci-codex/search";
$data = array(
    "documents" => array("List of companies and their descriptions"),
    "query" => $company_name,
    "max_tokens" => 50,
    "temperature" => 0.5,
    "stop" => "."
);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\nAuthorization: Bearer ".$api_key,
        'method'  => 'POST',
        'content' => json_encode($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Hiển thị kết quả trên trang
echo "<h1>Kết quả tìm kiếm cho '$company_name':</h1>";
echo "<p>" . $result . "</p>";

?>
