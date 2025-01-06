<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book Store</title>
    <link rel="stylesheet" href="css/bookstyle.css" />
  </head>
  <body>
    <h1>Online Books</h1>
    <img src="assets/myid.png" class="myID">

    <div class="div01">
      <div class="bigbox1"></div>
      <div class="bigbox2"></div>
      <div class="bigbox3">

        <div class="left" id="unused-tokens">
            <h4>Tokens</h4>
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

        <div class="right" id="used-tokens">
            <h4>Used Tokens</h4>
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
      </div>

      <div class="smallbox">
        <img src="assets/avengerBook.jpg">
      </div>
      <div class="smallbox">
        <img src="assets/manga.jpg">
      </div>
      <div class="smallbox">
        <img src="assets/doomsday.jpg">
      </div>
      <div class="form-wrapper">
        <div class="form-container">
          <h2>Borrow Form</h2>
          <form action="process.php" method="POST">
              <div class="form-group" id="name-group">
                  <label for="studentName">Student Full Name:</label>
                  <input type="text" id="studentName" name="studentName" required>
              </div>
              <div class="form-group" id="studentID-group">
                  <label for="studentID">Student ID:</label>
                  <input type="text" id="studentID" name="studentID" required>
              </div>
              <div class="form-group" id="studentmail-group">
                  <label for="studentmail">Student E-mail:</label>
                  <input type="text" id="studentmail" name="studentmail" required>
              </div>
              <div class="form-group" id="bookTitle-group">
                  <label class="bookTitle">Choose a Book:</label>
                  <select id="book-select" name="books">
                    <option value="The Great Gatsby">The Great Gatsby</option>
                    <option value="To Kill a Mockingbird">To Kill a Mockingbird</option>
                    <option value="1984">1984</option>
                    <option value="Pride and Prejudice">Pride and Prejudice</option>
                    <option value="The Catcher in the Rye">The Catcher in the Rye</option>
                    <option value="Moby-Wick">Moby-Wick</option>
                    <option value="War and Peace">War and Peace</option>
                    <option value="The Odyssey">The Odyssey</option>
                    <option value="Crime and Punishment">Crime and Punishment</option>
                    <option value="Jane Eyre">Jane Eyre</option>
                </select>
              </div>
              <div id="dates">
                  <div class="form-group" id="borrowDate-group">
                      <label for="borrowDate">Borrow Date:</label>
                      <input type="date" id="borrowDate" name="borrowDate" required>
                  </div>
                  <div class="form-group" id="returnDate-group">
                      <label for="returnDate">Return Date:</label>
                      <input type="date" id="returnDate" name="returnDate" required>
                  </div>
              </div>
              <div id="fees-token">
                  <div class="form-group" id="fees-group">
                      <label for="fees">Fees:</label>
                      <input type="text" id="fees" name="fees" required>
                  </div>
                  <div class="form-group" id="token-group">
                      <label for="token">Token:</label>
                      <input type="text" id="token" name="token" required>
                  </div>
              </div>
              <div id="paid-submit">
                  <div id="paid-options">
                      <label for="paid-options-label">PAID</label><br>
                      <label><input type="radio" id="paidYes" name="paid" value="yes" required> Yes</label>
                      <label><input type="radio" id="paidNo" name="paid" value="no" required> No</label>
                  </div>
                  <input type="submit" name="submit" value="Submit" class="submit">
              </div>
          </form>
      </div>
  
      <div class="small-form-container">
          <h2>Book Details</h2>
          <form action="process_book.php" method="POST">
              <div class="form-group">
                  <label for="bookTitleSmall">Book Title:</label>
                  <input type="text" id="bookTitleSmall" name="bookTitleSmall" required>
              </div>
              <div class="form-group">
                  <label for="authorName">Author Name:</label>
                  <input type="text" id="authorName" name="authorName" required>
              </div>
              <div class="form-group">
                  <label for="numBooks">Number of Books:</label>
                  <input type="number" id="numBooks" name="numBooks" required>
              </div>
              <div class="form-group">
                  <label for="isbnNumber">ISBN Number:</label>
                  <input type="text" id="isbnNumber" name="isbnNumber" required>
              </div>
  
              <form action="process.php" method="POST" onsubmit="showConfirmation();">
                  <input type="submit" name="addBook" value="Add Book" class="submit">
              </form>
  
          </form>
      </div>
      </div>
    </div>
  </body>
</html>
