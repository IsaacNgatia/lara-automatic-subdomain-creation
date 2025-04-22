<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Add Expense Type
                </div>
            </div>
            <div class="box-body">
                @if (session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="alert alert-success"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form wire:submit="submitExpenseType" class="space-y-4 mt-0">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12">
                            <label for="expenseTypeName" class="form-label">Expense Type Name</label>
                            <input type="text" id="expenseTypeName" class="form-control"
                                wire:model="expenseType.name">
                            @error('expenseType.name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-12">
                            <label for="expenseTypeDescription" class="form-label">Description</label>
                            <textarea id="expenseTypeDescription" class="form-control" wire:model="expenseType.description"></textarea>
                            @error('expenseType.description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                            type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading.remove>Save</span>
                            <span wire:loading>Saving Expense Type</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
