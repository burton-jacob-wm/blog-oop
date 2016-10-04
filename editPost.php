<html>
<head>
    <title>Index</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="row">
        <h1>Admin - Delete Posts <a href="admin.php" style="float: right"><button class="btn btn-default"><</button></a></h1>
        <hr>
    </div>
    <?php
    include "includes.php";

    $database = new databaseCon;

    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if(@$_POST['delete']){
        $delete_id = $_POST['delete_id'];
        $database->query('DELETE FROM blogposts WHERE id = :id');
        $database->bind(':id', $delete_id);
        $database->execute();

        $database->query('DELETE FROM blogPost_tags WHERE post_id = :id');
        $database->bind(':id', $delete_id);
        $database->execute();


    }

    if(@$post['update']){
        $id = $post['id'];
        $title = $post['title'];
        $body = $post['body'];
        $author_id = $post['author_id'];
        $tag_id = $post['tag_id'];

        $database->query('UPDATE posts SET title = :title, body = :body, author_id = :author_id WHERE id = :id');
        $database->bind(':title', $title);
        $database->bind(':body', $body);
        $database->bind(':author_id', $author_id);
        $database->bind(':id', $id);
        $database->execute();

        $database->query('DELETE FROM blogPost_tags WHERE post_id = :id');
        $database->bind(':id', $delete_id);
        $database->execute();

        $database->query('INSERT INTO blogPost_tags (tagCol_id, post_id, tag_id) VALUES (NULL, :post_id, :tag_id)');
        $database->bind(':post_id', $id);
        $database->bind(':tag_id', $tag_id);
        $database->execute();
    }

    //$database->query('SELECT * FROM posts');
    //$rows = $database->resultSet();
    //print_r($rows);

    $database->query('SELECT * FROM blogposts');
    $rows = $database->resultSet();

    $database->query('SELECT * FROM people');
    $authors = $database->resultSet();

    $database->query('SELECT * FROM tags');
    $tags = $database->resultSet();

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
        <div id="editModal<?php echo $row['id'] ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">x</button>
                        <h3 class="modal-title"><?php echo 'Edit Post: ' . $row['title'] ?></h3>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" role="form">
                            <div class="form-group row">
                                <label class="col-sm-3">Specific ID</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="id" placeholder="Post ID" value="<?php echo $row['id']?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">Post Title</label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" class="form-control" placeholder="Add a Title..." value="<?php echo $row['title']?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">Post Author</label>
                                <div class="col-sm-9">
                                    <select name="author_id" class="form-control">
                                        <?php
                                        foreach ($authors as $author) {
                                            echo '<option value="' . $author['id'] .'">' . $author['first_name'] . ' ' . $author['last_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">Post Tag</label>
                                <div class="col-sm-9">
                                    <select name="tag_id" class="form-control">
                                        <?php
                                        foreach ($tags as $tag) {
                                            echo '<option value="' . $tag['id'] .'">' . $tag['tag'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">Post Body</label>
                                <div class="col-sm-9">
                                    <textarea name="body" rows="5" class="form-control"><?php echo $row['body']?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <input type="reset" class="btn btn-danger" name="reset" value="Reset" />
                                    <input type="submit" class="btn btn-info" name="submit" value="Submit" />
                                </div>
                                <label class="col-sm-8"><?php echo $success . ' ' . $tagsuccess?></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>ID: <?php echo $row['id'] ?> Title: <?php echo $row['title'] ?></h2>
                <p><?php echo $row['body'] ?></p>
                <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" role="form">
                    <input hidden name="delete_id" value="<?php echo $row['id']?>">
                    <input type="button" class="btn btn-info" name="edit" data-toggle="modal" data-target="#editModal<?php echo $row['id'] ?>" value="Edit Post" />
                    <input type="submit" class="btn btn-danger" name="delete" value="Delete" />
                </form>
            </div>
        </div>
        <?php
    }
    ?>
</div>
</body>

</html>

