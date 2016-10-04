<html>
<head>
    <title>Index</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
</head>

<body>
<div class="container">
    <div class="row">
        <h1>Blog Posts</h1>
        <hr>
    </div>
    <?php
    include "includes.php";

    $database = new databaseCon;

    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //$database->query('SELECT * FROM posts');
    //$rows = $database->resultSet();
    //print_r($rows);

    $database->query('SELECT * FROM blogposts');
    $rows = $database->resultSet();

    foreach($rows as $row) {
        $database->query('SELECT first_name, last_name FROM people WHERE id = :authID');
        $database->bind(':authID', $row['author_id']);
        $database->execute();
        $author = $database->resultSetSingular();
        $row['author_id'] = $author['first_name'] . ' ' . $author['last_name'];

        $dateAndTime = explode(" ", $row['timestamp']);
        $formatedDate = explode("-", $dateAndTime[0]);

        $row['timestamp'] = $formatedDate[1] . '/'. $formatedDate[2] .'/' . $formatedDate[0] . ' at ' . $dateAndTime[1];

        $database->query('SELECT b.id, t.tag_id FROM blogposts b LEFT JOIN blogPost_tags t ON b.id = t.post_id WHERE b.id = :id');
        $database->bind(':id', $row['id']);
        $database->execute();
        $tagsID = $database->resultSet();
        $postTags = [];

        if(sizeof($tagsID) > 0){
            foreach($tagsID as $tagID){
                $database->query('SELECT tag FROM tags WHERE id = :id');
                $database->bind(':id', $tagID['tag_id']);
                $database->execute();
                $tagNames = $database->resultSet();

                foreach($tagNames as $tag){
                    array_push($postTags, $tag['tag']);
                }
            }

        }
        else{
            array_push($postTags, 'No Tags');
        }

    ?>
    <div class="row">
        <div class="col-xs-12">
        <hr>
        <h1><?php echo $row['title'] ?></h1>
        <h4><?php echo $row['author_id'] ?> on <?php echo $row['timestamp'] ?></h4>
        <p>Tags:
            <?php
        //    echo $tagsID[0]['tag_id'];
            echo join(', ', $postTags);
            ?>
        </p>
        <p><?php echo $row['body'] ?></p>
        </div>
    </div>
    <?php
    }
    ?>
</div>
</body>

</html>

