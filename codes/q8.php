<?php
    session_start();

    $id = $_GET['id'];
    $cnumber = $_GET['cnumber'];
    $semester = $_GET['semester'];
    $year = $_GET['year'];

    $_SESSION['id'] = $id;
    $_SESSION['cnumber'] = $cnumber;
    $_SESSION['semester'] = $semester;
    $_SESSION['year'] = $year;

    $id = $_SESSION['id'];
    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Page</title>
</head>

<body>
<?php
    # open the connection
    $conn = mysqli_connect("localhost", "cs377", "ma9BcF@Y", "canvasDB");

    # check connection
    if (mysqli_connect_errno()){
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit(1);
    }

    # construct the MySQL query
    $query1 = "SELECT cname from class_name where cnumber = '$cnumber';";
    # execute query1
    if (!($result1 = mysqli_query($conn, $query1))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }
    print("<h1> This is the " . $cnumber . " " . $semester . " " . $year . " page for teacher.</h1>");
    while ($row = mysqli_fetch_assoc($result1)) {

        foreach($row as $key => $value) {
            $array1[0] = $value;
        }
        print("<h2> Course Description: " . $array1[0] . ".</h2>");
    }

    print("<h2><a href=q8aa.php>" . "Assignments Page" . "</a></h2>");
    print("<h2><a href=q8ba.php>" . "Students Page" . "</a></h2>");
    print("<h2><a href=QnA.php>" . "Q & A Page" . "</a></h2>");





?>
</body>


</html>