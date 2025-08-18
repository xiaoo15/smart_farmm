<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'customer'): ?>
    <div id="user-chat-widget">
        <div id="chat-bubble" class="shadow">
            <i class="fas fa-comment-dots"></i>
        </div>
        <div id="chat-popup" class="card shadow-lg d-none">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">Chat dengan Admin</h6>
                <button id="close-chat" type="button" class="btn-close btn-close-white"></button>
            </div>
            <div class="card-body" id="user-chat-messages">
            </div>
            <div class="card-footer">
                <form id="user-chat-form">
                    <div class="input-group">
                        <input type="text" id="user-message-input" class="form-control" placeholder="Ketik pesan..." autocomplete="off">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
    /* CSS untuk Widget Chat User */
    #chat-bubble {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background-color: var(--dark-primary-green);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        cursor: pointer;
        z-index: 1050;
    }

    #chat-popup {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 350px;
        height: 450px;
        z-index: 1050;
        flex-direction: column;
    }

    #chat-popup .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #chat-popup .card-body {
        flex-grow: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    #user-chat-messages .chat-bubble {
        padding: 8px 12px;
        border-radius: 18px;
        margin-bottom: 10px;
        max-width: 80%;
        word-wrap: break-word;
    }

    #user-chat-messages .sent {
        background-color: #e2ffc7;
        align-self: flex-end;
        margin-left: auto;
    }

    #user-chat-messages .received {
        background-color: #f1f0f0;
        align-self: flex-start;
    }
</style>
<script>
    // JavaScript untuk public_footer.php
    document.addEventListener('DOMContentLoaded', function() {
        // ... (kode add to cart biarkan saja)

        // Logika untuk Widget Chat User
        const chatBubble = document.getElementById('chat-bubble');
        const chatPopup = document.getElementById('chat-popup');
        const closeChatBtn = document.getElementById('close-chat');
        const userChatMessages = document.getElementById('user-chat-messages');
        const userChatForm = document.getElementById('user-chat-form');
        const userMessageInput = document.getElementById('user-message-input');
        let userChatInterval = null;
        const adminId = 1; // ID admin utama

        if (chatBubble) {
            chatBubble.addEventListener('click', () => {
                chatPopup.classList.toggle('d-none');
                if (!chatPopup.classList.contains('d-none')) {
                    loadUserMessages();
                    if (userChatInterval) clearInterval(userChatInterval);
                    userChatInterval = setInterval(loadUserMessages, 3000);
                } else {
                    if (userChatInterval) clearInterval(userChatInterval);
                }
            });
        }

        if (closeChatBtn) {
            closeChatBtn.addEventListener('click', () => {
                chatPopup.classList.add('d-none');
                if (userChatInterval) clearInterval(userChatInterval);
            });
        }

        async function loadUserMessages() {
            const response = await fetch(`index.php?action=getMessages&with_id=${adminId}`);
            const messages = await response.json();

            userChatMessages.innerHTML = '';
            messages.forEach(msg => {
                const bubble = document.createElement('div');
                bubble.textContent = msg.message;
                bubble.classList.add('chat-bubble');
                if (msg.sender_id == adminId) {
                    bubble.classList.add('received');
                } else {
                    bubble.classList.add('sent');
                }
                userChatMessages.appendChild(bubble);
            });
            userChatMessages.scrollTop = userChatMessages.scrollHeight;
        }

        if (userChatForm) {
            userChatForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const message = userMessageInput.value;
                if (!message.trim()) return;

                const formData = new FormData();
                formData.append('receiver_id', adminId);
                formData.append('message', message);

                await fetch('index.php?action=sendMessage', {
                    method: 'POST',
                    body: formData
                });

                userMessageInput.value = '';
                loadUserMessages();
            });
        }
    });
</script>
</body>

</html>