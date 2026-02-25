<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification | {{ optional($generalsetting)->name ?? 'YourSiteName' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if($generalsetting && $generalsetting->favicon)
        <link rel="shortcut icon" href="{{ asset($generalsetting->favicon) }}" />
    @endif
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

    <!-- aiz core css -->
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/assets_login/css/vendors.css">
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/assets_login/css/aiz-core.css">

    <style>
        body { font-size: 12px; }
        .dot-bg {
            background-image: radial-gradient(#a583ea4d 1.5px, #0000 0);
            background-size: 20px 20px;
            position: relative;
        }
        .field-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="aiz-main-wrapper d-flex dot-bg">
    <div class="flex-grow-1">
        <div class="h-100 bg-cover bg-center py-5 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-xl-4 mx-auto">
                        <div class="card text-left">
                            <div class="card-body">
                                <div class="mb-5 text-center">
                                    <img src="{{ asset(optional($generalsetting)->dark_logo ?? 'default-logo.png') }}"
                                         class="mw-100 mb-4" height="40">
                                    <h1 class="h3 text-primary mb-0">
                                        {{ optional($generalsetting)->name ?? 'My Website' }}
                                    </h1>
                                    <p>Enter the OTP sent to your email</p>
                                </div>

                                @if(session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                <form method="POST" action="{{ route('password.otp.verify') }}" id="otpForm">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ old('email', session('email')) }}">

                                    <div class="form-group mb-3 text-center">
                                        <label>Enter 6 Digit OTP Code</label>
                                        <div class="d-flex justify-content-center gap-2 mt-2">
                                            @for ($i = 0; $i < 6; $i++)
                                                <input 
                                                    type="text" 
                                                    maxlength="1" 
                                                    pattern="[0-9]" 
                                                    class="form-control otp-box text-center" 
                                                    style="width: 50px; height: 50px; font-size: 18px; margin:0 8px"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g,'')"
                                                >
                                            @endfor
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="verifyBtn">
                                        Verify OTP
                                    </button>
                                </form>

                                <div class="text-center mt-3">
                                    
                                    <span id="countdown" class="text-danger fw-bold"></span><br>
                                    <button id="resendBtn" class="btn btn-link d-none">Resend OTP</button>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}" class="text-reset fs-14">← Back to Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>

<script src="{{asset('public/backEnd/')}}/assets_login/js/vendors.js"></script>
<script src="{{asset('public/backEnd/')}}/assets_login/js/aiz-core.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    const otpInputs = document.querySelectorAll('.otp-box');
const email = "{{ old('email', session('email')) }}";
const countdownEl = document.getElementById('countdown');
const resendBtn = document.getElementById('resendBtn');
const verifyBtn = document.getElementById('verifyBtn');

// ================= OTP Input Handling =================
otpInputs.forEach((input, index) => {

    // Auto-tab
    input.addEventListener('input', () => {
        if(input.value.length > 0 && index < otpInputs.length - 1) {
            otpInputs[index + 1].focus();
        }
        checkOtpAjax(); // Validate on input
    });

    // Backspace
    input.addEventListener('keydown', (e) => {
        if(e.key === "Backspace" && !input.value && index > 0) {
            otpInputs[index - 1].focus();
        }
    });

    // Paste
    input.addEventListener('paste', (e) => {
        e.preventDefault();
        const pasteData = (e.clipboardData || window.clipboardData).getData('text');
        if(/^\d{6}$/.test(pasteData)){
            otpInputs.forEach((inp, i) => inp.value = pasteData[i]);
            checkOtpAjax(); // Validate after paste
        }
    });
});

// ================= Form Submit =================
document.querySelector('#otpForm').addEventListener('submit', function(e){
    const otpValue = Array.from(otpInputs).map(i => i.value).join('');
    const hiddenOtp = document.createElement('input');
    hiddenOtp.type = 'hidden';
    hiddenOtp.name = 'otp';
    hiddenOtp.value = otpValue;
    this.appendChild(hiddenOtp);
    otpInputs.forEach(input => input.removeAttribute('name'));
});

// ================= AJAX OTP Validation =================
function checkOtpAjax() {
    const otpValue = Array.from(otpInputs).map(i => i.value).join('');
    if(otpValue.length < 6){
        otpInputs.forEach(i => {
            i.style.borderColor = '';
            i.style.color = '';
        });
        return;
    }

    $.ajax({
        url: "{{ route('password.otp.validate_ajax') }}",
        type: "POST",
        data: {
            email: email,
            otp: otpValue,
            _token: "{{ csrf_token() }}"
        },
        success: function(response){
            if(response.valid){
                otpInputs.forEach(i => {
                    i.style.borderColor = 'green';
                    i.style.color = 'green';
                });
            } else {
                otpInputs.forEach(i => {
                    i.style.borderColor = 'red';
                    i.style.color = 'red';
                });
            }
        },
        error: function(){
            console.error("OTP validation failed");
        }
    });
}

// ================= Countdown =================
function updateCountdown(){
    $.ajax({
        url: "{{ route('password.otp.get_expiry') }}",
        type: "GET",
        data: { email: email },
        success: function(data){
            if(data.otp_expires_at){
                const now = new Date().getTime();
                const expiry = new Date(data.otp_expires_at).getTime();
                const distance = expiry - now;

                if(distance > 0){
                    const minutes = Math.floor(distance / 60000);
                    const seconds = Math.floor((distance % 60000) / 1000);
                    countdownEl.textContent = `OTP expires in ${minutes}:${seconds < 10 ? '0'+seconds : seconds}`;
                    verifyBtn.disabled = false;
                    resendBtn.classList.add('d-none');
                } else {
                    countdownEl.textContent = "OTP expired!";
                    verifyBtn.disabled = true;
                    resendBtn.classList.remove('d-none');
                    otpInputs.forEach(i => i.style.borderColor = '');
                }
            } else {
                countdownEl.textContent = "";
                verifyBtn.disabled = true;
                resendBtn.classList.remove('d-none');
            }
        },
        error: function(){ console.error("Could not fetch OTP expiry"); }
    });
}

// Initial fetch & interval (1 second)
updateCountdown();
setInterval(updateCountdown, 1000);

// ================= Resend OTP =================
resendBtn.addEventListener('click', function(){
    $.ajax({
        url: "{{ route('password.otp.resend') }}",
        type: "POST",
        data: { email: email, _token: "{{ csrf_token() }}" },
        success: function(data){
            alert(data.message);
            verifyBtn.disabled = false;
            resendBtn.classList.add('d-none');
            updateCountdown(); // নতুন countdown
        },
        error: function(){
            alert("Could not resend OTP. Try again.");
        }
    });
});

</script>



</body>
</html>
