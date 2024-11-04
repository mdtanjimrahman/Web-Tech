<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $studentName = htmlspecialchars($_POST['studentName'] ?? '');
    $studentID = htmlspecialchars($_POST['studentID'] ?? '');
    $bookSelected = htmlspecialchars($_POST['books'] ?? '');
    $borrowDate = htmlspecialchars($_POST['borrow-date'] ?? '');
    $token = htmlspecialchars($_POST['token'] ?? '');
    $returnDate = htmlspecialchars($_POST['return-date'] ?? '');
    $fees = htmlspecialchars($_POST['fees'] ?? '');
    $paidStatus = htmlspecialchars($_POST['paid'] ?? '');

    echo "<h2>Form Data Submitted</h2>";
    echo "<p><strong>Student Name:</strong> $studentName</p>";
    echo "<p><strong>Student ID:</strong> $studentID</p>";
    echo "<p><strong>Book Selected:</strong> $bookSelected</p>";
    echo "<p><strong>Borrow Date:</strong> $borrowDate</p>";
    echo "<p><strong>Token:</strong> $token</p>";
    echo "<p><strong>Return Date:</strong> $returnDate</p>";
    echo "<p><strong>Fees:</strong> $fees</p>";
    echo "<p><strong>Paid Status:</strong> $paidStatus</p>";
} else {
    echo "No data submitted.";
}

    ?>
</body>
</html>