<?php
    session_start();

    $id = $_SESSION['id'];
    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];

    $post_title = $_POST['posttitle'];
    $post_date = $_POST['postdate'];
    $poster_id = $_POST['posterid'];

    print("<h2>Post information:</h2>\n");
    print("<h3>Poster: $poster_id</h3>\n");
    print("<h3>Post date: $post_date</h3>\n");
    print("<h3>Title: $post_title</h3>");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Q & A Page</title>
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
$query = "SELECT post_text from post where cnumber = '$cnumber' and semester='$semester' and year='$year' and user_id LIKE '%$poster_id%' and post_date='$post_date';";
# execute query
if (!($result = mysqli_query($conn, $query))) {
    printf("Error: %s\n", mysqli_error($conn));
    exit(1);
}

# print the content of the table
while ($row = mysqli_fetch_assoc($result)) {
    $i = 0;
    foreach($row as $key => $value) {
        $array1[$i] = $value;
        $i  = $i + 1;
    }

    printf("<h3>Post:" .  $array1[0] . "</h3>\n");
}

print("<p>Here are the threads for this post: </p>");

# construct the MySQL query
$query = "SELECT replier_id, reply_date, reply_text from response where cnumber = '$cnumber' and semester='$semester' and year='$year' and poster_id='$poster_id' and post_date='$post_date';";
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
print("<th>replier_id</th>");
print("<th>fname</th>");
print("<th>lname</th>");
print("<th>reply_date</th>");
print("<th>reply content</th>");
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
    # replier_id
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

    # reply date
    print("<td>$array[1]</td>");
    # reply content
    print("<td>$array[2]</td>");

    printf("</tr>\n");
}


print("<table>/n");
mysqli_free_result($result);
mysqli_close($conn);



?>
</body>

<h2>Start a new thread: </h2>

<form action="addReply.php" method="POST"> 
    <p>Please copy and paste the id of the author of the post (posterid): <br>
    <input type="text" name="posterid">
    </p>
    <p>Please copy and paste the datetime of the post (post date):<br>
    <input type="text" name="postdate">
    </p>
    <p>Enter your reply: <br>
    <input type="text" name="replytext">
    </p>
    
    <input type="submit">

</form>

</html>