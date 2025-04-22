<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="d-flex align-items-center min-vh-100">
                <div class="w-100 d-block card shadow-lg rounded my-5 overflow-hidden">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center w-75 mx-auto auth-logo mb-4">
                                    <a class='logo-dark' href='#'>
                                        <span><img src="{{ asset('logo/temp_logo.png') }}" alt=""
                                                height="32"></span>
                                    </a>

                                    <a class='logo-light' href='#'>
                                        <span><img src="{{ asset('logo/temp_logo.png') }}" alt=""
                                                height="32"></span>
                                    </a>
                                </div>
                                <h1 class="h5 mb-1">Welcome Back!</h1>
                                <p class="text-muted mb-4">Enter your username and password to proceed.</p>
                                <form wire:submit="submit">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="emailaddress">Username</label>
                                        <input class="form-control" type="text" id="emailaddress"
                                            placeholder="Enter your username" wire:model='username'>
                                        <br>
                                        @error('username')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <a class='text-muted float-end' href='pages-recoverpw.html'><small></small></a>
                                        <label class="form-label" for="password">Password</label>
                                        <input class="form-control" type="password" id="password"
                                            placeholder="Enter your password" wire:model="password">
                                        <br>
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="">
                                            <input class="form-check-input" type="checkbox" id="checkbox-signin">
                                            <label class="form-check-label ms-2" for="checkbox-signin">Remember
                                                me</label>
                                        </div>
                                    </div>


                                    <div class="form-group mb-0 text-center">
                                        <button class="btn w-100" type="submit" wire:loading.attr="disabled"
                                            wire:loading.class="btn-secondary"
                                            style="background-color: #843ce0; color: white;">
                                            <span wire:loading.remove>Log In</span>
                                            <span wire:loading>Please wait...</span>
                                        </button>
                                    </div>

                                </form>
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <p class="text-muted mb-2">
                                            <a class='text-muted font-weight-medium ms-1'
                                                href="{{ route('client.password-recovery') }}">Forgot your
                                                password?</a>
                                        </p>
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
