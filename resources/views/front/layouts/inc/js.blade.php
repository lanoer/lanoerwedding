<!-- jQuery -->
<script src="{{ asset('front/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('front/assets/js/modernizr-2.6.2.min.js') }}"></script>
<script src="{{ asset('front/assets/js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('front/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/assets/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('front/assets/js/jquery.flexslider-min.js') }}"></script>
<script src="{{ asset('front/assets/js/sticky-kit.min.js') }}"></script>
<script src="{{ asset('front/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('front/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front/assets/js/main.js') }}"></script>
<script>
    const chatBox = document.getElementById("whatsapp-chat");

    //  window.addEventListener("DOMContentLoaded", () => {
    //      chatBox.classList.add("show");
    //  });

     function toggleChat() {
         chatBox.classList.toggle("show");
     }

     // Send message to WhatsApp
     document.getElementById("send-btn").onclick = function() {
         const message = document.getElementById("chat-message").value;
         const phone = '{{ webInfo()->web_telp }}';
         const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
         this.href = url;
     };
</script>



@stack('js')
<script src="//unpkg.com/alpinejs" defer></script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@livewireScripts
</div>
</body>

</html>