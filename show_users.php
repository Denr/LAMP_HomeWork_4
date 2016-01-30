<!DOCTYPE html>
<html lang="en">
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
</div>
<?php
$file = "users.json";
if (file_exists($file)) {
    $json = file_get_contents($file);
}
$json_decoded = json_decode($json, true);
$output_table = "<table class=\"table table-hover\" align=\"center\">
                    <thead align=\"center\">
                            <tr>
                                <td>#</td>
                                <td>E-mail</td>
                                <td>Password</td>
                                <td>Sex</td>
                                <td>Subscribe?</td>
                            </tr>
                    </thead>
                    <tbody align=\"center\">";
$count = 1;
foreach ($json_decoded as $users => $value) {
    $output_table .= "<tr><td>$count</td><td>" . $value['mail'] . "</td><td>" . $value['pass'] . "</td><td>" . $value['sex'] . "</td><td>" . $value['subscribe'] . "</td></tr>";
    $count++;
}
$output_table .= "</tbody>
                    </table>";
echo $output_table;
?>
</body>
</html>