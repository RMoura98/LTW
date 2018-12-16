<?php

    include_once('./connection.php');
    /**
     * Verifies if a certain username, password combination
     * exists in the database. Use the sha1 hashing function.
     */
    function checkUserPassword($username, $password) {
        global $db;
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        return $user !== false && password_verify($password, $user['password']);
    }
    /**
     * insere um user na base de dados
     */
    function insertUser($username, $password, $name, $email, $profilePicUrl) {
        global $db;
        $options = ['cost' => 12];
        $stmt = $db->prepare('INSERT INTO users VALUES(?, ?, ?, ?, ?)');
        $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT, $options), $name, $email, $profilePicUrl));
    }

    function insertComment($username, $text, $postId) {
        global $db;
        $now = time();
        $stmt = $db->prepare('INSERT INTO comments VALUES(NULL,?, ?, ? ,?,0,0)');
        $stmt->execute(array($postId,$username, $now, $text));

        $stmt = $db->prepare('update news set count = count + 1 where id = ?'); //rever isso
        $stmt->execute(array($postId));

    }
    function insertReply($username, $text, $commId) {
        global $db;
        $now = time();
        $stmt = $db->prepare('INSERT INTO reply VALUES(NULL,?, ?, ? ,?,0,0)');
        $stmt->execute(array($commId,$username, $now, $text));

        $stmt = $db->prepare('select * from comments where id = ?');
        $stmt->execute(array($commId));
        $res = $stmt->fetch();

        $stmt = $db->prepare('update news set count = count + 1 where id = ?'); //rever isso
        $stmt->execute(array($res['news_id']));
    }

    function insertPost($title, $tags, $username, $text, $picUrl) {
        global $db;
        $now = time();
        $stmt = $db->prepare('INSERT INTO news VALUES (NULL, ?, ?, ?, ?, ?, ?,0,0,0)');
        $stmt->execute(array($title,$now,$tags, $username, $picUrl, $text));

        $stmt2 = $db->prepare('SELECT last_insert_rowid()');
        $stmt2->execute();
        return $stmt2->fetch()['last_insert_rowid()'];
    }

    function comparePasswords($username, $oldPassword) {
        global $db;
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        return password_verify($oldPassword, $user['password']);
    }   
    function changePassword($username, $newPassword, $oldPassword) {
        global $db;
        $options = ['cost' => 12];
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if(password_verify($oldPassword, $user['password'])){
            $stmt = $db->prepare('update users set password = ? where username = ?');
            $stmt->execute(array(password_hash($newPassword, PASSWORD_DEFAULT, $options), $username));  
        }
    }   
    function changeImg($username, $newImgUrl) {
        global $db;
        $stmt = $db->prepare('update users set profImgUrl = ? where username = ?');
        $stmt->execute(array($newImgUrl, $username));
    }   
    function changeRealName($username, $newRealName) {
        global $db;
        $stmt = $db->prepare('update users set name = ? where username = ?');
        $stmt->execute(array($newRealName, $username));
    }   
    function changeEmail($username, $newEmail) {
        global $db;
        $stmt = $db->prepare('update users set email = ? where username = ?');
        $stmt->execute(array($newEmail, $username));
    }   
    function getAllUsernames() {
        global $db;
        $stmt = $db->prepare('SELECT * from users');
        $stmt->execute();
        return $stmt->fetchAll();
    }   

    function getUser($username) {
        global $db;
        $stmt = $db->prepare('SELECT * from users WHERE  users.username = ?');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }   

    function getProfPicFromUsername($username) {
        global $db;
        $stmt = $db->prepare('SELECT profImgUrl from users where username = ?');
        $stmt->execute(array($username));
        return $stmt->fetchAll();
    }   

    
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

    function getOpinionUserNews($newsId, $username) {
        global $db;
        $stmt = $db->prepare('
        select * from userlikenews where news_id = ? and username = ?
        ');
        $stmt->execute(array($newsId, $username));
        return $stmt->fetchAll();
    }

    function setOpinionUserNews($newsId, $username, $upvote, $dv) {
        $opinion = getOpinionUserNews($newsId, $username);
        global $db;

        $stmt1 = $db->prepare('
        UPDATE news SET upvotes = upvotes + ?, downvotes = downvotes + ? WHERE id = ?
        ');
        $stmt1->execute(array($upvote, $dv, $newsId));

        if($dv == -1) {
            $dv  = '0';
        }
        if($upvote == -1){
            $upvote = '0';
        }
        
            
        if(!$opinion){
            $stmt2 = $db->prepare('
            INSERT INTO userlikenews VALUES (NULL, ?, ?, ?, ?)
            ');
            $stmt2->execute(array($username, $newsId, $upvote, $dv ));
        }
        else {
            $stmt3 = $db->prepare('
            UPDATE userlikenews SET upvote = ?, downvote = ? WHERE username = ? and news_id = ?
            ');
            $stmt3->execute(array($upvote, $dv , $username, $newsId));
        }
    }

    function getOpinionUserComments($commId, $username) {
        global $db;
        $stmt = $db->prepare('
        select * from userlikecomments where comment_id = ? and username = ?
        ');
        $stmt->execute(array($commId, $username));
        return $stmt->fetchAll();
    }

    function setOpinionUserComments($commId, $username, $upvote, $dv) {
        $opinion = getOpinionUserComments($commId, $username);
        global $db;

        print_r(':D');

        $stmt1 = $db->prepare('
        UPDATE comments SET upvotes = upvotes + ?, downvotes = downvotes + ? WHERE id = ?
        ');
        $stmt1->execute(array($upvote, $dv, $commId));

        if($dv == -1) {
            $dv  = '0';
        }
        if($upvote == -1){
            $upvote = '0';
        }
        
            
        if(!$opinion){
            $stmt2 = $db->prepare('
            INSERT INTO userlikecomments VALUES (NULL, ?, ?, ?, ?)
            ');
            $stmt2->execute(array($username, $commId, $upvote, $dv ));
        }
        else {
            $stmt3 = $db->prepare('
            UPDATE userlikecomments SET upvote = ?, downvote = ? WHERE username = ? and comment_id = ?
            ');
            $stmt3->execute(array($upvote, $dv , $username, $commId));
        }
    }

    function getOpinionUserReplys($replyId, $username) {
        global $db;
        $stmt = $db->prepare('
        select * from userlikereply where reply_id = ? and username = ?
        ');
        $stmt->execute(array($replyId, $username));
        return $stmt->fetchAll();
    }

    function setOpinionUserReplys($replyId, $username, $upvote, $dv) {
        $opinion = getOpinionUserReplys($replyId, $username);
        global $db;

        print_r($username);

        $stmt1 = $db->prepare('
        UPDATE reply SET upvotes = upvotes + ?, downvotes = downvotes + ? WHERE id = ?
        ');
        $stmt1->execute(array($upvote, $dv, $replyId));

        if($dv == -1) {
            $dv  = '0';
        }
        if($upvote == -1){
            $upvote = '0';
        }
        
            
        if(!$opinion){
            $stmt2 = $db->prepare('
            INSERT INTO userlikereply VALUES (NULL, ?, ?, ?, ?)
            ');
            $stmt2->execute(array($username, $replyId, $upvote, $dv ));
        }
        else {
            $stmt3 = $db->prepare('
            UPDATE userlikereply SET upvote = ?, downvote = ? WHERE username = ? and reply_id = ?
            ');
            $stmt3->execute(array($upvote, $dv , $username, $replyId));
        }
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

    function getTopPostDay(){
        global $db;
        $now = time();
        $stmt = $db->prepare('select * from news where ? - published < 86400 order by (upvotes-downvotes) desc limit 1');
        $stmt->execute(array($now));
        return $stmt->fetch();
    }

    function getTopPostWeek(){
        global $db;
        $now = time();
        $stmt = $db->prepare('select * from news where ? - published < 604800 order by  (upvotes-downvotes) desc limit 1');
        $stmt->execute(array($now));
        return $stmt->fetch();
    }

    function getTopPostMonth(){
        global $db;
        $now = time();
        $stmt = $db->prepare('select * from news where ? - published < 2592000 order by  (upvotes-downvotes) desc limit 1');
        $stmt->execute(array($now));
        return $stmt->fetch();
    }

    function getPostsLikedByUser($username){
        global $db;
        $stmt = $db->prepare('select * from news, userlikenews where userlikenews.news_id = news.id and userlikenews.upvote = 1 and userlikenews.username = ? order by published desc');
        $stmt->execute(array($username));
        return $stmt->fetchAll();
    }

    function getPostsCreatedByUser($username){
        global $db;
        $stmt = $db->prepare('select * from news where username = ? order by published desc');
        $stmt->execute(array($username));
        return $stmt->fetchAll();
    }

    function getCommentsByNewId($id) {
        global $db;
        $stmt = $db->prepare('SELECT * FROM comments JOIN users USING (username) WHERE news_id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    function getAllNewsLike($substring){
        global $db;
        $param = "%{$substring}%";
        $stmt = $db->prepare('select * from news where title like ? order by published desc;');
        $stmt->execute(array($param));
        return $stmt->fetchAll();
    }



?>