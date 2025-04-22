<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="d-flex align-items-center min-vh-100">
                <div class="w-100 d-block card shadow-lg rounded my-5 overflow-hidden">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center w-75 mx-auto auth-logo mb-4">
                                    <a class='logo-dark' href='index.html'>
                                        <span><img src="{{ asset('logo/temp_logo.png') }}" alt=""
                                                height="32"></span>
                                    </a>
                                    <a class='logo-light' href='index.html'>
                                        <span><img src="{{ asset('logo/temp_logo.png') }}" alt=""
                                                height="32"></span>
                                    </a>
                                </div>
                                <h1 class="h5 mb-1">Reset Password</h1>
                                <p class="text-muted mb-4">Enter your email address and we'll send you an email
                                    with instructions to reset your password.
                                </p>

                                @if (session()->has('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session()->has('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <form wire:submit.prevent="sendResetLink">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="emailaddress">Email address</label>
                                        <input class="form-control" type="email" id="emailaddress"
                                            placeholder="Enter your email" wire:model="email">
                                        <br>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn w-100" type="submit" wire:loading.attr="disabled"
                                            wire:loading.class="btn-secondary"
                                            style="background-color: #843ce0; color: white;">
                                            <span wire:loading.remove>Recover Password</span>
                                            <span wire:loading>Sending recovery email...</span>
                                        </button>
                                    </div>

                                </form>
                                <div class="row mt-5">
                                    <div class="col-12 text-center">
                                        <p class="text-muted">Already have account? <a
                                                class='text-muted font-weight-medium ms-1'
                                                href='{{ route('client.login') }}'><b>Log In</b></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
