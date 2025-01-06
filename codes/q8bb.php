<?php
    session_start();

    $identifier = $_GET['identifier'];
    $_SESSION['identifier'] = $identifier;

    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];
    $identifier = $_SESSION['identifier'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Assignment page</title>
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

    $query123 = "SELECT fname, lname from student where identifier='$identifier';";
    if (!($result123 = mysqli_query($conn, $query123))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    while ($row123 = mysqli_fetch_assoc($result123)) {
        $b = 0;
        foreach($row123 as $key => $value) {
            $array123[$b] = $value;
            $b  = $b + 1;
        }
        $fname = $array123[0];
        $lname = $array123[1];
    }

    print("<h2>$cnumber $semester $year</h2>");
    print("<h2>This is the Assignment page for student $fname $lname. </h2>");

    # construct the MySQL query
    $query = "SELECT a_name, grade from do_assignment where cnumber = '$cnumber' and semester='$semester' and year='$year' and user_id='$identifier';";
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
    print("<th>Assignment</th>");
    #print("<th>semester</th>");
    #print("<th>year</th>");
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

        print("<td><a href=q7d.php?cnumber=$cnumber&semester=$semester&year=$year&aname=$array[0]>" . $array[0] . "</a></td>");
        print("<td>" . $array[1] . "</td>");

        printf("</tr>\n");
    }
    print("</table>\n");



?>

<h2> To enter a grade or update a grade: </h2>
<form action="q8bc.php" method="POST"> 
    
    <p>Enter assignment name: <br>
    <input type="text" name="aname">
    </p>
    <p>Enter the grade: <br>
    <input type="text" name="grade">
    </p>
    <input type="submit">

</form>



</body>


</html>