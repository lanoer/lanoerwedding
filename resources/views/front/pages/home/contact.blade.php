@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Contact')

@section('content')
<div id="pwe-main">
    <!-- Banner Title -->
    <div class="banner-container">
        <div class="banner-img"> <img class="banner-img-width" src="{{ asset('front/assets/images/topbanner.jpeg') }}"
                alt=""> </div>
        <div class="banner-head">
            <div class="banner-head-padding banner-head-margin">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12"> <span class="heading-meta">location</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Contact Us</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact -->
    <div class="contact-section pt-0 pb-60">
        <div class="container-fluid">
            <div class="row pb-60">
                <!-- Address -->
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-12 mb-30 animate-box" data-animate-effect="fadeInLeft">
                            <div class="line p-30">
                                <p><i class="ti-location-pin"></i> <b>SUKABUMI</b></p>
                                <p class="mb-0">{{ webInfo()->web_alamat }}
                                    <br>{{ webInfo()->web_address }}
                                </p>
                                <div class="separator"></div>
                                <p class="mb-0">{{ webInfo()->web_telp }}
                                    <br>{{ webInfo()->web_email }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Form -->
                <div class="col-md-6 offset-md-1">
                    <div class="row">
                        <div class="col-md-12 animate-box" data-animate-effect="fadeInLeft">
                            <p>We would like to hear from you</p>


                            <form id="contactForm">
                                @csrf
                                <div id="formAlert" class="mt-3"></div>
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name *">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Email *">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="telp" id="telp" class="form-control" placeholder="Phone *">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="url" id="url" class="form-control"
                                        placeholder="URL (Optional)">
                                </div>
                                <div class="form-group">
                                    <textarea name="pesan" id="pesan" class="form-control" placeholder="Message *"
                                        rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="submitBtn" class="btn  send-message">Send
                                        Message</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
            <!-- Maps -->
            <div class="row">
                <div class="col-md-12">
                    <div class="google-maps">
                        <iframe id="gmap_canvas" src="https://www.google.com/maps/embed?pb={{ webInfo()->web_maps }}"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Clients -->
    <div class="clients-section clients">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 owl-carousel owl-theme">
                    <div class="client-logo">
                        <a href="#"><img src="images/clients/1.jpg" alt=""></a>
                    </div>
                    <div class="client-logo">
                        <a href="#"><img src="images/clients/2.jpg" alt=""></a>
                    </div>
                    <div class="client-logo">
                        <a href="#"><img src="images/clients/3.jpg" alt=""></a>
                    </div>
                    <div class="client-logo">
                        <a href="#"><img src="images/clients/4.jpg" alt=""></a>
                    </div>
                    <div class="client-logo">
                        <a href="#"><img src="images/clients/5.jpg" alt=""></a>
                    </div>
                    <div class="client-logo">
                        <a href="#"><img src="images/clients/6.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('front.layouts.inc.team')
    @include('front.layouts.inc.footer')
</div>

@endsection
@push('css')
<style>
    #formAlert {
        display: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-weight: 500;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.4s ease;
        position: relative;
        margin-bottom: 15px;
    }

    #formAlert.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .alert-success {
        background-color: #d1f5d3;
        color: #155724;
        border: 1px solid #b6e2b8;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    #formAlert::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
    }

    .alert-success::before {
        content: '✔';
        color: #28a745;
    }

    .alert-danger::before {
        content: '✖';
        color: #dc3545;
    }
</style>
@endpush
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertBox = document.getElementById('formAlert');

   function showAlert(message, type = 'success') {
alertBox.innerText = message;
alertBox.className = `alert alert-${type}`;
alertBox.classList.add('show');

// Pastikan tampil
alertBox.style.display = 'block';

// Sembunyikan setelah 4 detik
setTimeout(() => {
alertBox.classList.remove('show');
// Tunggu animasi selesai, lalu benar-benar hilangkan dari layout
setTimeout(() => {
alertBox.style.display = 'none';
}, 400);
}, 4000);
}

    function validateForm() {
        const name = form.name.value.trim();
        const email = form.email.value.trim();
        const telp = form.telp.value.trim();
        const pesan = form.pesan.value.trim();

        if (!name || !email || !telp || !pesan) {
            showAlert('Please fill in all required fields.', 'danger');
            return false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showAlert('Invalid email format.', 'danger');
            return false;
        }


        const phoneRegex = /^(?:\+62|62|0)8[1-9][0-9]{7,10}$/;
        if (!phoneRegex.test(telp)) {
        showAlert('Nomor telepon tidak valid. Gunakan format Indonesia yang benar.', 'danger');
        return false;
        }

        return true;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateForm()) return;

        submitBtn.disabled = true;
        const formData = new FormData(form);

        fetch("{{ route('contact.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert('Your message has been sent!', 'success');
                form.reset();
            } else {
                showAlert(data.message || 'Failed to send message.', 'danger');
            }
        })
        .catch(err => {
            console.error(err);
            showAlert('An error occurred while sending the message.', 'danger');
        })
        .finally(() => {
            submitBtn.disabled = false;
        });
    });
});
</script>
@endpush