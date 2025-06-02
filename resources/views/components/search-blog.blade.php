<div>
    <style>
        #search-button {
            color: #fff;
            border: none;
            cursor: pointer;
        }



        .spinner {
            display: none;
        }
    </style>
    <div class="pwe-sidebar-block pwe-sidebar-block-search">
        <form method="get" action="{{ route('blog.search') }}" id="search-form" class="pwe-sidebar-search-form">
            <input type="search" name="query" class="form-control search-field" id="search" placeholder="Search..."
                required>
            <button type="submit" id="search-button" class="ti-arrow-right pwe-sidebar-search-submit">
                <span class="icon fa fa-search"></span>
                <span class="spinner fa fa-spinner fa-spin"></span>
            </button>
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