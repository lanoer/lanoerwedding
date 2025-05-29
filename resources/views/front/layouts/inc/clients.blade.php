<div class="clients-section clients">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 owl-carousel owl-theme">
                @foreach (clients() as $client)
                <div class="client-logo">
                    <a href="#"><img src="{{ $client->image }}" alt=""></a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>