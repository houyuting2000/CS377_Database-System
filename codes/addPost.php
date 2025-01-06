<?php
    session_start();

    $id = $_SESSION['id'];
    $cnumber = $_SESSION['cnumber'];
    $semester = $_SESSION['semester'];
    $year = $_SESSION['year'];

    $post_date = date('Y-m-d H:i:s');
    $post_title = $_POST['posttitle'];
    $post_text = $_POST['posttext'];
    $tag1 = $_POST['tag1'];
    $tag2 = $_POST['tag2'];
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

    # construct the MySQL query: insert into post
    $query = "INSERT INTO post (cnumber, semester, year, post_title, post_date, post_text, user_id) VALUES ('$cnumber', '$semester', '$year', '$post_title', '$post_date', '$post_text', '$id');";
    # execute query
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    # construct the MySQL query
    $query = "SELECT post_title, post_text from post where cnumber = '$cnumber' and semester='$semester' and year='$year' and post_date='$post_date' and user_id='$id';";
    # execute query1
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    if(mysqli_num_rows($result) > 0){
        print("<h2> The post has been successfully added. ". "</h2>");
        while ($row = mysqli_fetch_assoc($result)) {
            $i = 0;
            foreach($row as $key => $value) {
                $array[$i] = $value;
                $i = $i + 1;
            }
            print("<h3>title posted: " . "$array[0]" . "</h3>");
            print("<h3>text posted: " . "$array[1]" . "</h3>");
        }
        
    }

    # construct the MySQL query: insert into post_tags
    $query1 = "INSERT INTO post_tags (cnumber, semester, year, post_date, user_id, tag) VALUES ('$cnumber', '$semester', '$year', '$post_date', '$id', '$tag1');";
    if(!empty($tag2)){
        $query2 = "INSERT INTO post_tags (cnumber, semester, year, post_date, user_id, tag) VALUES ('$cnumber', '$semester', '$year', '$post_date', '$id', '$tag2');";
        # execute query
        if (!($result = mysqli_query($conn, $query2))) {
            printf("Error: %s\n", mysqli_error($conn));
            exit(1);
        }
    }
    # execute query
    if (!($result = mysqli_query($conn, $query1))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    # construct the MySQL query
    $query = "SELECT tag from post_tags where cnumber = '$cnumber' and semester='$semester' and year='$year' and post_date='$post_date' and user_id='$id';";
    # execute query
    if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    }

    if(mysqli_num_rows($result) > 0){
        print("<h2> The post tag has been successfully added. ". "</h2>");
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            foreach($row as $key => $value) {
                $array[$i] = $value;
                $i = $i + 1;
            }
            print("<h3>Added tag1: " . "$array[0]" . "</h3>");
            print("<h3>Added tag2: " . "$array[1]" . "</h3>");
        }
    }

    print("<h2>Go back to: </h2>");
    print("<h2><a href=QnA.php>" . "Q&A Page" . "</a></h2>");


?>



</body>


</html>