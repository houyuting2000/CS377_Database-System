<?php
    session_start();

    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];

    print("<h2>$cnumber $semester $year</h2>");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students Page</title>
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
    $query = "SELECT identifier, grade from take_class where cnumber = '$cnumber' and semester='$semester' and year='$year';";
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
    print("<th>letter grade</th>");
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

        print("<td><a href=q8bb.php?identifier=$array[0]>" . $array[0] . " " .  "</a></td>");

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
<h2> To enter a letter grade or update a letter grade: </h2>
<form action="q8bd.php" method="POST"> 
    
    <p>Enter the student ID: <br>
    <input type="text" name="identifier">
    </p>
    <p>Enter the grade: <br>
    <input type="text" name="grade">
    </p>
    <input type="submit">

</form>

</body>


</html>