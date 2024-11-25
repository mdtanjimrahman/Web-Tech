<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        .message {
            text-align: center;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            border-radius: 5px;
        }
        .message.success {
            background-color: #28a745;
        }
        .message.error {
            background-color: #dc3545;
        }
</style>

<body>
    <div class="container">
<?php

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
        echo "<div class='message error'>Name is Invalid</div>";
        return;
    }

    // Validation for studentID
    if (!preg_match("/^\d{2}-\d{5}-\d{1}$/", $studentID)) {
        echo "<div class='message error'>Student ID is Invalid</div>";
        return;
    }

    // Validate borrow and return dates for the 10-day rule
    $date1 = strtotime($borrowDate);
    $date2 = strtotime($returnDate);
    $daysDifference = ($date2 - $date1) / 86400; // Calculate difference in days

    if ($daysDifference > 10) {
        echo "<div class='message error'>Can't Borrow a Book for more than 10 days";
        return;
    }

    $cookieName = str_replace(['=', ',', ';', ' ', "\t", "\r", "\n", "\013", "\014"], '_', $bookSelected);
    // Check if the cookie exists
    if (isset($_COOKIE[$cookieName])) 
    {
        // Check if the cookie value matches the student name
        if ($_COOKIE[$cookieName] === $studentName) 
        {
            echo "<div class='message error'>You're not allowed to borrow the same book again within 10 days</div>";
            return;
        }
    }

    // Set the cookie to expire in 10 days
    setcookie($cookieName, $studentName, time() + (10), "/");
    echo "<div class='message success'>You're allowed to borrow this book</div>";

    // Display submitted data
    echo "<div class='form-details'>";
    echo "<h2>Reciept</h2>";
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
} 
else 
{
    echo "No data submitted.";
}
?>
</div>
<br>
</body>
</html>
