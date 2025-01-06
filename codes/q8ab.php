<?php
    session_start();

    $aname = $_GET['aname'];
    $_SESSION['aname'] = $aname;

    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];
    $aname = $_SESSION['aname'];

    print("<h2>$cnumber $semester $year</h2>");
    print("<h3>$aname</h3>");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Grades</title>
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
    $query = "SELECT user_id, grade from do_assignment where cnumber = '$cnumber' and semester='$semester' and year='$year' and a_name='$aname';";
    # execute query1
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    # start printing table
    print("<table>\n");

    # print table head
    print("<thead>");
    print("<tr>\n");
    print("<th>student_id</th>");
    print("<th>fname</th>");
    print("<th>lname</th>");
    print("<th>   grade</th>");
    print("</tr>");
    print("</thead>\n");

    # print the content of the table
    while ($row = mysqli_fetch_assoc($result)) {
        print("<tr>\n");
        $i = 0;
        foreach($row as $key => $value) {
            $array[$i] = $value;
            $i  = $i + 1;
        }


        $query123 = "SELECT fname, lname from student where identifier='$array[0]';";
        if (!($result123 = mysqli_query($conn, $query123))) {
            printf("Error: %s\n", mysqli_error($conn));
            exit(1);
        }

        print("<td>" . $array[0] . "</td>");

        while ($row123 = mysqli_fetch_assoc($result123)) {
            $b = 0;
            foreach($row123 as $key => $value) {
                $array123[$b] = $value;
                $b  = $b + 1;
            }
            print("<td>" . $array123[0] . "</td>");
            print("<td>       " . $array123[1] . "</td>");
        }
        print("<td>       " . $array[1] . "</td>");
        printf("</tr>\n");
    }


    print("<table>/n");
    mysqli_free_result($result1);
    mysqli_free_result($result2);
    mysqli_close($conn);


?>
<h2> To enter a grade or update a grade: </h2>
<form action="q8ac.php" method="POST"> 
    
    <p>Enter student_id: <br>
    <input type="text" name="identifier">
    </p>
    <p>Enter the grade: <br>
    <input type="text" name="grade">
    </p>
    <input type="submit">

</form>


</body>


</html>