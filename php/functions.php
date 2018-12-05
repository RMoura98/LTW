<?php

include_once('./connection.php');

function getAllNews() {
    global $db;
    $stmt = $db->prepare('
    SELECT news.*, users.*, COUNT(comments.id) AS comments
    FROM news JOIN
        users USING (username) LEFT JOIN
        comments ON comments.news_id = news.id
    GROUP BY news.id, users.username
    ORDER BY published DESC
    ');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAllNewsSortedBylikes() {
    global $db;
    $stmt = $db->prepare('
    SELECT news.*, users.*, COUNT(comments.id) AS comments
    FROM news JOIN
        users USING (username) LEFT JOIN
        comments ON comments.news_id = news.id
    GROUP BY news.id, users.username
    ORDER BY upvotes DESC
    ');
    $stmt->execute();
    return $stmt->fetchAll();
}
function getAllNewsSortedByControversial() {
    global $db;
    $stmt = $db->prepare('
    SELECT news.*, users.*, COUNT(comments.id) AS comments
    FROM news JOIN
        users USING (username) LEFT JOIN
        comments ON comments.news_id = news.id
    GROUP BY news.id, users.username
    ORDER BY downvotes DESC
    ');
    $stmt->execute();
    return $stmt->fetchAll();
}
function getAllNewsSortedByComments() {
    global $db;
    $stmt = $db->prepare('
    SELECT news.*, users.*, COUNT(comments.id) AS comments
    FROM news JOIN users USING (username) 
    LEFT JOIN comments ON comments.news_id = news.id 
    GROUP BY news.id, users.username 
    ORDER BY news.count DESC
    ');
    $stmt->execute();
    return $stmt->fetchAll();
}


function getCommentsFromNewsId($newsId) {
    global $db;
    $stmt = $db->prepare('select * from comments where news_id = ? ORDER BY published DESC');
    $stmt->execute(array($newsId));
    return $stmt->fetchAll();
}

function getReplyFromCommentId($commentId) {
    global $db;
    $stmt = $db->prepare('select * from reply where idc = ? ORDER BY published DESC');
    $stmt->execute(array($commentId));
    return $stmt->fetchAll();
}

function getNewsById($id) {
  global $db;
  $stmt = $db->prepare('SELECT * FROM news JOIN users USING (username) WHERE id = ?');
  $stmt->execute(array($id));
  return $stmt->fetch();
}

//very nice --> https://www.sitepoint.com/counting-the-ago-time-how-to-keep-publish-dates-fresh/
define( 'TIMEBEFORE_NOW',         'just now' );
define( 'TIMEBEFORE_MINUTE',      '{num} minute ago' );
define( 'TIMEBEFORE_MINUTES',     '{num} minutes ago' );
define( 'TIMEBEFORE_HOUR',        '{num} hour ago' );
define( 'TIMEBEFORE_HOURS',       '{num} hours ago' );
define( 'TIMEBEFORE_YESTERDAY',   'yesterday' );
define( 'TIMEBEFORE_FORMAT',      '%e %b' );
define( 'TIMEBEFORE_FORMAT_YEAR', '%e %b, %Y' );

function time_ago( $time )
{
    $out    = ''; // what we will print out
    $now    = time(); // current time
    $diff   = $now - $time; // difference between the current and the provided dates

    if( $diff < 60 ) // it happened now
        return TIMEBEFORE_NOW;

    elseif( $diff < 3600 ) // it happened X minutes ago
        return str_replace( '{num}', ( $out = round( $diff / 60 ) ), $out == 1 ? TIMEBEFORE_MINUTE : TIMEBEFORE_MINUTES );

    elseif( $diff < 3600 * 24 ) // it happened X hours ago
        return str_replace( '{num}', ( $out = round( $diff / 3600 ) ), $out == 1 ? TIMEBEFORE_HOUR : TIMEBEFORE_HOURS );

    elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
        return TIMEBEFORE_YESTERDAY;

    else // falling back on a usual date format as it happened later than yesterday
        return strftime( date( 'Y', $time ) == date( 'Y' ) ? TIMEBEFORE_FORMAT : TIMEBEFORE_FORMAT_YEAR, $time );
}

function getCommentsByNewId($id) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM comments JOIN users USING (username) WHERE news_id = ?');
    $stmt->execute(array($id));
    return $stmt->fetchAll();
  }

/**
 * returns a url from the uploaded image (imgur.com)
 */
function upload_img($filename, $fileSize) {
    /* debug_to_console($img);
    $filename = $img['tmp_name']; */
    $client_id = "58c99d37e158363";
    $handle = fopen($filename, "r");
    $data = fread($handle, $fileSize);
    $pvars   = array('image' => base64_encode($data));
    $timeout = 30;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
    $out = curl_exec($curl);
    curl_close ($curl);
    $pms = json_decode($out,true);
    $url= $pms['data']['link'];
    return $url;
}

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

function getFilePath($filename){
    $filename = substr( $filename ,9, strlen($filename) - 1);
    $filename = substr( $filename, 0, -2);
    return $filename;
} 

function getFileSize($fileSize){
    $fileSize = substr( $fileSize ,8, strlen($fileSize) - 1);
    $fileSize = substr( $fileSize, 0, -1);
    return intval($fileSize);
} 



?>