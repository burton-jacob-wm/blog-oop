<html>
<head>
    <title>Admin - Add Author</title>
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
    $first_name = $post['first_name'];
    $last_name = $post['last_name'];
    $url = $post['url'];
    $email = $post['email'];

    $database->query('INSERT INTO people (id, first_name, last_name, url, email) VALUES (:id, :first_name, :last_name, :url, :email)');
    $database->bind(':id', $id);
    $database->bind(':first_name', $first_name);
    $database->bind(':last_name', $last_name);
    $database->bind(':url', $url);
    $database->bind(':email', $email);
    $database->execute();
    if($database->lastInsertID()){
        $success = 'Author Added.';
    }
}

?>
<body>
<div class="container">
    <div class="row">
        <h1>Add Author <a href="admin.php" style="float: right"><button class="btn btn-default"><</button></a></h1>
        <hr>
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" role="form">
        <div class="form-group row">
            <label class="col-sm-2">Specific Author ID</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="id" placeholder="Author ID" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">First Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="id" placeholder="First Name" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Last Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="id" placeholder="Last Name" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Author's URL</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="id" placeholder="URL" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Author's Email</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="id" placeholder="Email" />
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
