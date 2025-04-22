 <div class="grid grid-cols-12 gap-6">
     <div class="xl:col-span-12 col-span-12">
         <div class="box">
             <div class="box-header justify-between">
                 <div class="box-title">
                     Add Bulk Users
                 </div>
             </div>
             <div class="box-body">
                 <div class="box-body space-y-4">
                     <div class="space-y-4">
                         <h3>Guidelines</h3>
                         <ol class="space-y-2">
                             <li>
                                 1. Only accept CSV files.
                             </li>
                             <li>
                                 2. Maximum file size is 3MB.
                             </li>
                             <li>
                                 3. Drag and drop CSV or click to select multiple files.
                             </li>
                         </ol>
                     </div>
                     @if (session()->has('error'))
                         <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="alert alert-danger"
                             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                             {{ session('error') }}
                             <button type="button" class="btn-close" data-bs-dismiss="alert"
                                 aria-label="Close"></button>
                         </div>
                     @elseif (session()->has('success'))
                         <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="alert alert-success"
                             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                             {{ session('success') }}
                             <button type="button" class="btn-close" data-bs-dismiss="alert"
                                 aria-label="Close"></button>
                         </div>
                     @endif

                     <form wire:submit.prevent="importMikrotiks" class="flex flex-col sm:flex-row items-center gap-4">
                         <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                             x-on:livewire-upload-finish="uploading = false"
                             x-on:livewire-upload-cancel="uploading = false"
                             x-on:livewire-upload-error="uploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress" class="w-full sm:w-auto">
                             <input type="file" wire:model="mikrotikFile" accept=".csv,.xlsx"
                                 class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/80">

                             @error('mikrotikFile')
                                 <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                             @enderror

                             <div x-show="uploading" class="mt-2">
                                 <progress max="100" x-bind:value="progress"
                                     class="w-full h-2 rounded overflow-hidden"></progress>
                                 <span class="text-xs text-gray-600">Uploading... <span
                                         x-text="progress + '%'"></span></span>
                             </div>
                         </div>

                         <button type="submit" class="ti-btn ti-btn-primary ti-btn-loader btn-wave w-full sm:w-auto"
                             wire:loading.attr="disabled" wire:target="importMikrotiks">
                             <span wire:loading.remove wire:target="importMikrotiks">Add Mikrotiks</span>
                             <span wire:loading wire:target="importMikrotiks">Adding Mikrotiks...</span>
                             <span wire:loading wire:target="importMikrotiks" class="ml-2">
                                 <i class="ri-loader-2-fill animate-spin"></i>
                             </span>
                         </button>
                     </form>

                     <form wire:submit.prevent="importCustomers" class="flex flex-col sm:flex-row items-center gap-4">
                         <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                             x-on:livewire-upload-finish="uploading = false"
                             x-on:livewire-upload-cancel="uploading = false"
                             x-on:livewire-upload-error="uploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress" class="w-full sm:w-auto">
                             <input type="file" wire:model="customersFile" accept=".csv,.xlsx"
                                 class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/80">

                             @error('customersFile')
                                 <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                             @enderror

                             <div x-show="uploading" class="mt-2">
                                 <progress max="100" x-bind:value="progress"
                                     class="w-full h-2 rounded overflow-hidden"></progress>
                                 <span class="text-xs text-gray-600">Uploading... <span
                                         x-text="progress + '%'"></span></span>
                             </div>
                         </div>

                         <button type="submit" class="ti-btn ti-btn-primary ti-btn-loader btn-wave w-full sm:w-auto"
                             wire:loading.attr="disabled" wire:target="importCustomers">
                             <span wire:loading.remove wire:target="importCustomers">Add Customers</span>
                             <span wire:loading wire:target="importCustomers">Adding Customers...</span>
                             <span wire:loading wire:target="importCustomers" class="ml-2">
                                 <i class="ri-loader-2-fill animate-spin"></i>
                             </span>
                         </button>
                     </form>

                     <form wire:submit.prevent="importTransactions"
                         class="flex flex-col sm:flex-row items-center gap-4">
                         <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                             x-on:livewire-upload-finish="uploading = false"
                             x-on:livewire-upload-cancel="uploading = false"
                             x-on:livewire-upload-error="uploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress" class="w-full sm:w-auto">
                             <input type="file" wire:model="transactionsFile" accept=".csv,.xlsx"
                                 class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/80">

                             @error('transactionsFile')
                                 <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                             @enderror

                             <div x-show="uploading" class="mt-2">
                                 <progress max="100" x-bind:value="progress"
                                     class="w-full h-2 rounded overflow-hidden"></progress>
                                 <span class="text-xs text-gray-600">Uploading... <span
                                         x-text="progress + '%'"></span></span>
                             </div>
                         </div>

                         <button type="submit" class="ti-btn ti-btn-primary ti-btn-loader btn-wave w-full sm:w-auto"
                             wire:loading.attr="disabled" wire:target="importTransactions">
                             <span wire:loading.remove wire:target="importTransactions">Add Transactions</span>
                             <span wire:loading wire:target="importTransactions">Adding Transactions...</span>
                             <span wire:loading wire:target="importTransactions" class="ml-2">
                                 <i class="ri-loader-2-fill animate-spin"></i>
                             </span>
                         </button>
                     </form>

                     <form wire:submit.prevent="importSms" class="flex flex-col sm:flex-row items-center gap-4">
                         <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                             x-on:livewire-upload-finish="uploading = false"
                             x-on:livewire-upload-cancel="uploading = false"
                             x-on:livewire-upload-error="uploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress"
                             class="w-full sm:w-auto">
                             <input type="file" wire:model="smsFile" accept=".csv,.xlsx"
                                 class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/80">

                             @error('smsFile')
                                 <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                             @enderror

                             <div x-show="uploading" class="mt-2">
                                 <progress max="100" x-bind:value="progress"
                                     class="w-full h-2 rounded overflow-hidden"></progress>
                                 <span class="text-xs text-gray-600">Uploading... <span
                                         x-text="progress + '%'"></span></span>
                             </div>
                         </div>

                         <button type="submit" class="ti-btn ti-btn-primary ti-btn-loader btn-wave w-full sm:w-auto"
                             wire:loading.attr="disabled" wire:target="importSms">
                             <span wire:loading.remove wire:target="importSms">Add SMS</span>
                             <span wire:loading wire:target="importSms">Adding SMS...</span>
                             <span wire:loading wire:target="importSms" class="ml-2">
                                 <i class="ri-loader-2-fill animate-spin"></i>
                             </span>
                         </button>
                     </form>


                 </div>
             </div>
         </div>
     </div>
 </div>
