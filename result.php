<?php
session_start();

// Retrieve quiz data
$quiz = $_SESSION['quiz'];
$total_questions = count($quiz['questions']);
$correct = $quiz['correct'];
$wrong = $quiz['wrong'];
$grade = round(($correct / $total_questions) * 100);

// Clear session
unset($_SESSION['quiz']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Quiz Results</h1>
        <p>Total Questions: <?php echo $total_questions; ?></p>
        <p>Correct Answers: <?php echo $correct; ?></p>
        <p>Wrong Answers: <?php echo $wrong; ?></p>
        <p>Your Grade: <strong><?php echo $grade; ?>%</strong></p>

        <button onclick="window.location.href='index.php'">Start Again</button>
    </div>
</body>
</html>
