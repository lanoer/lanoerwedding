<div>
    <style>
        #search-button {
            background: rgb(11, 90, 219);
            color: #fff;
            border: none;
            cursor: pointer;
        }

        #search-button:hover {
            background: rgb(8, 150, 252);
        }

        .spinner {
            display: none;
        }
    </style>
    <div class="sidebar-widget search-box">
        <form method="get" action="{{ route('blog.search') }}" id="search-form">
            <div class="form-group">
                <input type="search" name="query" placeholder="Search..." required="">
                <button type="submit" id="search-button" class="search-button">
                    <span class="icon fa fa-search"></span>
                    <span class="spinner fa fa-spinner fa-spin"></span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scriptsFront')
    <script>
        $(document).ready(function() {
            $('#search-form').on('submit', function() {
                var searchButton = $('#search-button');
                var icon = searchButton.find('.icon');
                var spinner = searchButton.find('.spinner');

                // Change icon to spinner and disable button
                icon.hide();
                spinner.show();
                searchButton.prop('disabled', true);

                // Re-enable button and change spinner back to icon after loading
                $(this).ajaxComplete(function() {
                    spinner.hide();
                    icon.show();
                    searchButton.prop('disabled', false);
                });
            });
        });
    </script>
@endpush
