 <!-- JAVASCRIPT -->
 <script src="/back/assets/vendor/jquery/jquery-3.6.0.min.js"></script>
 <script src="/back/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script src="/back/assets/libs/metismenu/metisMenu.min.js"></script>
 <script src="/back/assets/libs/simplebar/simplebar.min.js"></script>
 <script src="/back/assets/libs/node-waves/waves.min.js"></script>
 <script src="/back/assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
 <script src="/back/assets/vendor/jquery-ui-1.13.2/jquery-ui.min.js"></script>
 <script src="/back/assets/vendor/amsify/jquery.amsify.suggestags.js"></script>

 <script src="/back/assets/vendor/ijaboCropTool/ijaboCropTool.min.js"></script>
 <script src="/back/assets/vendor/ijabo/ijabo.min.js"></script>
 <script src="/back/assets/vendor/ijaboViewer/jquery.ijaboViewer.min.js"></script>
 <script src="/back/assets/js/app.js"></script>
 @stack('scripts')
 @livewireScripts
 <script>
     $(document).ready(function() {
         $('input[name="post_tags"]').amsifySuggestags({
             type: 'amsify'
         });
     });
     $(document).ready(function() {
         $('input[name="service_tags"]').amsifySuggestags({
             type: 'amsify'
         });
     });

     window.addEventListener('showToastr', function(event) {
         toastr.remove();
         if (event.detail.type === 'info') {
             toastr.info(event.detail.message);
         } else if (event.detail.type === 'success') {
             toastr.success(event.detail.message);
         } else if (event.detail.type === 'warning') {
             toastr.warning(event.detail.message);
         } else if (event.detail.type === 'error') {
             toastr.error(event.detail.message);
         } else {
             return false;
         }


     });
 </script>

 </body>

 </html>
