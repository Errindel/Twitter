<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author adriana
 */

//CREATE TABLE Comments (
//	comment_id INT AUTO_INCREMENT,
//    tweet_id INT NOT NULL,
//    user_id INT NOT NULL,
//    creation_date DATETIME NOT NULL,
//    comment_text varchar(60) NOT NULL,
//    PRIMARY KEY(comment_id),
//    FOREIGN KEY(tweet_id) REFERENCES Tweets(tweet_id),
//    FOREIGN KEY(user_id) REFERENCES Users(user_id)
//);




require_once 'config.php';

class Comment {

    private $commentId;
    private $userId;
    private $tweetId;
    private $creationDate;
    private $text;

    public function __construct() {
        $this->commentId = -1;
        $this->userId = "";
        $this->tweetId = "";
        $this->creationDate = "";
        $this->text = "";
    }

    function getCommentId() {
        return $this->commentId;
    }

    function getUserId() {
        return $this->userId;
    }

    function getTweetId() {
        return $this->tweetId;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function getText() {
        return $this->text;
    }

    function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
        return $this;
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
        return $this;
    }

    function setText($text) {
        $this->text = $text;
        return $this;
    }

        
    static public function loadCommentById(mysqli $connection, $commentId) {
        $sql = "SELECT * FROM Comments WHERE comment_id=$commentId ORDER BY creation_date DESC";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedComment = new Comment();
            $loadedComment->commentId = $row['comment_id'];
            $loadedComment->userId = $row['user_id'];
            $loadedComment->tweetId = $row['tweet_id'];
            $loadedComment->text = $row['comment_text'];
            $loadedComment->creationDate = $row['creation_date'];


            return $loadedComment;
        }
        return null;
    }
    static public function loadAllCommentByTweetId(mysqli $connection, $tweetId) {
        $sql = "SELECT * FROM Comments WHERE tweet_id=$tweetId ORDER BY creation_date DESC";

        $result = $connection->query($sql);
       
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedComment = new Comment();
                $loadedComment->commentId = $row['comment_id'];
                $loadedComment->userId = $row['user_id'];
                $loadedComment->tweetId = $row['tweet_id'];
                $loadedComment->text = $row['comment_text'];
                $loadedComment->creationDate = $row['creation_date'];

                $ret[] = $loadedComment;
            }              
        }
        return $ret;
    }
    

    static public function loadAllCommentsByUserId(mysqli $connection, $userId) {
        $sql = "SELECT * FROM Users JOIN Comments ON Users.user_id=Comments.user_id WHERE Users.user_id=$userId;";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedComment = new Comment();
                $loadedComment->commentId = $row['comment_id'];
                $loadedComment->userId = $row['user_id'];
                $loadedComment->tweetId = $row['tweet_id'];
                $loadedComment->text = $row['comment_text'];
                $loadedComment->creationDate = $row['creation_date'];

                $ret[] = $loadedComment;
            }              
        }
        return $ret;
        
    }

    public function saveToDB(mysqli $connection) {
        if ($this->commentId == -1) {
        //Saving new tweet to DB
            
            $statement = $connection->prepare("INSERT INTO Comments(tweet_id, user_id, comment_text, creation_date) VALUES (?, ?, ?, ?)");
            
            $statement->bind_param('iiss', $this->tweetId, $this->userId, $this->text, $this->creationDate);
            
            if ($statement->execute()) {
                $this->commentId = $statement->insert_id;
                return true;
            }
        }
        return false;
    }

}
