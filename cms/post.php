<?php require('includes/header.php'); ?>

    <!-- Navigation -->
    <?php require('includes/navigation.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <?php

                    if (isset($_GET['p_id'])) {
                        $the_post_id = $_GET['p_id'];
                    }

                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";

                    $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                        ?>                    

                        <!-- First Blog Post -->
                        <h2>
                            <a href="#"><?php echo $post_title; ?></a>
                        </h2>

                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author; ?></a>
                        </p>

                        <p>
                            <span class="glyphicon glyphicon-time">
                                
                            </span> 
                            Posted on <?php echo $post_date; ?>
                        </p>

                        <hr>

                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="image" style="width: 100%;">

                        <hr>

                        <p>
                            <?php echo $post_content; ?>
                        </p>

                        <hr>

                        <?php
                    }

                ?>

                <!-- Blog Comments -->

                <?php

                if (isset($_POST['create_comment'])) {

                    $the_post_id = $_GET['p_id'];

                    $comment_author = utf8_decode($_POST['comment_author']);
                    $comment_email = utf8_decode($_POST['comment_email']);
                    $comment_content = utf8_decode($_POST['comment_content']);

                    $query = "INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) 
                    VALUES (NULL, $the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now());";

                    $create_comment_query = mysqli_query($connection, $query);

                    if (!$create_comment_query) {
                        die('QUERY FAILED' . mysqli_error($connection));
                    }

                }

                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">


                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" name="comment_author" id="author" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="comment_email" id="email" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content" id="comment" required maxlength="1000"></textarea>
                        </div>

                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Show Posted Comments -->

                <?php
                    $query = "SELECT * FROM comments 
                        WHERE comment_status = 'approved' 
                        AND comment_post_id = $the_post_id
                        ORDER BY comment_id DESC";

                    $select_all_comments_query = mysqli_query($connection, $query);

                    while ($comment = mysqli_fetch_assoc($select_all_comments_query)) {

                        ?>
                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?= utf8_encode($comment['comment_author']) ?>
                                <br>
                                <small><?= utf8_encode($comment['comment_date']) ?></small>                                    
                                </h4>

                                <p></p><?= utf8_encode($comment['comment_content']) ?></p>
                            </div>
                        </div>
                        <?php
                    }

                ?>                

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php require('includes/sidebar.php'); ?>

        </div>
        <!-- /.row -->

        <hr>

<?php require('includes/footer.php'); ?>