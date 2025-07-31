<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set your API credentials
    $phone_number_id = 'YOUR_PHONE_NUMBER_ID';     // e.g., 123456789012345
    $token = 'YOUR_TEMPORARY_TOKEN';               // e.g., EAAG....
    $receiver_number = 'YOUR_VERIFIED_NUMBER';     // e.g., 91XXXXXXXXXX

    // Get form data
    $name = $_POST['customerName'] ?? '';
    $mobile = $_POST['customerMobile'] ?? '';
    $loanType = $_POST['loanType'] ?? '';

    $message = "📩 New Loan Enquiry:\n\n👤 Name: $name\n📞 Mobile: $mobile\n💼 Loan Type: $loanType";

    $url = "https://graph.facebook.com/v19.0/$phone_number_id/messages";
    $payload = [
        "messaging_product" => "whatsapp",
        "to" => $receiver_number,
        "type" => "text",
        "text" => [ "body" => $message ]
    ];

    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch);
    } else {
        echo "Message sent successfully!";
    }

    curl_close($ch);
} else {
    http_response_code(403);
    echo "Access Denied";
}
