<html>
<head>
    <script src="scripts/jquery-1.11.3.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/script.js"></script>
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <meta charset="utf-8">
    <title>LAMP Task 4</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="well col-lg-12">
            <h1>LAMP Task 4</h1>
        </div>
    </div>
    <div class="row">
        <form method="post" action="" id="form">
            <div class="form-group-lg" align="center">
                <label>E-mail</label>
                <input type="email" class="form-control" name="mail" id="mail" placeholder="E-mail" required>
            </div>
            <div class="form-group-lg" align="center">
                <label>Text of feedback</label>
                <textarea name="feedback" id="feedback" class="form-control"
                          placeholder="Text of feedback (maximum 200 characters)" rows="3"
                          required></textarea>
            </div>
            <label class="char" id="char"></label>
            <br>
            <input type="submit" value="Write" class="btn btn-purple btn-lg top">
        </form>
    </div>
    <form method="post" action="show_feedback.php">
        <div class="row">
            <div class='col-lg-offset-4 col-lg-4'>
                <input type="submit" value="Display all feedback" class="btn btn-purple btn-lg">
            </div>
        </div>
    </form>
    <div class="row">
        <strong>
            <div class='col-lg-offset-4 col-lg-4 ' role='alert' id="alert"></div>
        </strong>
    </div>
</div>
</body>
</html>
<?php
$file = "users.json";
$file_feedback = "feedback.json";
$mail = $_POST["mail"];
$feedback = $_POST["feedback"];
$feedback = str_replace("\r\n", "<br>", $feedback);
$line_number = 1;
if (file_exists($file)) {
    $json = file_get_contents($file);
}
$file = new SplFileObject("users.json");
foreach ($file as $line) {
    $position = strripos($line, $mail);
    if ($position === false) {
        $count++;
    } else {
        break;
    }
}
$json_decoded = json_decode($json, true);
$formData = array(
    "id" => $count + 1,
    "feedback" => $feedback
);
$arrayData = array();
if (file_exists($file_feedback)) {
    $jsonFeed = file_get_contents($file_feedback);
    $arrayData = json_decode($jsonFeed, true);
}
$arrayData[] = $formData;
$jsonFeed = json_encode($arrayData, JSON_PRETTY_PRINT);
foreach ($json_decoded as $users => $value) {
    if (strcasecmp($value['mail'], $mail) == 0) {
        if (file_put_contents($file_feedback, $jsonFeed)) {
            echo "<script>
                $('#mail').val('');
                $('#feedback').val('');
                $('#alert').removeClass('alert alert-danger').addClass('alert alert-success').html('Reviewed by!');
          </script>";
            break;
        }
    } else {
        echo "<script>
                $('#mail').val('$mail');
                $('#feedback').val('$feedback');
                $('#alert').addClass('alert alert-danger').html('Incorrect e-mail address!');
          </script>";
    }
}
?>