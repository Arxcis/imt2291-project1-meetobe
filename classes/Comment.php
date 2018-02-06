<?php

class Comment {
    public static function add($db, $userid, $videoid, $comment) {
        $commentid = uniqid(rand(10000,99999), true);

        $sql = "INSERT INTO Comments (commentid, user, video, comment) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        $param = array($commentid, $userid, $videoid, $comment);
        $stmt->execute($param);

        if ($stmt->rowCount() !== 1) {  
            return 0;
        }
        return $commentid;
    }

    public static function delete($db, $commentid) {
        $sql = "DELETE FROM Comments WHERE commentid=?";
        $sth = $db->prepare($sql);
        $param = array($commentid);
        $sth->execute($param);
    }

    public static function get($db, $videoid) {
        $sql = "SELECT commentid ,user, video, comment, time, email 
                FROM Comments 
                INNER JOIN users ON comments.user = users.userid
                WHERE video=(?) ORDER BY time DESC";
        
        $stmt = $db->prepare($sql);
        $param = array($videoid);
        $stmt->execute($param);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}