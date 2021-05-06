# CMS
# This is a simple CMS system which uses PHP as the server side language.
# The architectural style used in this project is the CRUD.
# The user can create posts, other users can create comments for the posts, other users can also like the posts etc.

# The MySQL statements used for this project are as follows:

  # CREATE DATABASE cms;
  # CREATE TABLE categories (cat_id int(3) NOT NULL AUTO_INCREMENT, cat_title varchar(255), PRIMARY KEY (cat_id));
  # CREATE TABLE comments (comment_id int(3) NOT NULL AUTO_INCREMENT, comment_post_id int(3), comment_author varchar(255), comment_email varchar(255), comment_content varchar(255), comment_status varchar(255), comment_date date, PRIMARY KEY (comment_id));
  # CREATE TABLE likes (id int(11) NOT NULL AUTO_INCREMENT, user_id int(11), post_id int(11), PRIMARY KEY (id));
  # CREATE TABLE posts (post_id int(3) NOT NULL AUTO_INCREMENT, post_category_id int(3), post_title varchar(255), post_author varchar(255), post_user varchar(255), post_date date, post_image text, post_content varchar(255), post_tags text, post_comment_count varchar(11), post_status varchar(255), post_views_count int(11), likes int(11), PRIMARY KEY (post_id));
  # CREATE TABLE users (user_id int(3) NOT NULL AUTO_INCREMENT, user_firstname varchar(255), user_lastname varchar(255), user_role varchar(255), username varchar(255), user_image text, user_email varchar(255), user_password varchar(255), user_date date, randsalt varchar(255) DEFAULT '$2y$10$anexamplestringforsalt', token text, PRIMARY KEY (user_id));
  # CREATE TABLE users_online (id int(11) NOT NULL AUTO_INCREMENT, session varchar(255), time int(11), PRIMARY KEY (id));
