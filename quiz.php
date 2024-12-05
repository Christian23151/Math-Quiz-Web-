<?php
session_start();
if (!isset($_SESSION['quiz'])) {
    $num_questions = (int)$_POST['num_questions'];
    $operator = $_POST['operator'];
    $difficulty = $_POST['difficulty'];
    $_SESSION['quiz'] = [
        'questions' => generateQuestions($num_questions, $operator, $difficulty),
        'current' => 0,
        'correct' => 0,
        'wrong' => 0,
    ];
}


$quiz = &$_SESSION['quiz']; 


$remark = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $currentQuestion = $quiz['questions'][$quiz['current']];
    if ((int)$_POST['answer'] === $currentQuestion['answer']) {
        $quiz['correct']++;
        $remark = "<span class='correct'>Correct!</span>";
    } else {
        $quiz['wrong']++;
        $remark = "<span class='wrong'>Wrong!</span>";
    }
    $quiz['current']++;
}


if ($quiz['current'] >= count($quiz['questions'])) {
    header("Location: result.php");
    exit;
}


$currentQuestion = $quiz['questions'][$quiz['current']];
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
        <form method="POST">
            <p>
                <strong>Question <?php echo $quiz['current'] + 1; ?>:</strong>
                <?php echo "{$currentQuestion['num1']} {$currentQuestion['symbol']} {$currentQuestion['num2']} = ?"; ?>
            </p>

            <!-- Horizontal choices layout -->
            <div class="choices">
                <?php foreach ($currentQuestion['choices'] as $choice): ?>
                    <label>
                        <input type="radio" name="answer" value="<?php echo $choice; ?>" required>
                        <?php echo $choice; ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit">Next</button>
            <button type="button" class="secondary" onclick="window.location.href='result.php'">End</button>
        </form>

        <p>Score: Correct <?php echo $quiz['correct']; ?> | Wrong <?php echo $quiz['wrong']; ?></p>
        <p>Remarks: <?php echo $remark; ?></p>
    </div>
</body>
</html>

<?php

function generateQuestions($numQuestions, $operator, $difficulty) {
    $questions = [];
    $range = match ($difficulty) {
        'easy' => [1, 10],
        'medium' => [10, 50],
        'hard' => [50, 100],
        default => [1, 10], // Fallback to easy
    };
    
    for ($i = 0; $i < $numQuestions; $i++) {
        $num1 = rand($range[0], $range[1]);
        $num2 = rand($range[0], $range[1]);
        $answer = match ($operator) {
            'add' => $num1 + $num2,
            'subtract' => $num1 - $num2,
            'multiply' => $num1 * $num2,
            default => 0,
        };

        
        $choices = [$answer];
        while (count($choices) < 4) {
            $wrongChoice = rand($range[0], $range[1]) * ($operator === 'multiply' ? rand(1, 2) : 1);
            if (!in_array($wrongChoice, $choices)) {
                $choices[] = $wrongChoice;
            }
        }
        shuffle($choices);

        $questions[] = [
            'num1' => $num1,
            'num2' => $num2,
            'symbol' => match ($operator) {
                'add' => '+',
                'subtract' => '-',
                'multiply' => 'x',
                default => '',
            },
            'answer' => $answer,
            'choices' => $choices,
        ];
    }
    return $questions;
}


function generateChoices($correct) {
    $choices = [$correct];
    while (count($choices) < 4) {
        $fake = $correct + rand(-10, 10);
        if (!in_array($fake, $choices) && $fake >= 0) {
            $choices[] = $fake;
        }
    }
    shuffle($choices);
    return $choices;
}
?>
