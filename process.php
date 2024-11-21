<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    
    $studentName = ($_POST['studentName'] ?? '');
    $studentID = ($_POST['studentID'] ?? '');
    $bookSelected = ($_POST['books'] ?? '');
    $borrowDate = ($_POST['borrowdate'] ?? '');
    $token = ($_POST['token'] ?? '');
    $returnDate = ($_POST['returndate'] ?? '');
    $fees = ($_POST['fees'] ?? '');
    $paidStatus = ($_POST['paid'] ?? '');

    if (!preg_match("/[A-za-z\-]/", $_POST['studentName']))
    {
        echo "Name is Invalid";
        return;
    }

    if (!preg_match("/\d{2}-\d{5}-\d{1}/", $_POST['studentID']))
    {
        echo "Student ID is Invalid";
        return;
    }

    $date1 = new DateTime($borrowDate);
    $date2 = new DateTime($returnDate);

    $interval = date_diff($date1, $date2);

    if ( ($interval->format('%d')) >10 )
    {
        echo "Can't Borrow a Book for more than 10 days";
        return;
    }


    // Cookie Check Logic
    $cookieName = $books; // Cookie name is the book title
    if (isset($_COOKIE[$cookieName])) 
    {
        if ($_COOKIE[$cookieName] === $studentName) 
        {
            echo "<h3 style='color: red;'>You're not allowed to Loan the same book again.</h3>";
            return;
        }
    }
    // Set the cookie with the book title as the name and student name as the value
    setcookie($cookieName, $studentName, time() + (20), "/"); // Cookie expires in 20 seconds



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
</body>
</html>