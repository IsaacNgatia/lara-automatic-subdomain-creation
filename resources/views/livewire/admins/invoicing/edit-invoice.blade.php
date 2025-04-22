<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-12 col-span-12">
            <form wire:submit.prevent="submit">
                <div class="box">
                    <div class="box-body">
                        <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                            <div class="xl:col-span-4 col-span-12 choices-control">
                                <label for="invoice-date-issued" class="form-label">Customer</label>
                                <select class="form-control w-full !rounded-md !bg-light" wire:model="customer_id">
                                    <option>Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->official_name }}</option>
                                    @endforeach
                                    @error('customer_id')
                                        <div class="text-red-500 text-xs">{{ $message }}</div>
                                    @enderror
                                </select>
                            </div>
                            <div class="xl:col-span-4 col-span-12">
                                <label for="invoice-date-issued" class="form-label">Date Issued</label>
                                <input type="date" class="form-control w-full !rounded-md !bg-light"
                                    id="invoice-date-issued"  wire:model="invoice_date">
                                @error('invoice_date')
                                    <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="xl:col-span-4 col-span-12">
                                <label for="invoice-date-due" class="form-label">Due Date</label>
                                <input type="date" class="form-control w-full !rounded-md !bg-light"
                                    wire:model="due_date">
                                @error('due_date')
                                    <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12">
                                <label for="invoice-date-due" class="form-label">Title</label>
                                <input class="form-control w-full rounded-md bg-light" placeholder="Title"
                                    type="text" wire:model="title">
                                @error('title')
                                    <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                            <div class="xl:col-span-12 col-span-12 choices-control">
                                <label for="invoice-date-due" class="form-label">Notes</label>
                                <textarea class="form-control w-full !rounded-md !bg-light" wire:model="notes" rows="2"></textarea>
                                @error('notes')
                                    <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                            <div class="xl:col-span-12 col-span-12">
                                <div class="table-responsive">
                                    <table class="table whitespace-nowrap border dark:border-defaultborder/10 mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="row">Package</th>
                                                <th scope="row" class="min-w-[120px]">Quantity</th>
                                                <th scope="row">Rate</th>
                                                <th scope="row">Sub Total</th>
                                                <th scope="row">From</th>
                                                <th scope="row">To</th>
                                                <th scope="row">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($fields as $k => $field)
                                                <tr wire:key="{{ $k }}"
                                                    class="border border-defaultborder dark:border-defaultborder/10">
                                                    <td>
                                                        <select class="form-control w-full !rounded-md !bg-light"
                                                            wire:model.live.debounce.750ms="fields.{{ $loop->index }}.service_plan_id">
                                                            <option value="">Select Package</option>
                                                            @foreach ($servicePlans as $servicePlan)
                                                                <option value="{{ $servicePlan->id }}">
                                                                    {{ $servicePlan->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('fields.{{ $loop->index }}.service_plan_id')
                                                            <div class="text-red-500 text-xs">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            class="form-control !w-auto !rounded-md !bg-light"
                                                            placeholder="Quantity"
                                                            wire:model.live.debounce.750ms="fields.{{ $loop->index }}.quantity">
                                                        @error('fields.{{ $loop->index }}.quantity')
                                                            <div class="text-red-500 text-xs">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td class="invoice-quantity-container">
                                                        <input type="number"
                                                            class="form-control !w-auto !rounded-md !bg-light"
                                                            placeholder="Rate"
                                                            wire:model.live.debounce.750ms="fields.{{ $loop->index }}.rate">
                                                        @error('fields.{{ $loop->index }}.rate')
                                                            <div class="text-red-500 text-xs">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input class="form-control !w-auto !rounded-md !bg-light"
                                                            placeholder="" type="number"
                                                            wire:model="fields.{{ $loop->index }}.sub_total" disabled>
                                                        @error('fields.{{ $loop->index }}.sub_total')
                                                            <div class="text-red-500 text-xs">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input class="form-control !w-auto !rounded-md !bg-light"
                                                            type="date" value="$120.00"
                                                            wire:model="fields.{{ $loop->index }}.from">
                                                        @error('fields.{{ $loop->index }}.from')
                                                            <div class="text-red-500 text-xs">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input class="form-control !w-auto !rounded-md !bg-light"
                                                            type="date" wire:model="fields.{{ $loop->index }}.to">
                                                        @error('fields.{{ $loop->index }}.to')
                                                            <div class="text-red-500 text-xs">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <button aria-label="button" type="button"
                                                            wire:click="removeField({{ $loop->index }})"
                                                            class="ti-btn btn-wave ti-btn-sm ti-btn-icon ti-btn-danger"><i
                                                                class="ri-delete-bin-5-line"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="d-flex justify-content-center mt-2">
                                    <button type="button" class="ti-btn btn-wave ti-btn-light !font-medium" wire:click="addField"><i
                                            class="bi bi-plus-lg"></i> Add
                                        Item</button>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                            <div class="xl:col-span-4 col-span-12 choices-control">
                                <label for="invoice-date-issued" class="form-label">Total</label>
                                <input type="number" class="form-control w-full !rounded-md !bg-light" wire:model="total" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-end">
                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                            type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading.remove>Generate</span>
                            <span wire:loading>Generating Invoice</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
