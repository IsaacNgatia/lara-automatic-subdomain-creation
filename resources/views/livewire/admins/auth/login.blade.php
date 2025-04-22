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
                <form wire:submit="submit">
                    <div class="box shadow-2xl rounded-lg">
                        <div class="box-body !p-[3rem]">
                            @if ($title && $title !== '')
                                <p class="h3 font-semibold mb-2 text-center">{{ $title }}</p>
                            @else
                                <p class="h5 font-semibold mb-2 text-center">Log In</p>
                            @endif

                            <p class="mb-4 text-[#8c9097] dark:text-white/50 opacity-[0.7] font-normal text-center">
                                Welcome
                                back</p>

                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="grid grid-cols-12">
                                <div class="xl:col-span-12 col-span-12 mb-3">
                                    <label for="signin-email" class="form-label text-default">Email</label>
                                    <input type="text" class="form-control form-control-lg w-full !rounded-md"
                                        id="signin-email" placeholder="Email" wire:model="email">

                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="xl:col-span-12 col-span-12 mb-3">
                                    <label for="signin-password" class="form-label text-default block">Password<a
                                            href="{{ route('admin.password-recovery') }}"
                                            class="ltr:float-right rtl:float-left text-danger">Forget password
                                            ?</a></label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control !border-s border-defaultborder dark:border-defaultborder/10 form-control-lg !rounded-s-md"
                                            id="signin-password" placeholder="password" wire:model="password">
                                        <button aria-label="button" class="ti-btn ti-btn-light !rounded-s-none !mb-0"
                                            type="button" onclick="createpassword('signin-password',this)"
                                            id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check !ps-0">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="defaultCheck1">
                                            <label
                                                class="form-check-label text-[#8c9097] dark:text-white/50 font-normal"
                                                for="defaultCheck1">
                                                Remember password ?
                                            </label>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="xl:col-span-12 col-span-12 grid mt-2">
                                    <button type="submit"
                                        class="ti-btn ti-btn-primary !bg-primary btn-wave !text-white !font-medium"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove>Log In</span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                    {{-- <button type="submit"
                                        class="ti-btn ti-btn-primary !bg-primary btn-wave !text-white !font-medium"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove>Log In</span>
                                        <span wire:loading>
                                            <i class="ri-loader-4-line animate-spin"></i>
                                        </span>
                                    </button> --}}
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
