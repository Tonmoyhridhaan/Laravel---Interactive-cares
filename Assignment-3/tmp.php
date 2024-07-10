<?php
require 'helpers.php';
$filename = "feedbacks.txt";

$idToSearch = 2;
$feedbacksForId = getFeedbacksById($idToSearch);

foreach ($feedbacksForId as $feedback) {
    echo "ID: " . $feedback['ID'] . "<br>";
    echo "Feedback: <pre>" . htmlspecialchars($feedback['Feedback']) . "</pre><br>";
}

?>