 <!-- Start:: Cash VOuchers -->
 <div class="grid grid-cols-12 gap-6">
     <div class="col-span-12">
         <div class="box custom-box">
             <div class="box-header justify-between">
                 <div class="box-title">
                     Cash Vouchers Table
                 </div>

             </div>
             <div class="box-body space-y-3">
                 <div class="flex justify-between">
                     <div class="download-data">
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-csv">
                             CSV</button>
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-json">
                             JSON</button>
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-xlsx">
                             XLSX</button>
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-pdf">
                             PDF</button>
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-html">
                             HTML</button>
                     </div>
                     <div>
                         <div class="relative">
                             <input wire:model.live.debounce.300ms="search" type="text"
                                 id="hs-search-box-with-loading-1" name="hs-search-box-with-loading-1"
                                 class="ti-form-input rounded-sm ps-11 focus:z-10" placeholder="Input search">
                             <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                 <div wire:loading
                                     class="animate-spin inline-block w-4 h-4 border-[3px] border-current border-t-transparent text-primary rounded-full"
                                     role="status" aria-label="loading">
                                     <span class="sr-only">Loading...</span>
                                 </div>
                                 <svg wire:loading.remove class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                     <path
                                         d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                 </svg>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="table-responsive">
                     <table class="table whitespace-nowrap table-bordered min-w-full">
                         <thead>
                             <tr class="border-b border-defaultborder">
                                 <th scope="col" class="text-start">Id</th>
                                 <th scope="col" class="text-start">Voucher Name</th>
                                 <th scope="col" class="text-start">Password</th>
                                 <th scope="col" class="text-start">Mikrotik Name</th>
                                 <th scope="col" class="text-start">Data Limit</th>
                                 <th scope="col" class="text-start">Time Limit</th>
                                 <th scope="col" class="text-start">Profile</th>
                                 <th scope="col" class="text-start">Server</th>
                                 <th scope="col" class="text-start">Price</th>
                                 <th scope="col" class="text-start">Status</th>
                                 <th scope="col" class="text-start">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             @if ($cashVouchers->isEmpty())
                                 <tr class="border-b border-defaultborder">
                                     <td colspan="13" class="text-center py-4">
                                         <p>No Cash Vouchers found.</p>
                                     </td>
                                 </tr>
                             @else
                                 @foreach ($cashVouchers as $cashVoucher)
                                     <tr wire:key="{{ $cashVoucher->id }}" class="border-b border-defaultborder">
                                         <td>{{ $loop->iteration + ($cashVouchers->currentPage() - 1) * $cashVouchers->perPage() }}
                                         </td>
                                         <td>{{ $cashVoucher->username }}</td>
                                         <td>{{ $cashVoucher->password }}</td>
                                         <td>{{ $cashVoucher->username }}</td>
                                         <td>{{ $cashVoucher->data_limit == null ? 'Unlimited' : $this->formatDataLimit($cashVoucher->data_limit) }}
                                         </td>
                                         <td>{{ $this->formatTimeLimit($cashVoucher->time_limit) }}</td>
                                         <td>{{ $cashVoucher->profile }}</td>
                                         <td>{{ $cashVoucher->server }}</td>
                                         <td>{{ $cashVoucher->price }}</td>
                                         <td>
                                             @if ($cashVoucher->is_sold == 0)
                                                 <span class="badge bg-success/10 text-success">Unsold</span>
                                             @elseif ($cashVoucher->is_sold == 1)
                                                 <span class="badge bg-danger text-dark">sold</span>
                                             @endif
                                         </td>
                                         <td>
                                             <div class="hstack flex gap-2 flex-wrap">
                                                 @if ($cashVoucher->is_sold == 0)
                                                     <button wire:click="markAsSold({{ $cashVoucher->id }})"
                                                         aria-label="anchor"
                                                         class=" !gap-0 !m-0 !h-auto !w-auto text-[0.8rem] bg-info/10 text-info hover:bg-info hover:text-white hover:border-info p-1 rounded-md">Mark
                                                         as Sold</button>
                                                 @else
                                                     <button aria-label="anchor"
                                                         class=" !gap-0 !m-0 !h-auto !w-auto text-[0.8rem] bg-info/10 cursor-not-allowed hover:border-info p-1 rounded-md text-textmuted">Mark
                                                         as Sold</button>
                                                 @endif
                                                 <button wire:click="warn({{ $cashVoucher->id }})" aria-label="anchor"
                                                     class=" !gap-0 !m-0 !h-auto !w-auto text-[0.875rem] bg-danger/10 text-danger hover:bg-danger hover:text-white hover:border-danger p-1 rounded-md leading-none">
                                                     <i class="ri-delete-bin-5-line"></i></button>

                                             </div>
                                         </td>
                                     </tr>
                                 @endforeach
                             @endif
                         </tbody>
                     </table>
                 </div>
                 <div class="py-4 px-3">
                     <div class="flex ">
                         <div class="flex space-x-4 items-center mb-3">
                             <label class="w-32 text-sm font-medium ">Per Page</label>
                             <select wire:model.live.debounce.200ms="perPage"
                                 class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                 @if ($totalCashVouchers > 10)
                                     <option value="10">10</option>
                                 @endif

                                 @if ($totalCashVouchers > 20)
                                     <option value="20">20</option>
                                 @endif

                                 @if ($totalCashVouchers > 50)
                                     <option value="50">50</option>
                                 @endif

                                 @if ($totalCashVouchers > 100)
                                     <option value="100">100</option>
                                 @endif

                                 <option value="{{ $totalCashVouchers }}">
                                     {{ $totalCashVouchers <= 100 ? 'Show All' : '100+' }}
                                 </option>
                             </select>
                         </div>
                     </div>
                     {{ $cashVouchers->links() }}
                 </div>

             </div>
             <x-modal maxWidth="3xl" preventModalClose=true>
                 @slot('slot')
                     @if ($markAsSoldId)
                         <livewire:admins.hotspot.cash.modals.mark-as-sold :id="$markAsSoldId" />
                     @elseif ($deletingId)
                         <livewire:admins.components.modals.delete-item :title="'Delete Cash Hotspot Voucher'" :message="'Are you sure you want to delete Cash Hotspot Voucher id ' . $deletingId"
                             :eventToBeDispatched="'delete-cash-voucher'" :cancelEvent="'cancel-delete-cash-voucher'" :list="[]" lazy />
                     @endif
                 @endslot
             </x-modal>
         </div>
     </div>
 </div>
 {{-- End of Cash Vouchers --}}
