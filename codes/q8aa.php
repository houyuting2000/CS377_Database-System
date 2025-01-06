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
    <title>Assignments Page</title>
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
    $query = "SELECT a_name, points from assignment where cnumber = '$cnumber' and semester='$semester' and year='$year';";
    # execute query
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    # start printing table
    print("<table>\n");

    # print table head
    print("<thead>");
    print("<tr>\n");
    print("<th>Assignment</th>");
    #print("<th>semester</th>");
    #print("<th>year</th>");
    print("<th>   TotalPoints</th>");
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
        
        print("<td><a href=q8ab.php?aname=$array[0]>" . $array[0] . " " .  "</a></td>");
        print("<td>       " . $array[1] . "</td>");
        printf("</tr>\n");
    }


    print("<table>/n");
    mysqli_free_result($result1);
    mysqli_free_result($result2);
    mysqli_close($conn);




?>
<h2> To create a new assignment: </h2>
<form action="q8ad.php" method="POST"> 
    
    <p>Assignment Name: <br>
    <input type="text" name="aname">
    </p>
    <p>Total Points: <br>
    <input type="text" name="points">
    </p>
    <p> Due Date (must follow "yyyy/mm/dd 23:00"): <br>
    <input type="text" name="due_date">
    </p>
    <p> Text: <br>
    <input type="text" name="text">
    </p>
    <input type="submit">

</form>

</body>


</html>