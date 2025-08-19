<?php
// File: app/controllers/ChatController.php (VERSI PERBAIKAN FINAL)

require_once __DIR__ . '/../models/Chat.php';
require_once __DIR__ . '/../models/User.php';

class ChatController {
    
    // Fungsi untuk menampilkan halaman chat di sisi Admin
    public function showChatAdmin() {
        // Pastikan hanya admin yang bisa akses
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ../index.php?action=home');
            exit;
        }

        global $conn;
        $chatModel = new Chat($conn);
        $chatList = $chatModel->getChatListForAdmin();
        include __DIR__ . '/../views/admin_chat.php';
    }

    // API untuk mengirim pesan (dari Admin maupun User)
    public function sendMessageAjax() {
        // JANGAN panggil session_start() di sini, karena sudah dipanggil di index.php
        header('Content-Type: application/json');

        // Cek apakah user sudah login
        if (!isset($_SESSION['user']['id'])) {
            echo json_encode(['success' => false, 'message' => 'Anda harus login untuk mengirim pesan.']);
            exit;
        }
        
        // Cek apakah datanya lengkap
        if (empty($_POST['receiver_id']) || empty($_POST['message'])) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
            exit;
        }

        global $conn;
        $chatModel = new Chat($conn);
        
        $sender_id = $_SESSION['user']['id'];
        $receiver_id = (int)$_POST['receiver_id'];
        $message = trim($_POST['message']);

        if ($chatModel->sendMessage($sender_id, $receiver_id, $message)) {
            echo json_encode(['success' => true, 'message' => 'Pesan terkirim!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengirim pesan ke database.']);
        }
        // Wajib exit setelah mengirim response JSON
        exit;
    }

    // API untuk mengambil riwayat pesan (dari Admin maupun User)
    public function getMessagesAjax() {
        // JANGAN panggil session_start() di sini
        header('Content-Type: application/json');

        if (!isset($_SESSION['user']['id'])) {
            echo json_encode([]);
            exit;
        }
        
        if (empty($_GET['with_id'])) {
            echo json_encode([]);
            exit;
        }

        global $conn;
        $chatModel = new Chat($conn);

        $user1_id = $_SESSION['user']['id'];
        $user2_id = (int)$_GET['with_id'];

        // Tandai pesan dari lawan bicara sudah dibaca oleh kita
        $chatModel->markAsRead($user2_id, $user1_id);

        $messages = $chatModel->getMessages($user1_id, $user2_id);
        echo json_encode($messages);
        exit;
    }
}