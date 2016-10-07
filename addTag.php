<html>
<head>
    <title>Admin - Add Tag</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
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
    $tag = $post['tag'];

    $database->query('INSERT INTO tags (id, tag) VALUES (:id, :tag)');
    if($id){
        $database->bind(':id', $id);
    }
    else{
        $database->bind(':id', NULL);
    }
    $database->bind(':tag', $tag);
    $database->execute();
    if($database->lastInsertID()){
        $success = 'Tag Added';
    }
}

?>
<body>

<div class="container">
    <div class="row">
        <h1>Add Tag <a href="admin.php" style="float: right"><button class="btn btn-default"><</button></a></h1>
        <hr>
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" role="form">
        <div class="form-group row">
            <label class="col-sm-2">Specific Tag ID</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="id" placeholder="Tag ID" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Tag Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="tag" placeholder="Tag Name" />
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
