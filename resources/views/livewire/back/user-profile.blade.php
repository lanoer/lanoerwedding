<div>
    <div class="">
        <img src="{{ $user->picture }}" alt="" class="avatar-lg mx-auto img-thumbnail rounded-circle">
        <style>
            .profile {
                position: absolute;
                top: 50px;
                right: 0;
                left: 75px;
            }

            .edit-icon i {
                font-size: 16px;
            }
        </style>
        <div class="profile">
            <a href="#" id="triggerFileUpload">
                <i class="fas fa-pencil-alt text-warning"></i>
            </a>
            <input name="file" type="file" id="changeUserProfilePicture" style="display: none;"
                onchange="this.dispatchEvent(new InputEvent('input'))">
        </div>
    </div>
</div>
