<style>
    .cta-animate-btn {
        transition: transform 0.2s, box-shadow 0.2s;
        animation: pulse 2s infinite;
    }

    .cta-animate-btn:hover {
        transform: scale(1.07);
        box-shadow: 0 4px 20px rgba(162, 120, 58, 0.3);
        animation: none;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(162, 120, 58, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(162, 120, 58, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(162, 120, 58, 0);
        }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center align-items-center" style="height: 150px;">
            <a href="https://wa.me/{{ webInfo()->web_telp }}" target="_blank" class="btn cta-animate-btn"
                style="background-color: #a2783a; color: #fff; border: none; font-size: 1.2rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 24 24"
                    style="margin-right: 8px;">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.031-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.447-.52.151-.174.2-.298.3-.497.099-.198.05-.372-.025-.521-.075-.149-.669-1.611-.916-2.206-.242-.579-.487-.5-.669-.51-.173-.007-.372-.009-.571-.009-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.099 3.2 5.077 4.363.709.306 1.262.489 1.694.626.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.413-.074-.124-.272-.198-.57-.347zm-5.421 7.617h-.001a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.999-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.455 4.436-9.89 9.893-9.89 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.995c-.003 5.455-4.438 9.89-9.895 9.89zm8.413-18.306A11.815 11.815 0 0012.05 0C5.495 0 .06 5.435.058 12.086c0 2.13.557 4.213 1.615 6.044L.057 24l6.064-1.616a11.88 11.88 0 005.929 1.515h.005c6.554 0 11.989-5.435 11.991-12.086a11.86 11.86 0 00-3.501-8.382z" />
                </svg>
                Hubungi Kami!
            </a>
        </div>
    </div>
</div>