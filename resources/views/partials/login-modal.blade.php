<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: none; border: none;">

            <div class="modal-body">
                <div class="form-content">
                    <p class="auth-title">User Login </p>
                    <form action="{{ route('customer.signin') }}" method="POST" data-parsley-validate="">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required>
                            <label class="phonelabel" for="phone">Phone Number</label>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->

                        <div class="form-group mb-3">
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                value="{{ old('password') }}" required>
                            <label class="passlabel" for="password">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->

                        <a href="{{ route('customer.forgot.password') }}" class="forget-link">
                            <i class="fa-solid fa-unlock"></i> Forget Password?
                        </a>

                        <div class="form-group mb-3">
                            <button class="submit-btn"> Login </button>
                        </div>
                        <!-- col-end -->
                    </form>

                    <div class="register-now no-account">
                        <p>No any account? </p>
                        <a data-bs-toggle="modal" data-bs-target="#signupModal"><i data-feather="edit-3"></i> Sign
                            Up</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>