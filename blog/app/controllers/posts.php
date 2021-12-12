<?php

include(ROOT_PATH . "/app/database/db.php");

include(ROOT_PATH . "/app/helpers/validatePost.php");

$topics = selectAll('topics');
$table = 'posts';
$posts = selectAll($table);
$errors = array();
$title ="";
$title = "";
$topic_id = "";
$published = "";

if(isset($_POST['add-post'])){
    // ss($_FILES['image']['name']);
    $errors = validatePost($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
           $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Failed to upload image");
        }
    } else {
       array_push($errors, "Post image required");
    }


    

    if (count($errors) === 0) {
        unset($_POST['add-post']);

        $_POST['user_id'] = 1;
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['body'] = htmlentities($_POST['body']);
        $post_id = create($table, $_POST);
        $_SESSION['message'] = "Post Created Successfully";
        $_SESSION['type'] = "success";
        // ss($post_id);
        header("location: " . BASE_URL . "admin/posts/index.php");

    } else{

        $title = $_POST['title'];
        $title = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
    }



}

?>
