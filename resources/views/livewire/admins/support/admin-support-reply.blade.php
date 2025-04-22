<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    TICKECT No : {{ $ticket->case_number }}
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

                <!-- Chat Section -->
                <div class="mt-6 border-t pt-4">
                    <div class="chat-area overflow-y-auto h-72 p-4 bg-gray-50 rounded-md">
                        @foreach ($ticketReplies as $reply)
                            <div class="flex {{ $reply['replied_by'] === auth()->guard('admin')->user()->id ? 'justify-end' : '' }} mb-4">
                                <div
                                    class="rounded-lg p-3 max-w-xs text-sm {{ $reply['replied_by'] === auth()->guard('admin')->user()->id ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                                    <p>{{ $reply['reply'] }}</p>
                                    <span class="text-xs text-gray-500 block mt-1">
                                        {{ \Carbon\Carbon::parse($reply['created_at'])->format('h:i A, M d') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Chat Input -->
                    <form wire:submit="replyToTicket">
                        <div class="mt-4 mb-2 col-span-12 flex items-center">
                            <textarea class="form-control flex-grow mr-2 rounded-md" wire:model="ticketReplyForm.reply" rows="2"></textarea>
                            @error('ticketReplyForm.reply')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="class">
                            <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                                type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                                <span wire:loading.remove>Reply</span>
                                <span wire:loading>Sending reply</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
