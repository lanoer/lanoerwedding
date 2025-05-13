<!-- Floating WhatsApp Chat -->
<div id="whatsapp-chat" class="show">
    <div class="header">
        <span>Obrolan Dengan Lanoer</span>
        <span class="close" onclick="toggleChat()">×</span>
    </div>
    <div class="chat-body">
        <div class="bot-message">Hi, Apakah ada yang bisa saya bantu?</div>
        <div class="input-wrapper">
            <input type="text" id="chat-message" placeholder="Ketik pesan..." />
            <a id="send-btn" target="_blank" title="Kirim Pesan">
                <svg width="18" height="18" fill="white" viewBox="0 0 24 24">
                    <path d="M2 21l21-9L2 3v7l15 2-15 2z" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Button -->
<div id="whatsapp-button" onclick="toggleChat()">
    <img src="{{ asset('front/assets/images/whatsapp.svg') }}" alt="WhatsApp" />
</div>
