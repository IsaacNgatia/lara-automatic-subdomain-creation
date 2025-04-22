<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Create New Ticket
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
                <form wire:submit="createNewTicket" class="space-y-4 mt-0">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12">
                            <label for="ticketTitle" class="form-label">Title</label>
                            <input type="text" id="ticketTitle" class="form-control"
                                wire:model="newTicketForm.topic">
                            @error('newTicketForm.topic')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-12">
                            <label for="ticketDescription" class="form-label">Description</label>
                            <textarea id="ticketDescription" class="form-control" wire:model="newTicketForm.description" rows="6"></textarea>
                            @error('newTicketForm.description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                            type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading.remove>Create</span>
                            <span wire:loading>Creating Ticket</span>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
