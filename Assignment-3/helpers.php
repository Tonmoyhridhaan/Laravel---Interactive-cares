<?php

function sanitize(string $data): string
{
    return htmlspecialchars(stripslashes(trim($data)));
}
function flash($key, $message = null)
{
    if ($message) {
        $_SESSION['flash'][$key] = $message;
    }
    else if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
}
function getLastId(){
    $user_id = 0;
    if (file_exists("last_user_id.txt")) {
        $file = fopen("last_user_id.txt", "r");
        if ($file) {
            $last_user_id = intval(fgets($file));
            fclose($file);
            $user_id = $last_user_id + 1;
        }
    }
    return $user_id;
}
function updateLastId($user_id){
    $file = fopen("last_user_id.txt", "w");
    if ($file) {
        fwrite($file, $user_id);
        fclose($file);
    }
}

function getUserNameById($userId) {
    $filePath = 'users.txt';
    $userFile = fopen($filePath, 'r');
    
    if ($userFile) {
        while (($line = fgets($userFile)) !== false) {
            $userData = explode(", ", trim($line));
            $id = str_replace("ID: ", "", $userData[0]);
            if ($id == $userId) {
                $name = str_replace("Name: ", "", $userData[1]);
                fclose($userFile);
                return $name;
            }
        }
        fclose($userFile);
    }
    return null;
}
function getUserLinkById($userId) {
    $filePath = 'users.txt';
    $userFile = fopen($filePath, 'r');
    
    if ($userFile) {
        while (($line = fgets($userFile)) !== false) {
            $userData = explode(", ", trim($line));
            $id = str_replace("ID: ", "", $userData[0]);
            if ($id == $userId) {
                $name = str_replace("Link: ", "", $userData[4]);
                fclose($userFile);
                return $name;
            }
        }
        fclose($userFile);
    }
    return null;
}

function getIdByLink($link) {
    $filePath = 'users.txt';
    
    if (!file_exists($filePath)) {
        return null;
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES);
    
    foreach ($lines as $line) {
        if (strpos($line, $link) !== false) {
            preg_match('/ID: (\d+)/', $line, $matches);
            if (isset($matches[1])) {
                return $matches[1];
            }
        }
    }
    
    return null; 
}

function parseFeedbacksFromFile() {
    $feedbacks = [];
    $file = fopen("feedbacks.txt", "r");

    if ($file) {
        $currentFeedback = null;
        $feedbackBuffer = '';

        while (($line = fgets($file)) !== false) {
            
            $line = rtrim($line);

            if (strpos($line, 'ID :') === 0) {
              
                if ($currentFeedback !== null) {
                    $currentFeedback['Feedback'] = rtrim($feedbackBuffer);
                    if (substr($currentFeedback['Feedback'], -1) === '}') {
                        $currentFeedback['Feedback'] = substr($currentFeedback['Feedback'], 0, -1);
                    }
                    $feedbacks[] = $currentFeedback;
                    $currentFeedback = null;
                    $feedbackBuffer = '';
                }

               
                $id = trim(str_replace('ID :', '', $line));
                $currentFeedback['ID'] = $id;
            } elseif (strpos($line, 'Feedback : {') === 0) {
                
                $feedbackBuffer = '';
                $insideFeedback = true;
                $feedbackBuffer = trim(str_replace('Feedback : {', '', $line)) . "\n";
            } elseif ($insideFeedback) {
                if (strpos($line, '}') !== false) {
                    $insideFeedback = false;
                    $feedbackBuffer .= rtrim(str_replace('}', '', $line));
                    $currentFeedback['Feedback'] = rtrim($feedbackBuffer);
                    if (substr($currentFeedback['Feedback'], -1) === '}') {
                        $currentFeedback['Feedback'] = substr($currentFeedback['Feedback'], 0, -1);
                    }
                    $feedbacks[] = $currentFeedback;
                    $currentFeedback = null;
                    $feedbackBuffer = '';
                } else {
                    $feedbackBuffer .= $line . "\n";
                }
            }
        }
        if ($currentFeedback !== null) {
            $currentFeedback['Feedback'] = rtrim($feedbackBuffer);
            if (substr($currentFeedback['Feedback'], -1) === '}') {
                $currentFeedback['Feedback'] = substr($currentFeedback['Feedback'], 0, -1);
            }
            $feedbacks[] = $currentFeedback;
        }

        fclose($file);
    }

    return $feedbacks;
}

function getFeedbacksById($id) {
    $allFeedbacks = parseFeedbacksFromFile();
    $feedbacksForId = array_filter($allFeedbacks, function($feedback) use ($id) {
        return $feedback['ID'] == $id;
    });
    return $feedbacksForId;
}





?>