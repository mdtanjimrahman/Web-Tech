<?php require 'dbConnection.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book Store</title>
    <link rel="stylesheet" type="text/css" href="./css/bookstyle.css" />
</head>

<body>
    <h1>Online Books</h1>
    <img src="assets/id.png" class="myID">
    <div class="container">
        <!-- Top 3 boxes -->
        <div class="box1">
            <p>
                <?php
                // Assuming $conn is your active MySQL connection
                $sql = "SELECT * FROM book"; // Correct SQL query
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) 
                {
                    echo '<table border="1" style="width:100%; text-align:left; border-collapse:collapse;">';
                    echo '<tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Category</th>
                            <th>Quantity</th>
                        </tr>'; // Table headers

                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['bookTitle'] . '</td>';
                        echo '<td>' . $row['bookAuthor'] . '</td>';
                        echo '<td>' . $row['isbn'] . '</td>';
                        echo '<td>' . $row['bookCategory'] . '</td>';
                        echo '<td>' . $row['bookQuantity'] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } 
                else 
                    echo "<div class='message error'>No books found in the database.</div>";
                

               // mysqli_close($conn); // Close the database connection if you're done
                ?>
            </p>
        </div>
        <div class="box2">
            

            <h3>Search Book by ID</h3>
            <form method="POST" action="">
                <label for="book_id">Enter Book ID:</label>
                <input type="text" id="book_id" name="book_id" required>
                <button type="submit" name="search">Search</button>
            </form>

            <?php
            // Assuming $conn is your active MySQL connection
            if (isset($_POST['search'])) {
                $bookId = $_POST['book_id'];

                $sql = "SELECT * FROM book WHERE id = '$bookId'";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    // Query execution failed
                    echo '<p>Error executing query: ' . mysqli_error($conn) . '</p>';
                    return;
                }        

                if (mysqli_num_rows($result) === 0) {
                    // No book found
                    echo '<p>No book found with the ID: ' . htmlspecialchars($bookId) . '</p>';
                    return;
                }
                
                $book = mysqli_fetch_assoc($result);

                if ($book) 
                {
                    // Display the book information and an update form
                    echo '<h3>Book Information</h3>';
                    echo '<form method="POST" action="process.php">';
                    echo '<input type="hidden" name="book_id" value="' . ($book['id']) . '"';
                    echo '<label for="name">Book Name:</label>';
                    echo '<input type="text" id="name" name="title" value="' . ($book['bookTitle']) . '" required><br> <br>';
                    echo '<label for="title">Book Title:</label>';
                    echo '<input type="text" id="title" name="authorName" value="' . ($book['bookAuthor']) . '" required><br> <br>';
                    echo '<label for="category">Category:</label>';
                    echo '<input type="text" id="category" name="category" value="' . ($book['bookCategory']) . '" required><br> <br>';
                    echo '<label for="isbn">ISBN:</label>';
                    echo '<input type="text" id="isbn" name="isbn" value="' . ($book['isbn']) . '" required><br> <br>';
                    echo '<label for="quantity">Quantity:</label>';
                    echo '<input type="text" id="isbn" name="quantity" value="' . ($book['bookQuantity']) . '" required><br> <br>';
                    echo '<button type="submit" name="book_update">Update</button>';
                    echo '<button type="submit" name="book_delete" style="color: red; margin-left: 10px;">Delete</button>';
                    echo '</form>';
                }

                else 
                    echo '<p>No book found with the ID: ' . $bookId . '</p>';

                
            }

            // Handle the update
            if (isset($_POST['update'])) 
            {
                $bookId = $_POST['book_id'];
                $name = $_POST['name'];
                $title = $_POST['title'];
                $category = $_POST['category'];
                $isbn = $_POST['isbn'];

                $updateSql = "UPDATE book_info SET name = '$name', title = '$title', category = '$category', isbn = '$isbn' WHERE id = '$bookId'";
                $updateResult = mysqli_query($conn, $updateSql);

                if ($updateResult) 
                    echo '<p>Book information updated successfully!</p>';
                else 
                    echo '<p>Error updating book information. Please try again.</p>';
                
            }
            ?>
        </div>

        <!-- First Box 3: Display all tokens -->
        <div class="box3">
         
            <h3>All Tokens</h3>
            <ul>
                <?php
                $tokenFile = "./token.json";
                if (file_exists($tokenFile)) {
                    $jsonData = json_decode(file_get_contents($tokenFile), true);

                    if (isset($jsonData[0]['token'])) 
                    {
                        foreach ($jsonData[0]['token'] as $token) 
                            echo "<li>Token: $token</li>";
                    } 
                    else 
                        echo "<li>No tokens found in the JSON file.</li>";
                    
                } 
                else 
                    echo "<li>JSON file not found.</li>";
                
                ?>
            </ul>
        </div>

        <!-- Second Box 3 -->
        <div class="box4">
        
        <h3>Already Tokens</h3>
            <ul>
                <?php
                if (file_exists($tokenFile)) {
                    $jsonData = json_decode(file_get_contents($tokenFile), true);

                    if (isset($jsonData[0]['usedToken'])) 
                    {
                        foreach ($jsonData[0]['usedToken'] as $token) 
                            echo "<li>Token: $token</li>";
                    } 
                    else 
                        echo "<li>No tokens found in the JSON file.</li>";
                    
                } 
                else 
                    echo "<li>JSON file not found.</li>";
                
                ?>
            </ul>
        </div>

        <!-- Form Section -->
        <div class="box5">
            
            <img src = "assets/book1.png "> 
        </div>
        <div class="box6">
            
            <img src = "assets/book2.png"> 
        </div>
        <div class="box7">
            
            <img src = "assets/book3.png"> 
        </div>

        <!-- Borrow Book -->
        <div class="box8">
            
            <div class="form-container">
                <h2>Borrow a Book</h2>
                <form method="POST" action="process.php">
                    <input type="text" placeholder="Student Full Name" name="userName" required>
                    <input type="text" placeholder="Student ID" name="userID" required>

                    <!-- Book Selection Dropdown -->
                    <select name="books" id="books" required>
                        <option value="" disabled selected>Select a book</option>
                        <?php
                        include 'dbConnection.php'; // Include database connection
                        
                        // Query to get books with quantity > 0
                        $sql = "SELECT * FROM book WHERE bookQuantity > 0";
                        $result = mysqli_query($conn, $sql);
                        
                        if ($result && mysqli_num_rows($result) > 0) 
                        {
                            
                            while ($row = mysqli_fetch_assoc($result)) 
                                echo '<option value="' . $row['id'] . '">' . $row['bookTitle'] . '</option>';
                        } 
                        else 
                            echo '<option value="" disabled>No books available</option>';
                        ?>
                    </select>

                    <label>Borrow Date</label>
                    <input type="date" placeholder="Borrow Date" name="borrowDate" required>
                    <input type="text" placeholder="Token" name="token" required>
                    <label>Return Date</label>
                    <input type="date" placeholder="Return Date" name="returnDate" required>
                    <input type="text" placeholder="Fees" name="fees" required>

                    <label>Paid: </label>
                    <input type="radio" id="option1" name="paid" value="Paid" required>
                    <label for="paid">Yes</label>
                    <input type="radio" id="option2" name="paid" value="Not Paid" required>
                    <label for="not_paid">NO</label>
                    <br>

                    <input type="submit" name="borrow_book" value="Submit">
                </form>
            </div>
        </div>

        <!-- Add Book -->
        <div class="box9">
            
            <div class="form-container">
                <h2>Book Info</h2>
                <form action="process.php" method="post">
                    <input type="text" placeholder="Book Title" name="title">
                    <input type="text" placeholder="Author Name" name="authorName">
                    <input type="number" placeholder="ISBN Number" name="isbn"> <br> <br>
                    <label>Category</label>
                    <select name = "category" required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="Science">Science</option>
                        <option value="Math">Math</option>
                        <option value="History">History</option>
                        <option value="Literature">Literature</option>
                        <option value="Art">Art</option>
                    </select>
                    <br>
                    <input type="number" placeholder="Number of Book" name="quantity"> <br>
                    <input type="submit" name="new_book" value="Submit">
                </form>
            </div>
        </div>
    </div>
</body>
</html>