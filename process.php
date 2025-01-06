<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" href="css/bookstyle.css" />
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #fff;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #1e1e4d;
    }

    .form-details {
        margin: 20px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #f9f9f9;
    }
    .form-details p {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 8px 0;
        font-size: 16px;
        color: #000;
    }

    .message-success {
        text-align: center;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        border-radius: 5px;
        background-color: #28a745;
    }
    .message-error {
        text-align: center;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        border-radius: 5px;
        background-color: #dc3545;
    }
</style>

<body>
    <div class="container">
<?php

$jsonFilePath = 'token.json';

// Check if the JSON file exists
if (file_exists($jsonFilePath)) {
    // Decode the JSON data into arrays
    $data = json_decode(file_get_contents($jsonFilePath), true);

    $tokens = $data[0]['token'] ?? [];
    $usedTokens = $data[0]['usedToken'] ?? [];
} else {
    // If the file does not exist, initialize empty arrays
    $tokens = [];
    $usedTokens = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName =   $_POST['studentName'];
    $studentID =     $_POST['studentID'];
    $studentmail =   $_POST['studentmail'];
    $bookSelected =  $_POST['books'];
    $borrowDate =    $_POST['borrowDate'];
    $returnDate =    $_POST['returnDate'];
    $fees =          $_POST['fees'];
    $token =         $_POST['token'];
    $paidStatus =    $_POST['paid'];

    // Validation for studentName
    if (!preg_match("/^[A-Za-z\- ]+$/", $studentName)) {
        echo "<div class='message-error'>Name is Invalid</div>";
        return;
    }

    // Validation for studentID
    if (!preg_match("/^\d{2}-\d{5}-\d{1}$/", $studentID)) {
        echo "<div class='message-error'>Student ID is Invalid</div>";
        return;
    }

    // Check if token is valid and not used
    if (!in_array($token, $tokens)) {
        echo "<div class='message-error'>Invalid Token</div>";
        return;
    }

    if (in_array($token, $usedTokens)) {
        echo "<div class='message-error'>Token Already Used</div>";
        return;
    }

    // Validate borrow and return dates for the 10-day rule
    $date1 = strtotime($borrowDate);
    $date2 = strtotime($returnDate);
    $daysDifference = ($date2 - $date1) / 86400; // Calculate difference in days

    // Allow more than 10 days only if token is valid
    if ($daysDifference > 10 && !in_array($token, $tokens)) {
        echo "<div class='message-error'>Can't Borrow a Book for more than 10 days without a valid token</div>";
        return;
    }

    if ($daysDifference == 0) {
        echo "<div class='message-error'>Can't Borrow and Return Book on Same day</div>";
        return;
    }

    // Update token.json to mark token as used
    $usedTokens[] = $token;
    $data[0]['usedToken'] = $usedTokens;

    file_put_contents($jsonFilePath, json_encode($data, JSON_PRETTY_PRINT));

    echo "<div class='message-success'>You're allowed to borrow this book</div>";

    // Display submitted data
    echo "<div class='form-details'>";
    echo "<h2>Receipt</h2>";
    echo "<p><strong>Student Name:</strong> $studentName</p>";
    echo "<p><strong>Student ID:</strong> $studentID</p>";
    echo "<p><strong>Book Selected:</strong> $bookSelected</p>";
    echo "<p><strong>Borrow Date:</strong> $borrowDate</p>";
    echo "<p><strong>Token:</strong> $token</p>";
    echo "<p><strong>Return Date:</strong> $returnDate</p>";
    echo "<p><strong>Fees:</strong> $fees</p>";
    echo "<p><strong>Paid Status:</strong> $paidStatus</p>";
    echo "</div>";
    return;
} else {
    echo "<div class='message-error'>No data submitted</div>";
}
?>

</div>
<br>
</body>
</html>
