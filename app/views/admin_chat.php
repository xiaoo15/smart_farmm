<?php
// File: app/views/admin_chat.php (VERSI LENGKAP & BENAR)
$title = "Live Chat";
include 'templates/header.php';
?>
<div class="admin-wrapper">
    <?php include 'templates/sidebar.php'; ?>
    <main id="main-content" class="d-flex flex-column p-0" style="height: 100vh;">
        <div class="row g-0 flex-grow-1">
            <div class="col-md-4 border-end d-flex flex-column">
                <div class="p-3 border-bottom">
                    <h5 class="mb-0">Pesan Masuk</h5>
                </div>
                <ul class="list-group list-group-flush" id="chat-list" style="overflow-y: auto;">
                    <?php if (isset($chatList) && !empty($chatList)): ?>
                        <?php foreach ($chatList as $chat): ?>
                            <a href="#" class="list-group-item list-group-item-action chat-list-item" data-userid="<?= $chat['id'] ?>" data-username="<?= $chat['username'] ?>">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold"><?= htmlspecialchars($chat['username']) ?></h6>
                                    <?php if ($chat['unread_count'] > 0): ?>
                                        <span class="badge bg-danger rounded-pill"><?= $chat['unread_count'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <small>Klik untuk membuka percakapan</small>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted text-center p-3">Belum ada percakapan.</p>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-8 d-flex flex-column">
                <div id="chat-welcome" class="flex-grow-1 d-flex align-items-center justify-content-center text-muted h-100">
                    <div><i class="fas fa-comments fa-3x mb-3"></i>
                        <p>Pilih percakapan untuk memulai</p>
                    </div>
                </div>
                <div id="chat-box" class="d-none flex-column h-100">
                    <div class="p-3 border-bottom d-flex align-items-center bg-light">
                        <h5 class="mb-0" id="chat-with-username"></h5>
                    </div>
                    <div class="flex-grow-1 p-3" id="chat-messages-container" style="overflow-y: auto;">
                    </div>
                    <div class="p-3 bg-light border-top">
                        <form id="chat-form" autocomplete="off">
                            <input type="hidden" id="receiver-id" name="receiver_id">
                            <div class="input-group">
                                <input type="text" id="message-input" class="form-control" placeholder="Ketik pesan...">
                                <button class="btn btn-primary" type="submit">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .chat-message {
        display: flex;
        margin-bottom: 1rem;
    }

    .chat-message .bubble {
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        max-width: 75%;
    }

    .message-sent {
        justify-content: flex-end;
    }

    .message-sent .bubble {
        background-color: var(--color-primary);
        color: white;
    }

    .message-received {
        justify-content: flex-start;
    }

    .message-received .bubble {
        background-color: var(--border-color);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let activeUserId = null;
        let chatInterval = null;

        const chatListItems = document.querySelectorAll('.chat-list-item');
        const chatWelcome = document.getElementById('chat-welcome');
        const chatBox = document.getElementById('chat-box');
        const chatWithUsername = document.getElementById('chat-with-username');
        const chatMessagesContainer = document.getElementById('chat-messages-container');
        const chatForm = document.getElementById('chat-form');
        const receiverIdInput = document.getElementById('receiver-id');
        const messageInput = document.getElementById('message-input');

        chatListItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                chatListItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                activeUserId = this.dataset.userid;
                const username = this.dataset.username;

                chatWelcome.classList.add('d-none');
                chatBox.classList.remove('d-none');
                chatBox.classList.add('d-flex');

                chatWithUsername.textContent = username;
                receiverIdInput.value = activeUserId;
                messageInput.focus();

                if (chatInterval) clearInterval(chatInterval);
                loadMessages();
                chatInterval = setInterval(loadMessages, 3000);
            });
        });

        async function loadMessages() {
            if (!activeUserId) return;
            const response = await fetch(`../index.php?action=getMessages&with_id=${activeUserId}`);
            const messages = await response.json();

            chatMessagesContainer.innerHTML = '';
            messages.forEach(msg => {
                const messageWrapper = document.createElement('div');
                messageWrapper.classList.add('chat-message');

                const bubble = document.createElement('div');
                bubble.textContent = msg.message;
                bubble.classList.add('bubble');

                if (msg.sender_id == activeUserId) {
                    messageWrapper.classList.add('message-received');
                } else {
                    messageWrapper.classList.add('message-sent');
                }
                messageWrapper.appendChild(bubble);
                chatMessagesContainer.appendChild(messageWrapper);
            });
            chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
        }

        chatForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const message = messageInput.value;
            if (!message.trim()) return;

            const formData = new FormData();
            formData.append('receiver_id', receiverIdInput.value);
            formData.append('message', message);

            await fetch('../index.php?action=sendMessage', {
                method: 'POST',
                body: formData
            });

            messageInput.value = '';
            loadMessages();
        });
    });
</script>
<?php include 'templates/footer.php'; ?>