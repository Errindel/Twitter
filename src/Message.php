<?php





/*
 * CREATE TABLE `Messages` (
	message_id int AUTO_INCREMENT,
    message text NOT NULL,
    sender_id int NOT NULL,
    receiver_id int NOT NULL,
    PRIMARY KEY(message_id),
    FOREIGN KEY(sender_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY(receiver_id) REFERENCES Users(user_id) ON DELETE CASCADE
)
 * 
 * 
 * 
 * INSERT INTO `Messages` (`message_id`, `message`, `sender_id`, `receiver_id`) VALUES (NULL, 'To jest tekst wiadomości', '153', '155');
 */

/**
 * Description of Message
 *
 * @author adriana
 */
require_once 'config.php';

class Message {
    private $messageId;
    private $senderId;
    private $receiverId;
    private $messageTxt;
    private $status;
    private $date;
    
    function __construct() {
        $this->messageId = -1;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->messageTxt = $messageTxt;
        $this->status = 0;
        $this->date = $date;
    }

    // getery
    function getMessageId() {
        return $this->messageId;
    }

    function getSenderId() {
        return $this->senderId;
    }

    function getReceiverId() {
        return $this->receiverId;
    }

    function getMessageTxt() {
        return $this->messageTxt;
    }

    function getStatus() {
        if($this->status == 0){
            return "Nieprzeczytana";
        } else {
            return "Przeczytana";
        }
    }

    function getDate() {
        return $this->date;
    }

        
    // setery
    function setSenderId($senderId) {
        $this->senderId = $senderId;
        return $this;
    }

    function setReceiverId($receiverId) {
        $this->receiverId = $receiverId;
        return $this;
    }

    function setMessageTxt($messageTxt) {
        $this->messageTxt = $messageTxt;
        return $this;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function saveToDB(mysqli $connection) {
        if ($this->messageId == -1) {
            //Saving new message to DB
            
            $statement = $connection->prepare("INSERT INTO `Messages` (`message`, `sender_id`, `receiver_id`, `status`, `date`) VALUES (?, ?, ?, ?, ?);");

            $statement->bind_param('siiis', $this->messageTxt, $this->senderId, $this->receiverId, $this->status, $this->date);

            if ($statement->execute()) {
                $this->messageId = $statement->insert_id;
                return true;
            } else {
                echo "Error: $statement->error";
            }
            return false;
        } else {
            $sql = "UPDATE `Messages` SET `status`=$this->status WHERE message_id=$this->messageId";

            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }
    
    static public function loadAllMessageByReceiverId(mysqli $connection, $id) {
        $sql = "SELECT * FROM `Messages` WHERE `receiver_id`=$id";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMsgByReceiver = new Message();
                $loadedMsgByReceiver->messageId = $row['message_id'];
                $loadedMsgByReceiver->receiverId = $row['receiver_id'];
                $loadedMsgByReceiver->senderId = $row['sender_id'];
                $loadedMsgByReceiver->messageTxt = $row['message'];
                $loadedMsgByReceiver->date = $row['date'];
                $loadedMsgByReceiver->status = $row['status'];

                $ret[] = $loadedMsgByReceiver;
            }
        }
        return $ret;
    }
    
    static public function loadAllMessagesBySenderId(mysqli $connection, $id) {
        $sql = "SELECT * FROM `Messages` WHERE `sender_id`=$id";

        $result = $connection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMsgBySender = new Message();
                $loadedMsgBySender->messageId = $row['message_id'];
                $loadedMsgBySender->receiverId = $row['receiver_id'];
                $loadedMsgBySender->senderId = $row['sender_id'];
                $loadedMsgBySender->date = $row['date'];
                $loadedMsgBySender->status = $row['status'];

                $ret[] = $loadedMsgBySender;
            }
        }
        return $ret;
    }
    
}
