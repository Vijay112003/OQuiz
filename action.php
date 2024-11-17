<?php
echo "<head>
<title>Examination</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
</head>";
$uname = $_POST['uname'];
$pass = $_POST['pass'];
$db = "examination";
$conn = new mysqli("localhost", "root", "", $db);
if ($conn->connect_error) {
    die("Connection failed");
}
$query1 = "SELECT user_id FROM user_register WHERE user_name='$uname' AND pass='$pass'";
$res = $conn->query($query1);
if ($res && $res->num_rows === 1) {
    $resultquery = "CREATE TABLE IF NOT EXISTS user_ans (
    user_name VARCHAR(50),
    question_id INT(3),
    user_ans VARCHAR(50),
    crt_ans VARCHAR(50)
    );";
    if ($conn->query($resultquery) === TRUE) {
        $query2 = "CREATE TABLE IF NOT EXISTS questions (
        ques_id INT(3) AUTO_INCREMENT,
        question VARCHAR(100) UNIQUE,
        opt1 VARCHAR(50),
        opt2 VARCHAR(50),
        opt3 VARCHAR(50),
        opt4 VARCHAR(50),
        answer VARCHAR(50),
        PRIMARY KEY (ques_id)
        );";
        if ($conn->query($query2) === TRUE) {
            $query8 = "SELECT user_name FROM user_ans WHERE user_name='$uname' LIMIT 1";
            $res1 = $conn->query($query8);
            if ($res1 && $res1->num_rows == 1) {
                echo "<div class='container mt-5 col-5'>
                <div class='card'>
                <h5 class='card-title m-3'>Already attended</h5>
                <div class='card-body'>";
                echo "<form action='result.php' method='POST'>";
                echo "<input type='hidden' Value='$uname' name='uname'>";
                echo "<div class='d-grid gap-2 col-4 mx-auto'>
                <input type='submit' class='btn btn-primary' name='score' Value='View score'>
                </div>";
                echo "</form>";
                echo "</div>
                </div>
                </div>";
            } else {
                $query3 = "SELECT * FROM questions LIMIT 20";
                $res1 = $conn->query($query3);
                echo "<div class='container mt-5 col-5'>
                <div class='card'>
                <h5 class='card-title m-3'>ALL THE BEST</h5>
                <div class='card-body'>";
                echo "<form action='result.php' method='POST'>";
                foreach ($res1 as $row) {
                    echo $row['ques_id'] . ")" . $row['question'] . "<br><input type='radio' name='q" . $row['ques_id'] . "'
                    value='" . $row['opt1'] . "' required>" . $row['opt1'] . "<br><input type='radio' name='q" . $row['ques_id'] . "'
                    value='" . $row['opt2'] . "'>" . $row['opt2'] . "<br><input type='radio' name='q" . $row['ques_id'] . "'
                    value='" . $row['opt3'] . "'>" . $row['opt3'] . "<br><input type='radio' name='q" . $row['ques_id'] . "'
                    value='" . $row['opt4'] . "'>" . $row['opt4'] . "<br><br>";
                }
                echo "<input type='hidden' Value='$uname' name='uname'><div class='d-grid gap-2 col-4 mx-auto'>
                <input type='submit' class='btn btn-primary' name='score' Value='submit'>
                </div></form></div>
                </div>
                </div>";
            }
        }
    }
} else {
    echo "<div class='container mt-5 col-5'>
    <div class='card'>
    <h5 class='card-title m-3'>User not found</h5>
    <div class='card'>
    <h5 class='card-title m-3'>User not found</h5>
    <div class='card-body'><form action='index.php' method='POST'><div class='d-grid gap-2 col-4 mx-auto'>
    <input type='submit' class='btn btn-primary' name='score' Value='Register'>
    </div></form></div>
    </div>
    </div>";
}
?>