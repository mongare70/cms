<?php include "includes/header.php"; ?>
<?php
	//echo password_hash('secret', PASSWORD_BCRYPT, array('cost'=> 10));
	//echo loggedInUserId();

	if(userLikedThisPost(51)){
		echo "user liked this post";
	} else {
		echo "user did not like this post";
	}
	exit;
?>