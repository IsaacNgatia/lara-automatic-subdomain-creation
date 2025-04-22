<div class="container">
    <div
        class="flex justify-center authentication authentication-basic items-center h-full text-defaultsize text-defaulttextcolor">
        <div class="grid grid-cols-12">
            <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-3 sm:col-span-2"></div>
            <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-6 sm:col-span-8 col-span-12">
                <div class="my-[2.5rem] flex justify-center">
                    <a>
                        <img src="{{ asset('logo/temp_logo.png') }}" alt="logo" height="80">
                    </a>
                </div>

                <form wire:submit.prevent="resetPassword">
                    <div class="box">
                        <div class="box-body !p-[3rem]">
                            <p class="h5 font-semibold mb-2 text-center">Reset Password</p>
                            <div class="grid grid-cols-12">
                                <div class="xl:col-span-12 col-span-12 mb-3">
                                    <label for="reset-newpassword" class="form-label text-default">Email</label>
                                    <div class="input-group">
                                        <input type="email" wire:model="email"
                                            class="form-control form-control-lg !border-s border-defaultborder dark:border-defaultborder/10 !rounded-e-none"
                                            placeholder="New password" value="{{ $email ?? old('email') }}" />
                                    </div>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="xl:col-span-12 col-span-12 mb-3">
                                    <label for="reset-newpassword" class="form-label text-default">New Password</label>
                                    <div class="input-group">
                                        <input type="password" wire:model="password"
                                            class="form-control form-control-lg !border-s border-defaultborder dark:border-defaultborder/10 !rounded-e-none"
                                            id="reset-newpassword" placeholder="New password">
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="xl:col-span-12 col-span-12 mb-3">
                                    <label for="reset-confirmpassword" class="form-label text-default ">Confirm
                                        Password</label>
                                    <div class="input-group">
                                        <input type="password" wire:model="password_confirmation"
                                            class="form-control form-control-lg !border-s border-defaultborder dark:border-defaultborder/10 !rounded-e-none"
                                            id="reset-confirmpassword" placeholder="Confirm password">
                                    </div>
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="xl:col-span-12 col-span-12 grid">
                                    <button type="submit"
                                        class=" ti-btn ti-btn-primary !bg-primary btn-wave !text-white !font-medium"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove>Reset
                                            Password</span>
                                        <span wire:loading>Resetting Password...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-3 sm:col-span-2"></div>
        </div>
    </div>
</div>
