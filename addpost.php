<html>
<head>
    <title>Admin - Add Post</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
    <script>
        var recipe = {
            title : "Molé",
            serving : 2,
            ingredients : ["cinnamon","cumin","cocoa"]
        };
        console.log(recipe.title);
        console.log(recipe.serving);
        console.log(recipe.ingredients);
    </script>
</head>
<?php
include "includes.php";

$database = new databaseCon;

$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

//if(@$_POST['delete']){
//    $delete_id = $_POST['delete_id'];
//    $database->query('DELETE FROM posts WHERE id = :id');
//    $database->bind(':id', $delete_id);
//    $database->execute();
//}
//
//if(@$post['update']){
//    $id = $post['id'];
//    $title = $post['title'];
//    $body = $post['body'];
//
//    $database->query('UPDATE posts SET title = :title, body = :body');
//    $database->bind(':title', $title);
//    $database->bind(':body', $body);
//    $database->execute();
//}

if($post['submit']){
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $author_id = $post['author_id'];
    $tag_id = $post['tag_id'];

    $database->query('INSERT INTO blogposts (id, title, body, author_id, timestamp) VALUES (:id, :title, :body, :author_id, CURRENT_TIMESTAMP)');
    if($id){
        $database->bind(':id', $id);
    }
    else{
        $database->bind(':id', NULL);
    }
    $database->bind(':title', $title);
    $database->bind(':body', $body);
    $database->bind(':author_id', $author_id);
    $database->execute();
    if($database->lastInsertID()){
        $success = 'Post Added.';
    }

    $database->query('INSERT INTO blogPost_tags (tagCol_id, post_id, tag_id) VALUES (:tagCol_id, :post_id, :tag_id)');
    $database->bind(':tagCol_id', NULL);
    if($id){
        $database->bind(':post_id', $id);
    }
    else{
        $database->bind(':post_id', $database->lastInsertID());
    }
    $database->bind(':tag_id', $tag_id);
    $database->execute();
    if($database->lastInsertID()){
        $tagsuccess = ' Tag Assigned.';
    }
}

$database->query('SELECT * FROM people');
$authors = $database->resultSet();

$database->query('SELECT * FROM tags');
$tags = $database->resultSet();

?>
<body>
<div class="container">
    <div class="row">
        <h1>Add Posts <a href="admin.php" style="float: right"><button class="btn btn-default"><</button></a></h1>
        <hr>
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" role="form">
            <div class="form-group row">
                <label class="col-sm-2">Specific ID</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="id" placeholder="Post ID" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2">Post Title</label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" placeholder="Add a Title..." />
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
                    <textarea name="body" rows="5" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <input type="reset" class="btn btn-danger" name="reset" value="Reset" />
                    <input type="submit" class="btn btn-info" name="submit" value="Submit" />
                </div>
                <label class="col-sm-10"><?php echo $success . ' ' . $tagsuccess?></label>
            </div>
        </form>
    </div>
</div>
</body>
</html>
