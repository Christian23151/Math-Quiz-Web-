<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Mathematics</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Simple Mathematics Quiz</h1>
        <form method="POST" action="quiz.php">
            <label for="num_questions">Number of Questions:</label>
            <input type="number" name="num_questions" id="num_questions" min="1" max="20" required>
    
            <label for="operator">Choose Operator:</label>
        <select name="operator" id="operator">
            <option value="add">Addition</option>
            <option value="subtract">Subtraction</option>
            <option value="multiply">Multiplication</option>
        </select>
    
        <label for="difficulty">Select Difficulty:</label>
        <select name="difficulty" id="difficulty">
            <option value="easy">Easy (1-10)</option>
            <option value="medium">Medium (10-50)</option>
            <option value="hard">Hard (50-100)</option>
        </select>
    
        <button type="submit">Start Quiz</button>
        </form>

    </div>
</body>
</html>
