<div class="col-span-12 md:col-span-6 xxl:!col-span-4">
    <div class="box">
        <div class="box-header">
            <h5 class="box-title">Profile</h5>
        </div>
        <div class="box-body">
          <div class="border-b-2 border-gray-200 dark:border-white/10">
            <nav class="-mb-0.5 flex space-x-6 rtl:space-x-reverse" role="tablist">
              <a class="hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor  dark:text-[#8c9097] dark:text-white/50 hover:text-primary active" href="javascript:void(0);" id="underline-item-1" data-hs-tab="#underline-1" aria-controls="underline-1">
                Profile
              </a>
              <a class="hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor  dark:text-[#8c9097] dark:text-white/50 hover:text-primary" href="javascript:void(0);" id="underline-item-2" data-hs-tab="#underline-2" aria-controls="underline-2">
               Security
              </a>
            </nav>
          </div>

          <div class="mt-3">
            <div id="underline-1" role="tabpanel" aria-labelledby="underline-item-1">
                <div class="grid grid-cols-12 gap-x-6">
                    <div class="xxl:col-span-4 xl:col-span-12 col-span-12">
                        <div class="box overflow-hidden">
                            <div class="box-body !p-0">
                                <form wire:submit="updateProfile">
                                    <div class="box-body">
                                        <div class="mb-4">
                                            <label for="form-text" class="form-label !text-[.875rem] text-black">Full Name</label>
                                            <input type="text" class="form-control" id="form-text" placeholder=""
                                                wire:model="official_name">
                                        </div>
                                        <div class="mb-4">
                                            <label for="house-number" class="form-label text-[.875rem] text-black">House Number</label>
                                            <input type="text" class="form-control" id="house-number" placeholder=""
                                                wire:model="house_number">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email" class="form-label text-[.875rem] text-black">Email</label>
                                            <input type="email" class="form-control" id="email" placeholder=""
                                                wire:model="email">
                                        </div>
                                        <div class="mb-4">
                                            <label for="phone-number" class="form-label text-[.875rem] text-black">Phone Number</label>
                                            <input type="text" class="form-control" id="phone-number" placeholder=""
                                                wire:model="phone_number">
                                        </div>
                                        <div class="mb-4">
                                            <label for="monthly-bill" class="form-label text-[.875rem] text-black">Monthly Bill</label>
                                            <input type="number" class="form-control" id="monthly-bill" placeholder=""
                                                wire:model="monthly_bill">
                                        </div>
                                        <div class="mb-4">
                                            <label for="status" class="form-label text-[.875rem] text-black">Status</label>
                                            <input type="text" class="form-control" id="status" placeholder=""
                                                wire:model="status">
                                        </div>
                                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                                            type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                                            <span wire:loading.remove>Update</span>
                                            <span wire:loading>Updating Profile...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="underline-2" class="hidden" role="tabpanel" aria-labelledby="underline-item-2">
                <div class="grid grid-cols-12 gap-x-6">
                    <div class="xxl:col-span-4 xl:col-span-12 col-span-12">
                        <div class="box overflow-hidden">
                            <div class="box-body !p-0">
                                <form wire:submit="updateProfile">
                                    <div class="box-body">
                                        <div class="mb-4">
                                            <label for="form-text" class="form-label !text-[.875rem] text-black">Current Password</label>
                                            <input type="text" class="form-control" id="form-text" placeholder=""
                                                wire:model="current_password">
                                        </div>
                                        <div class="mb-4">
                                            <label for="house-number" class="form-label text-[.875rem] text-black">New Password</label>
                                            <input type="text" class="form-control" id="house-number" placeholder=""
                                                wire:model="password">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email" class="form-label text-[.875rem] text-black">Confirm Password</label>
                                            <input type="email" class="form-control" id="email" placeholder=""
                                                wire:model="confirma_password">
                                        </div>
                                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                                            type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                                            <span wire:loading.remove>Update</span>
                                            <span wire:loading>Updating Password...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>