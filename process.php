<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = ($_POST['studentName'] ?? '');
    $studentID = ($_POST['studentID'] ?? '');
    $studentmail = ($_POST['studentmail'] ?? '');
    $bookSelected = ($_POST['books'] ?? '');
    $borrowDate = ($_POST['borrowDate'] ?? '');
    $returnDate = ($_POST['returnDate'] ?? '');
    $fees = ($_POST['fees'] ?? '');
    $token = ($_POST['token'] ?? '');
    $paidStatus = ($_POST['paid'] ?? '');

    // Validation for studentName
    if (!preg_match("/^[A-Za-z\- ]+$/", $studentName)) {
        echo "Name is Invalid";
        return;
    }

    // Validation for studentID
    if (!preg_match("/^\d{2}-\d{5}-\d{1}$/", $studentID)) {
        echo "Student ID is Invalid";
        return;
    }

    // Validate borrow and return dates for the 10-day rule
    $date1 = strtotime($borrowDate);
    $date2 = strtotime($returnDate);
    $daysDifference = ($date2 - $date1) / 86400; // Calculate difference in days

    if ($daysDifference > 10) {
        echo "Can't Borrow a Book for more than 10 days";
        return;
    }

    // Session management
    if (!isset($_SESSION['studentID'])) {
        $_SESSION['studentID'] = $studentID; // Set the session for the student
        $_SESSION['start_time'] = time(); // Record session start time
    }

    // Check session validity (30 seconds timeout)
    if ($_SESSION['studentID'] === $studentID && (time() - $_SESSION['start_time']) <= 50) 
    {
        // Check for the book cookie
        if (isset($_COOKIE['loaned_book']) && $_COOKIE['loaned_book'] === $bookSelected) 
        {
            echo "This book has already been loaned. Please choose another book.";
        } 
        else 
        {
            // Set a cookie for the loaned book valid for 10 seconds
            setcookie('loaned_book', $bookSelected, time() + 10);
            echo "The book '$bookSelected' has been successfully loaned.<br>";
        }
    } 
    else 
    {
        // Session expired or invalid student ID
        echo "Session expired or invalid student ID. Please start a new session.";
        session_destroy();
        return;
    }

    // Display submitted data
    echo "<h2>Form Data Submitted</h2>";
    echo "<p><strong>Student Name:</strong> $studentName</p>";
    echo "<p><strong>Student ID:</strong> $studentID</p>";
    echo "<p><strong>Book Selected:</strong> $bookSelected</p>";
    echo "<p><strong>Borrow Date:</strong> $borrowDate</p>";
    echo "<p><strong>Token:</strong> $token</p>";
    echo "<p><strong>Return Date:</strong> $returnDate</p>";
    echo "<p><strong>Fees:</strong> $fees</p>";
    echo "<p><strong>Paid Status:</strong> $paidStatus</p>";
} 
else 
{
    echo "No data submitted.";
}
?>
<br>
<form method="post" action="process.php">
    <button type="submit" name="refresh">Refresh</button>
</form>
</body>
</html>
