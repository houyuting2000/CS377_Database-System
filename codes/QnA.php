<?php
    session_start();

    $id = $_SESSION['id'];
    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];

    print("<h1>Here are the current posts for $cnumber $semester $year:</h1>");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Q & A Page</title>
</head>

<body>
<form action="QnA_tag.php" method="POST"> 
    
    <p>Filter by tag:? <br>
    <input type="text" name="tag">
    </p>
    <input type="submit">

</form>






<?php
    function print_tags ($a){
        $output = "";
        $i = 0;
        foreach($a as $key => $value) {
            if ($i == 0){
                $output = $output . "" . $value;
            }else{
                $output = $output . ", " . $value;
            }
            $i = $i + 1;
        }
        return ($output);
    }


    # open the connection
    $conn = mysqli_connect("localhost", "cs377", "ma9BcF@Y", "canvasDB");

    # check connection
    if (mysqli_connect_errno()){
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit(1);
    }

    # construct the MySQL query
    $query = "SELECT user_id, post_date, post_title from post where cnumber = '$cnumber' and semester='$semester' and year='$year' order by post_date;";
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
    print("<th>user_id</th>");
    print("<th>fname</th>");
    print("<th>lname</th>");
    print("<th>post_date</th>");
    print("<th>tags</th>");
    print("<th>post_title</th>");
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
        # user_id
        print("<td>$array[0]</td>");

        # fname, lname
        $query123 = "SELECT fname, lname from student where identifier='$array[0]';";
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
            print("<td>" . $array123[0] . "</td>");
            print("<td>       " . $array123[1] . "</td>");
        }

        # post date
        print("<td>$array[1]</td>");

        # tags
        $query111 = "SELECT tag from post_tags where cnumber='$cnumber' and semester='$semester' and year='$year' and post_date='$array[1]' and user_id='$array[0]';";
        if (!($result111 = mysqli_query($conn, $query111))) {
            printf("Error: %s\n", mysqli_error($conn));
            exit(1);
        }
        $b = 0;
        while ($row111 = mysqli_fetch_assoc($result111)) {
            foreach($row111 as $key => $value) {
                $array111[$b] = $value;
                $b  = $b + 1;
            }
        }

        $tag_string = print_tags($array111);

        print("<td>$tag_string</td>");

        # post title
        print("<td>" . $array[2] . "</td>");
        printf("</tr>\n");
    }


    print("<table>/n");
    mysqli_free_result($result1);
    mysqli_free_result($result2);
    mysqli_close($conn);
?>

<h2> Direct to the post-threads page: [Please paste correctly and remove all unnecessary spaces at the beginning and end!]</h2>
<form action="threads.php" method="POST"> 
    
    <p>What's the UserID? <br>
    <input type="text" name="posterid">
    </p>
    <p>What the post date? <br>
    <input type="text" name="postdate">
    </p>
    <p>What the post title? <br>
    <input type="text" name="posttitle">
    </p>
    <input type="submit">

</form>

<h2> To Add a Post:</h2>
<form action="addPost.php" method="POST"> 
    
    <p>Enter the title of the new post: <br>
    <input type="text" name="posttitle">
    </p>
    <p>Enter the content:  <br>
    <input type="text" name="posttext">
    </p>
    <p>What the tag1: <br>
    <input type="text" name="tag1">
    </p>
    <p>What the tag2: <br>
    <input type="text" name="tag2">
    </p>
    <input type="submit">

</form>



</body>


</html>
