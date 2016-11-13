<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tweets
 *
 * @author adriana
 */
//
//CREATE TABLE Tweets (
//    tweets_id int AUTO_INCREMENT,
//    user_id int NOT NULL,
//    tweet varchar(140) NOT NULL,
//    creationDate DATE NOT NULL,
//    PRIMARY KEY (tweets_id),
//    FOREIGN KEY (user_id) REFERENCES Users(user_id)
////)
//  id: int, private
//   userId: int, private
//   text: string, private
//   creationDate: date, private



require_once 'config.php';

class Tweet {

    private $tweetId;
    private $userId;
    private $text;
    private $creationDate;

    public function __construct() {
        $this->tweetId = -1;
        $this->userId = "";
        $this->text = "";
        $this->creationDate = "";
    }

    function getTweetId() {
        return $this->tweetId;
    }

    function getUserId() {
        return $this->userId;
    }

    function getText() {
        return $this->text;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    static public function loadTweetById(mysqli $connection, $id) {
        $sql = "SELECT * FROM Tweets WHERE tweet_id=$id";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedTweet = new Tweet();
            $loadedTweet->tweetId = $row['tweet_id'];
            $loadedTweet->userId = $row['user_id'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creationDate'];


            return $loadedTweet;
        }
        return null;
    }

    static public function loadAllTweets(mysqli $connection) {
        $sql = "SELECT * FROM `Tweets` ORDER BY creationDate DESC";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->tweetId = $row['tweet_id'];
                $loadedTweet->userId = $row['user_id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];

                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }

    static public function loadAllTweetsByUserId(mysqli $connection, $id) {
        $sql = "SELECT * FROM Users JOIN Tweets ON Users.user_id=Tweets.user_id WHERE Users.user_id=$id;";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->tweetId = $row['tweet_id'];
                $loadedTweet->userId = $row['user_id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];

                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }

    public function saveToDB(mysqli $connection) {
        if ($this->tweetId == -1) {
            //Saving new tweet to DB
            $statement = $connection->prepare("INSERT INTO Tweets(user_id, text, creationDate) VALUES (?, ?, ?)");

            $statement->bind_param('iss', $this->userId, $this->text, $this->creationDate);

            if ($statement->execute()) {
                $this->tweetId = $statement->insert_id;
                return true;
            } else {
                echo "Error: $statement->error";
            }
            return false;
        }
        return false;
    }

}
