 <table class="table table-bordered table-hover">
     <thead>
         <th>Id</th>
         <th>Username</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Email</th>
         <th>Image</th>
         <th>Role</th>
         <th>Date</th>
         <th>Admin</th>
         <th>Subscriber</th>
         <th>Edit</th>
         <th>Delete</th>
     </thead>
     <tbody>
        <?php
            $query = "SELECT * FROM users";
            $users = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($users)){
                $user_id = $row['user_id'];
                $username = $row['username'];
                $firstname = $row['user_firstname'];
                $lastname = $row['user_lastname'];
                $email = $row['user_email'];
                $image = $row['user_image'];
                $role = $row['user_role'];
                $user_date = $row['user_date'];

                echo "<tr>";
                echo "<td>{$user_id}</td>";
                echo "<td>{$username}</td>";
                echo "<td>{$firstname}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td>{$email}</td>";
                echo "<td><img width='100' src='../images/user_images/$image' alt='image'></td>";
                echo "<td>{$role}</td>";
                echo "<td>{$user_date}</td>";
                
                
                
//                $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
//                $select_categories_id = mysqli_query($connection, $query);
//
//                while($row = mysqli_fetch_assoc($select_categories_id)){
//                    $cat_id = $row['cat_id'];
//                    $cat_title = $row['cat_title']; 
//                
//                echo "<td>{$cat_title}</td>";
//                }
                
                
                
//                $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
//                $select_post_id_query = mysqli_query($connection, $query);
//                while($row = mysqli_fetch_assoc($select_post_id_query)){
//                    $post_id = $row['post_id'];
//                    $post_title = $row['post_title'];
//                        
//                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
//                    
//                }
                
               
                echo "<td><a href='users.php?change_to_admin=$user_id'>Admin</a></td>";
                echo "<td><a href='users.php?change_to_sub=$user_id'>Subscriber</a></td>";
                echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
                echo "<td><a href='users.php?delete=$user_id'>Delete</a></td>";
                echo "</tr>";
            }
         ?>
     </tbody>
</table>

<?php
    
     if(isset($_GET['change_to_admin'])){
        $the_user_id = $_GET['change_to_admin'];
        $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = {$the_user_id} ";
        $change_to_admin_query = mysqli_query($connection, $query);
        confirmQuery($change_to_admin_query);
        header("Location: users.php"); //Function to refresh the page
    }

    
    if(isset($_GET['change_to_sub'])){
        $the_user_id = $_GET['change_to_sub'];
        $query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id = {$the_user_id} ";
        $change_to_sub_query = mysqli_query($connection, $query);
        confirmQuery($change_to_sub_query);
        header("Location: users.php"); //Function to refresh the page
    }

    if(isset($_GET['delete'])){
        $the_user_id = $_GET['delete'];
        $query = "DELETE FROM users WHERE user_id = {$the_user_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: users.php"); //Function to refresh the page
    }
?>