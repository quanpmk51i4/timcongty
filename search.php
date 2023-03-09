<?php

if (isset($_POST['company_name'])) {
    $company_name = $_POST['company_name'];
    $prompt = "Tell me about $company_name";
    $url = 'https://api.openai.com/v1/engines/davinci-codex/completions';
    $data = array(
        'prompt' => $prompt,
        'max_tokens' => 100,
        'n' => 1,
        'stop' => '.'
    );
    $payload = json_encode($data);
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $_ENV['OPENAI_API_KEY']
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => $headers
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response, true);
        $text = $data['choices'][0]['text'];
        echo $text;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Search</title>
</head>
<body>
    <form method="POST">
        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" id="company_name">
        <button type="submit">Search</button>
    </form>
</body>
</html>
