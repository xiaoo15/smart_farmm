<?php
// File: app/models/Chat.php (FILE BARU)
class Chat {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function sendMessage($sender_id, $receiver_id, $message) {
        $stmt = $this->conn->prepare("INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
        return $stmt->execute();
    }

    public function getMessages($user1_id, $user2_id) {
        $stmt = $this->conn->prepare("
            SELECT * FROM chat_messages 
            WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
            ORDER BY timestamp ASC
        ");
        $stmt->bind_param("iiii", $user1_id, $user2_id, $user2_id, $user1_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getChatListForAdmin() {
        $query = "
            SELECT u.id, u.username, 
                   (SELECT COUNT(*) FROM chat_messages cm WHERE cm.sender_id = u.id AND cm.is_read = 0 AND cm.receiver_id = 1) as unread_count
            FROM users u
            WHERE u.is_admin = 0
        ";
        $result = mysqli_query($this->conn, $query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function markAsRead($sender_id, $receiver_id) {
        $stmt = $this->conn->prepare("UPDATE chat_messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ?");
        $stmt->bind_param("ii", $sender_id, $receiver_id);
        return $stmt->execute();
    }
}