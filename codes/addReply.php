<?php
    session_start();

    $id = $_SESSION['id'];
    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];

    $poster_id = $_POST['posterid'];
    $post_date = $_POST['postdate'];
    $reply_text = $_POST['replytext'];
    $reply_date = date('Y-m-d H:i:s');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Thread Added</title>
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

    # construct the MySQL query: insert into post
    $query = "INSERT INTO response (cnumber, semester, year, poster_id, post_date, replier_id, reply_date, reply_text) VALUES ('$cnumber', '$semester', '$year', '$poster_id', '$post_date', '$id', '$reply_date', '$reply_text');";
    # execute query
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }


    # construct the MySQL query
    $query = "SELECT reply_text from response where cnumber = '$cnumber' and semester='$semester' and year='$year' and poster_id='$poster_id' and post_date='$post_date' and replier_id='$id' and reply_date='$reply_date';";
    # execute query1
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }


    if(mysqli_num_rows($result) > 0){
        print("<h2> The reply thread has been successfully added.". "</h2>");
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            foreach($row as $key => $value) {
                $array[$i] = $value;
                $i = $i + 1;
            }
        }
        print("<h3>Added response: " . "$array[0]" . "</h3>");
    }

    print("<h2>Go back to: </h2>");
    print("<h2><a href=QnA.php>" . "Q&A Page" . "</a></h2>");


?>



</body>


</html>