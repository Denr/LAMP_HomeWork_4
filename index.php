<html>
<head>
    <script src="scripts/jquery-1.11.3.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
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
                <input type="text" class="form-control" name="mail" id="mail" placeholder="E-mail">
            </div>
            <div class="form-group-lg" align="center">
                <label>Password</label>
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
            </div>
            <div class="form-group-lg" align="center">
                <label>Sex</label>
                <br>
                <label class="radio-inline">
                    <input type="radio" name="sex" value="male">
                    Male
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sex" value="female">
                    Female
                </label>
            </div>
            <div class="form-group-lg" align="center">
                <label>Subscribe on news</label>
                <br>
                <label class="checkbox-inline">
                    <input type="checkbox" class="subscribe" name="subscribe" value="yes">
                    Yes
                </label>
            </div>
            <input type="submit" value="Sign up" class="btn btn-purple btn-lg top">
        </form>
    </div>
    <form method="post" action="show_users.php">
        <div class="row">
            <div class='col-lg-offset-4 col-lg-4'>
                <input type="submit" value="Display all users" class="btn btn-purple btn-lg">
            </div>
        </div>
    </form>
    <div class="row">
        <strong>
            <div class='col-lg-offset-4 col-lg-4 ' role='alert' id="alert"></div>
        </strong>
    </div>
    <form method="post" action="feedback.php">
        <div class="row">
            <div class='col-lg-offset-4 col-lg-4'>
                <input type="submit" value="Leave feedback" class="btn btn-purple btn-lg">
            </div>
        </div>
    </form>
</div>
</body>
</html>
<?php
function validateMail($mail)
{
    return filter_var($mail, FILTER_VALIDATE_EMAIL);
}

function validatePass($pass)
{
    $upperCase = preg_match('@[A-Z]@', $pass);
    $lowerCase = preg_match('@[a-z]@', $pass);
    $number = preg_match('@[0-9]@', $pass);
    if (!$upperCase || !$lowerCase || !$number || strlen($pass) < 8) {
        if (!$upperCase) {
            echo "<script>
                        $('#alert').addClass('alert alert-danger').html('Password must contain at least one uppercase character!');
                  </script>";
        }
        if (!$lowerCase) {
            echo "<script>
                        $('#alert').addClass('alert alert-danger').html('Password must contain at least one lowercase character!');
                 </script>";
        }
        if (!$number) {
            echo "<script>
                        $('#alert').addClass('alert alert-danger').html('Password must contain at least 1 number!');
                  </script>";
        }
        if (strlen($pass) < 8) {
            echo "<script>
                        $('#alert').addClass('alert alert-danger').html('Password must be a minimum of 8 characters!');
                  </script>";
        }
        return false;
    } else {
        return true;
    }
}

$file = "users.json";
$mail = $_POST["mail"];
$pass = $_POST["pass"];
$sex = $_POST["sex"];
$subscribe = $_POST["subscribe"];
if (empty($subscribe)) {
    $subscribe = "no";
}
if (!empty($mail) && !empty($pass) && !empty($sex) && validateMail($mail) && validatePass($pass)) {
    $formData = array(
        "mail" => $mail,
        "pass" => $pass,
        "sex" => $sex,
        "subscribe" => $subscribe
    );
    $arrayData = array();
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $arrayData = json_decode($json, true);
    }
    $arrayData[] = $formData;
    $json = json_encode($arrayData, JSON_PRETTY_PRINT);
    if (file_put_contents($file, $json)) {
        echo "<script>
            $('#alert').addClass('alert alert-success').html('You have successfully registered!');
            $('#mail').val('');
            $('#pass').val('');
            $('input[name=sex][value=" . $sex . "]').attr('checked', false);" . "
            $('input[name=subscribe][value=" . $subscribe . "]').attr('checked', false);" . "
          </script>";
    }
} else {
    echo "<script>
            $('#mail').val('$mail');
            $('#pass').val('$pass');
            $('input[name=sex][value=" . $sex . "]').attr('checked', true);" . "
            $('input[name=subscribe][value=" . $subscribe . "]').attr('checked', true);" . "
          </script>";
    if (!validateMail($mail) && !empty($mail)) {
        echo "<script>
                    $('#alert').addClass('alert alert-danger').html('Incorrect e-mail address!');
              </script>";
    }
    if (empty($sex)) {
        echo "<script>
                    $('#alert').addClass('alert alert-danger').html('All fields required!');
              </script>";
    }
}
?>