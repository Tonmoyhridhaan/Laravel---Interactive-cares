<?php
    require "../vendor/autoload.php";
    require_once 'Transaction.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
    
        $transaction = new Transaction();
        $transactions = $transaction->getTransactionsByEmail($email);
    
        if (!empty($transactions)) {
            echo "<h2>Transactions for: $email</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Other Party Email</th>
                        <th>Other Party Name</th>
                        <th>Amount</th>
                        <th>Date and Time</th>
                    </tr>";
            foreach ($transactions as $txn) {
                echo "<tr>
                        <td>{$txn['otherEmail']}</td>
                        <td>{$txn['name']}</td>
                        <td>{$txn['amount']}</td>
                        <td>{$txn['dateTime']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No transactions found for this email.";
        }
    }
    ?>
    
    <!-- Sample HTML form to view transactions -->
    <form method="POST" action="test.php">
        Enter Email: <input type="email" name="email" required><br>
        <input type="submit" value="View Transactions">
    </form>
    