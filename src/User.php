<?php

require_once 'config.php';

//
//CREATE TABLE users (
//id int AUTO_INCREMENT,
// username varchar(255) NOT NULL,
// hashedPassword varchar(60) NOT NULL,
// email varchar(255) UNIQUE NOT NULL,
// PRIMARY KEY(id)
//)

class User {

    private $id;
    private $username;
    private $hashedPassword;
    private $email;

    public function __construct() {
        $this->id = -1;
        $this->username = "";
        $this->email = "";
        $this->hashedPassword = "";
    }

    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getHashedPassword() {
        return $this->hashedPassword;
    }
    
    function getId() {
        return $this->id;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    
    

    public function setPassword($newPassword) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $this->hashedPassword = $newHashedPassword;
    }

    public function saveToDB(mysqli $connection) {
        if ($this->id == -1) {
            // Saving new user to DB

            $sql = "INSERT INTO Users(username, email, hashed_password) VALUES ('$this->username', '$this->email', '$this->hashedPassword')";

            $result = $connection->query($sql);
            var_dump($result);

            if ($result == true) {
                $this->id = $connection->insert_id;
                echo "dochodze 1";
                return true;
            } else {
                echo "dochodze 2";
                return false;
            }
        } else {
            $sql = "UPDATE Users SET username='$this->username',
                            email='$this->email',
                            hashed_password='$this->hashedPassword'
                            WHERE user_id=$this->id";

            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }

    static public function loadUserById(mysqli $connection, $id) {
        $sql = "SELECT * FROM Users WHERE user_id=$id";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->id = $row['user_id'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            $loadedUser->email = $row['email'];


            return $loadedUser;
        }
        return null;
    }

    static public function LoadUserByEmail(mysqli $connection, $email){
        $sql = "SELECT * FROM Users WHERE email='$email'";

        $result = $connection->query($sql);
   
        if ($result == true && $result->num_rows == 1) {
            echo "dochodze";
            $row = $result->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->id = $row['user_id'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashedPassword = $row['hashed_Password'];
            $loadedUser->email = $row['email'];

            return $loadedUser;
        }
        return null;
    }
    
    static public function loadAllUsers(mysqli $connection) {
        $sql = "SELECT * FROM Users";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['user_id'];
                $loadedUser->username = $row['username'];
                $loadedUser->hashedPassword = $row['hashed_password'];
                $loadedUser->email = $row['email'];

                $ret[] = $loadedUser;
            }
        }
        return $ret;
    }

    public function delete(mysqli $connection) {
        if ($this->id != -1) {
            $sql = "DELETE FROM Users WHERE user_id=$this->id";
            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }

}
