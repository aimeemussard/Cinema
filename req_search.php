<?php
    
    //count movie search

$count_title = 'SELECT COUNT(*) AS "count" FROM movie_genre INNER JOIN genre ON movie_genre.id_genre = genre.id INNER JOIN movie ON movie_genre.id_movie = movie.id INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE title LIKE "%' . $_POST['search'] . '%";';

    //movie search

$search = 'SELECT movie.title AS "title", genre.name AS "genre", distributor.name AS "distributor" FROM movie_genre INNER JOIN genre ON movie_genre.id_genre = genre.id INNER JOIN movie ON movie_genre.id_movie = movie.id INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE title LIKE "%' . $_POST['search'] . '%" AND genre.name LIKE "' . $_POST['search_genre'] . '" AND distributor.name LIKE "' . $_POST['search_distributor'] . '";';

$search_by_distri = 'SELECT movie.title AS "title", genre.name AS "genre", distributor.name AS "distributor" FROM movie_genre INNER JOIN genre ON movie_genre.id_genre = genre.id INNER JOIN movie ON movie_genre.id_movie = movie.id INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE title LIKE "%' . $_POST['search'] . '%" AND distributor.name LIKE "' . $_POST['search_distributor'] . '";';

$search_by_genre = 'SELECT movie.title AS "title", genre.name AS "genre", distributor.name AS "distributor" FROM movie_genre INNER JOIN genre ON movie_genre.id_genre = genre.id INNER JOIN movie ON movie_genre.id_movie = movie.id INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE title LIKE "%' . $_POST['search'] . '%" AND genre.name LIKE "' . $_POST['search_genre'] . '";';

$search_by_title = 'SELECT movie.title AS "title", genre.name AS "genre", distributor.name AS "distributor" FROM movie_genre INNER JOIN genre ON movie_genre.id_genre = genre.id INNER JOIN movie ON movie_genre.id_movie = movie.id INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE title LIKE "%' . $_POST['search'] . '%" LIMIT :first, :limit;';


//$date = $_POST['search_date'];
//explode(" ", trim($string));


$search_by_date_title = 'SELECT movie.title AS "title", room.name AS "room", movie_schedule.date_begin AS "projection" FROM movie_schedule INNER JOIN movie ON movie_schedule.id_movie = movie.id INNER JOIN room ON movie_schedule.id_room = room.id WHERE movie_schedule.date_begin LIKE "%' . $_POST['search_date'] . '%" AND movie.title LIKE "%' . $_POST['search'] . '%" ORDER BY movie.title;';

$search_by_date_only = 'SELECT movie.title AS "title", room.name AS "room", movie_schedule.date_begin AS "projection" FROM movie_schedule INNER JOIN movie ON movie_schedule.id_movie = movie.id INNER JOIN room ON movie_schedule.id_room = room.id WHERE movie_schedule.date_begin LIKE "%' . $_POST['search_date'] . '%" ORDER BY movie.title;';


    //member search

$fullname = $_POST['search_user'];
$name = explode(" ", trim($fullname));
$count = count($name);
$first_word = $name[0];
$second_word = $name[1];

$search_user_name = 'SELECT CONCAT(user.firstname, " ", user.lastname) AS "name", subscription.name AS "subscription", subscription.description AS "description" FROM membership INNER JOIN user ON membership.id_user = user.id INNER JOIN subscription ON membership.id_subscription = subscription.id WHERE user.firstname = :fullname OR user.lastname = :fullname;';

$search_user_fullname = 'SELECT CONCAT(user.firstname, " ", user.lastname) AS "name", subscription.name AS "subscription", subscription.description AS "description" FROM membership INNER JOIN user ON membership.id_user = user.id INNER JOIN subscription ON membership.id_subscription = subscription.id WHERE (user.firstname = :firstword AND user.lastname = :secondword) OR (user.firstname = :secondword AND user.lastname = :firstword);';

        //user history

$search_history_name = 'SELECT CONCAT(user.firstname," ", user.lastname) AS "name", movie.title AS "title", room.name AS "room", movie_schedule.date_begin AS "projection" FROM membership_log INNER JOIN membership ON membership_log.id_membership = membership.id INNER JOIN user ON membership.id_user = user.id INNER JOIN movie_schedule ON membership_log.id_session = movie_schedule.id INNER JOIN movie ON movie_schedule.id_movie = movie.id INNER JOIN room ON movie_schedule.id_room = room.id WHERE user.firstname = :fullname OR user.lastname = :fullname ORDER BY "projection";';

$search_history_fullname = 'SELECT CONCAT(user.firstname," ", user.lastname) AS "name", movie.title AS "title", room.name AS "room", movie_schedule.date_begin AS "projection" FROM membership_log INNER JOIN membership ON membership_log.id_membership = membership.id INNER JOIN user ON membership.id_user = user.id INNER JOIN movie_schedule ON membership_log.id_session = movie_schedule.id INNER JOIN movie ON movie_schedule.id_movie = movie.id INNER JOIN room ON movie_schedule.id_room = room.id WHERE (user.firstname = :firstword AND user.lastname = :secondword) OR (user.firstname = :secondword AND user.lastname = :firstword) ORDER BY "projection";';

        //update user membership

$search_id_name= 'SELECT membership.id_user AS "id_name" 
FROM `membership`
INNER JOIN user ON membership.id_user = user.id
WHERE CONCAT(user.firstname," ", user.lastname) LIKE "'.$_POST['update_name'].'";';

$update_sub = 'UPDATE `membership`
SET id_subscription = '.$id.'
WHERE id_user = '.$id_name.';';

    //add movie schedule

$add_schedule = '';

$search_by_date = 'SELECT movie.title AS "title", room.name AS "room", movie_schedule.date_begin AS "projection" FROM `movie_schedule` INNER JOIN movie ON movie_schedule.id_movie = movie.id INNER JOIN room ON movie_schedule.id_room = room.id WHERE title LIKE "%' . $_POST['search_prog'] . '%" LIMIT :first, :limit;';

?>