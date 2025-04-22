<div class="box">
    <div class="box-header justify-between">
        <div class="box-title">
            Recent Tickets
        </div>
        <button type="button" class="ti-btn ti-btn-light !py-1 !px-2 !text-[0.75rem]">Raise
            New</button>
    </div>
    <div class="box-body">
        {{-- <div class="flex items-center justify-between">
            <div class="font-semibold">Messages</div>
            <div><i
                    class="ri-check-double-line me-1 align-middle text-[#8c9097] dark:text-white/50 inline-flex"></i>Mark
                as read</div>
        </div> --}}
        <div class="mt-6">
            <ul class="list-none mb-0 personal-messages-list">

                @forelse ($tickets as $ticket)
                    <li>
                        <div class="flex flex-wrap items-center">
                            <div class="me-2">
                                <span class="avatar avatar-rounded">
                                    <img src="{{ asset('build/assets/images/faces/12.jpg') }}" alt="">
                                </span>
                            </div>
                            <div class="flex-grow">
                                <span class="font-semibold block">{{ $ticket->topic }}</span>
                                <span class="text-[0.75rem] text-[#8c9097] dark:text-white/50 block message">{{ $ticket->description }}</span>
                            </div>
                            <div class="text-end">
                                <span class="block text-[#8c9097] dark:text-white/50 text-[0.75rem]">{{ $ticket->created_at->diffForHumans() }}</span>
                                {{-- <span class="badge bg-primary !rounded-full text-white">2</span> --}}
                            </div>
                        </div>
                        <hr>
                    </li>
                @empty
                    No tickets were found.
                @endforelse
            </ul>
        </div>
    </div>
</div>
