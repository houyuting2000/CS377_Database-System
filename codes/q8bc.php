<?php
    session_start();

    $identifier = $_SESSION['identifier'];
    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];

    $aname = $_POST['aname'];
    $grade = $_POST['grade'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grade Changed</title>
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
    $query = "UPDATE do_assignment set grade='$grade' where cnumber = '$cnumber' and semester='$semester' and year='$year' and a_name='$aname' and user_id='$identifier';";
    # execute query1
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    # construct the MySQL query
    $query = "SELECT grade from do_assignment where cnumber = '$cnumber' and semester='$semester' and year='$year' and a_name='$aname' and user_id='$identifier';";
    # execute query1
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    while ($row = mysqli_fetch_assoc($result)) {

        foreach($row as $key => $value) {
            $array[0] = $value;
        }
        print("<h2> The assignment grade for student(id) $identifier has been set to: " . $array[0] . ".</h2>");
    }

    print("<h2>Go back to: </h2>");
    print("<h2><a href=q8ba.php>" . "Students Page" . "</a></h2>");


?>



</body>


</html>