<?php
    session_start();

    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];

    $aname = $_POST['aname'];
    $text = $_POST['text'];
    $duedate = $_POST['due_date'];
    $points = $_POST['points'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Assignment Added</title>
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
    $query = "INSERT INTO assignment (cnumber, semester, year, a_name, due_date, text, points) VALUES ('$cnumber', '$semester', '$year', '$aname', '$duedate', '$text', '$points');";
    # execute query
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    # construct the MySQL query
    $query = "SELECT due_date, text, points from assignment where cnumber = '$cnumber' and semester='$semester' and year='$year' and a_name='$aname';";
    # execute query1
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    if(mysqli_num_rows($result) > 0){
        print("<h2> The assignment has been successfully added. ". "</h2>");
        while ($row = mysqli_fetch_assoc($result)) {
            $i = 0;
            foreach($row as $key => $value) {
                $array[$i] = $value;
                $i = $i + 1;
            }
            print("<h3>Text: " . "$array[1]" . "</h3>");
            print("<h3>Due_date: " . "$array[0]" . "</h3>");
            print("<h3>Points: " . "$array[2]" . "</h3>");
        }
        
    }

    

    print("<h2>Go back to: </h2>");
    print("<h2><a href=q8aa.php>" . "Assignments Page" . "</a></h2>");


?>



</body>


</html>