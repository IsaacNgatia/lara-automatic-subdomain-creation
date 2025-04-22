<div class="main-chart-wrapper p-2 gap-2 lg:flex">
    <div class="chat-info border dark:border-defaultborder/10">
        <a aria-label="anchor" href="javascript:void(0)" wire:click="addingClientTicket"
            class="hs-dropdown-toggle ti-btn ti-btn btn-wave bg-secondary text-white !font-medium ti-btn-icon !rounded-full chat-add-icon">
            <i class="ri-add-line"></i>
        </a>

        <div class="flex items-center justify-between w-full p-4 border-b dark:border-defaultborder/10">
            <div>
                <h5 class="font-semibold mb-0 text-[1.25rem] !text-defaulttextcolor dark:text-defaulttextcolor/70">
                    Tickets</h5>
            </div>
        </div>

        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="alert alert-success"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active !border-0 chat-users-tab" id="users-tab-pane"
                aria-labelledby="users-item" role="tabpanel" tabindex="0">
                <ul class="list-none mb-0 mt-2 chat-users-tab" id="chat-msg-scroll">
                    @foreach ($tickets as $ticket)
                        <li class="checkforactive">
                            <a wire:click="selectTicket({{ $ticket->id }})">
                                <div class="flex items-start">
                                    <div class="flex-grow">
                                        <p class="mb-0 font-semibold">
                                            {{ $ticket->case_number }} <span
                                                class="ltr:float-right rtl:float-left text-[#8c9097] dark:text-white/50 font-normal text-[0.6875rem]">{{ $ticket->created_at->diffForHumans() }}</span>
                                        </p>
                                        <br>
                                        <p class="text-[0.75rem] mb-0">
                                            <span class="chat-msg text-truncate">{{ $ticket->topic }}</span>
                                            <span class="chat-read-icon ltr:float-right rtl:float-left align-middle"><i
                                                    class="ri-check-double-fill"></i></span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <hr>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="main-chat-area border dark:border-defaultborder/10">
        <div class="sm:flex items-center p-2 border-b dark:border-defaultborder/10">
            <div class="flex items-center leading-none">
                <div class="flex-grow">
                    @if ($selectedTicket)
                        <p class="mb-1 font-semibold text-[.875rem]">
                        <h4 class="responsive-userinfo-open !text-defaulttextcolor dark:text-defaulttextcolor/70">
                            {{ $selectedTicket->case_number }} :: {{ $selectedTicket->topic }}
                        </h4>
                        </p>
                        <br>
                        <p class="mb-1 font-semibold text-[.875rem]">
                        <h6 class="responsive-userinfo-open !text-defaulttextcolor dark:text-defaulttextcolor/70">
                            {{ $selectedTicket->description }}
                        </h6>
                        </p>
                    @else
                        <p class="mb-1 font-semibold text-[.875rem]">
                        <h4 class="responsive-userinfo-open !text-defaulttextcolor dark:text-defaulttextcolor/70">
                            Select a ticket
                        </h4>
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="chat-content" id="main-chat-content">
            <ul class="list-none">
                @foreach ($selectedTicketReplies as $reply)
                    <li class="chat-item"
                        style="text-align: {{ $reply->replied_by == auth()->guard('client')->user()->id ? 'right' : 'left' }};">
                        <div class="chat-list-inner"
                            style="display: inline-block; max-width: 70%; 
                                    background-color: {{ $reply->replied_by == auth()->guard('client')->user()->id ? '#cce5ff' : '#f1f1f1' }};
                                    padding: 10px; border-radius: {{ $reply->replied_by == auth()->guard('client')->user()->id ? '10px 10px 0 10px' : '10px 10px 10px 0' }};">
                            <span class="chatting-user-info" style="font-size: 0.9em; color: #666;">
                                <span class="chatnameperson" style="font-weight: bold; color: #333;">
                                    {{ $reply->replied_by == auth()->guard('client')->user()->id ? 'You' : 'Admin' }}
                                </span>
                                <span class="msg-sent-time" style="margin-left: 5px;">
                                    {{ $reply->created_at->format('h:i A') }}
                                </span>
                            </span>
                            <div class="main-chat-msg">
                                <p class="mb-0" style="margin: 5px 0 0; color: #333;">
                                    {{ $reply->reply }}
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- <ul class="list-none">
                @foreach ($selectedTicketReplies as $reply)
                    <li class="chat-item-start">
                        <div class="chat-list-inner">
                            <div class="ms-4">
                                <span class="chatting-user-info">
                                    <span class="chatnameperson">Emiley Jackson</span> <span
                                        class="msg-sent-time">11:48PM</span>
                                </span>
                                <div class="main-chat-msg">
                                    <div>
                                        <p class="mb-0">{{ $reply->reply }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    @if ($reply->replied_by == auth()->guard('client')->user()->id)
                        <li class="chat-item-start">
                            <div class="chat-list-inner">
                                <div class="ms-4">
                                    <span class="chatting-user-info">
                                        <span class="chatnameperson">Emiley Jackson</span> <span
                                            class="msg-sent-time">11:48PM</span>
                                    </span>
                                    <div class="main-chat-msg">
                                        <div>
                                            <p class="mb-0">{{ $reply->reply }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul> --}}
        </div>

        @if ($selectedTicket)
            @if ($selectedTicket->status == 'closed')
                <form wire:submit="replyAsClient">
                    <div class="chat-footer">
                        <div class="w-full">
                            <textarea class="form-control flex-grow mr-2 rounded-md" wire:model="newTicketReply.reply" rows="2"></textarea>
                            @error('newTicketReply.reply')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <div class="">
                            <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                                type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                                <span wire:loading.remove>Reply</span>
                                <span wire:loading>Sending reply</span>
                            </button>
                        </div>
                        {{-- <a aria-label="anchor" class="ti-btn btn-wave ti-btn-icon !mx-2 ti-btn-success"
        href="javascript:void(0)">
        <i class="ri-emotion-line"></i>
    </a> --}}
                    </div>
                </form>
            @else
                <p>This ticket is closed.</p>
            @endif

        @endif
    </div>
    {{-- <div class="chat-user-details border dark:border-defaultborder/10" id="chat-user-details">
        <button aria-label="button" type="button"
            class="ti-btn btn-wave ti-btn-icon ti-btn-outline-light my-1 ms-2 responsive-chat-close2 xxl:hidden"> <i
                class="ri-close-line"></i> </button>
        <div class="text-center mb-[3rem]">
            <span class="avatar avatar-rounded online avatar-xxl me-2 mb-4 chatstatusperson">
                <img class="chatimageperson" src="{{ asset('build/assets/images/faces/2.jpg') }}" alt="img">
            </span>
            <p
                class="mb-1 text-[0.9375rem] font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70 leading-none chatnameperson ">
                Emiley Jackson</p>
            <p class="text-[0.75rem] text-[#8c9097] dark:text-white/50 !mb-4"><span
                    class="chatnameperson">emaileyjackson2134</span>@gmail.com</p>
            <p class="text-center mb-0">
                <button type="button" aria-label="button"
                    class="ti-btn btn-wave ti-btn-icon !rounded-full ti-btn-primary"><i
                        class="ri-phone-line"></i></button>
                <button type="button" aria-label="button"
                    class="ti-btn btn-wave ti-btn-icon !rounded-full ti-btn-primary !ms-2"><i
                        class="ri-video-add-line"></i></button>
                <button type="button" aria-label="button"
                    class="ti-btn btn-wave ti-btn-icon !rounded-full ti-btn-primary !ms-2"><i
                        class="ri-chat-1-line"></i></button>
            </p>
        </div>
        <div class="mb-[3rem]">
            <div class="font-semibold mb-6 dark:text-defaulttextcolor/70  text-defaultsize">Shared Files
                <span class="badge bg-primary/10 !rounded-full text-primary ms-1">4</span>
                <span class="ltr:float-right rtl:float-left text-[0.6875rem]"><a href="javascript:void(0);"
                        class="text-primary underline"><u>View All</u></a></span>
            </div>
            <ul class="shared-files list-none">
                <li class="!mb-4">
                    <div class="flex items-center">
                        <div class="me-2">
                            <span class="shared-file-icon">
                                <i class="ti ti-file-text"></i>
                            </span>
                        </div>
                        <div class="flex-grow">
                            <p class="text-[0.75rem] font-semibold mb-0 dark:text-defaulttextcolor/70 ">Project
                                Details.pdf</p>
                            <p class="mb-0 text-[#8c9097] dark:text-white/50 text-[0.6875rem]">24,Oct 2022 - 14:24PM
                            </p>
                        </div>
                        <div class="!text-[1.125rem]">
                            <a aria-label="anchor" href="javascript:void(0)"><i
                                    class="ri-download-2-line text-[#8c9097] dark:text-white/50"></i></a>
                        </div>
                    </div>
                </li>
                <li class="!mb-4">
                    <div class="flex items-center">
                        <div class="me-2">
                            <span class="shared-file-icon">
                                <i class="ri-image-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow">
                            <p class="text-[0.75rem] font-semibold mb-0 dark:text-defaulttextcolor/70">Img_02.Jpg</p>
                            <p class="mb-0 text-[#8c9097] dark:text-white/50 text-[0.6875rem]">22,Oct 2022 - 10:19AM
                            </p>
                        </div>
                        <div class="!text-[1.125rem]">
                            <a aria-label="anchor" href="javascript:void(0)"><i
                                    class="ri-download-2-line text-[#8c9097] dark:text-white/50"></i></a>
                        </div>
                    </div>
                </li>
                <li class="!mb-4">
                    <div class="flex items-center">
                        <div class="me-2">
                            <span class="shared-file-icon">
                                <i class="ri-image-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow">
                            <p class="text-[0.75rem] font-semibold mb-0 dark:text-defaulttextcolor/70">Img_15.Jpg</p>
                            <p class="mb-0 text-[#8c9097] dark:text-white/50 text-[0.6875rem]">22,Oct 2022 - 10:18AM
                            </p>
                        </div>
                        <div class="!text-[1.125rem]">
                            <a aria-label="anchor" href="javascript:void(0)"><i
                                    class="ri-download-2-line text-[#8c9097] dark:text-white/50"></i></a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <div class="me-2">
                            <span class="shared-file-icon">
                                <i class="ri-video-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow">
                            <p class="text-[0.75rem] font-semibold mb-0 dark:text-defaulttextcolor/70">
                                Video_15_02_2022.MP4</p>
                            <p class="mb-0 text-[#8c9097] dark:text-white/50 text-[0.6875rem]">22,Oct 2022 - 10:18AM
                            </p>
                        </div>
                        <div class="">
                            <a aria-label="anchor" href="javascript:void(0)"><i
                                    class="ri-download-2-line text-[#8c9097] dark:text-white/50 !text-[1.125rem]"></i></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="mb-0">
            <div class="font-semibold mb-4 text-defaultsize dark:text-defaulttextcolor/70">Photos &amp; Media
                <span class="badge bg-primary/10 !rounded-full text-primary ms-1">22</span>
                <span class="ltr:float-right rtl:float-left text-[0.6875rem]"><a href="javascript:void(0);"
                        class="text-primary underline"><u>View All</u></a></span>
            </div>
            <div class="grid grid-cols-12 gap-x-[1rem]">
                <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4 col-span-4">
                    <a aria-label="anchor" href="{{ url('gallery') }}" class="chat-media">
                        <img src="{{ asset('build/assets/images/media/media-56.jpg') }}" alt="">
                    </a>
                </div>
                <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4 col-span-4">
                    <a aria-label="anchor" href="{{ url('gallery') }}" class="chat-media">
                        <img src="{{ asset('build/assets/images/media/media-52.jpg') }}" alt="">
                    </a>
                </div>
                <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4 col-span-4">
                    <a aria-label="anchor" href="{{ url('gallery') }}" class="chat-media">
                        <img src="{{ asset('build/assets/images/media/media-53.jpg') }}" alt="">
                    </a>
                </div>
                <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4 col-span-4">
                    <a aria-label="anchor" href="{{ url('gallery') }}" class="chat-media">
                        <img src="{{ asset('build/assets/images/media/media-62.jpg') }}" alt="">
                    </a>
                </div>
                <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4 col-span-4">
                    <a aria-label="anchor" href="{{ url('gallery') }}" class="chat-media">
                        <img src="{{ asset('build/assets/images/media/media-63.jpg') }}" alt="">
                    </a>
                </div>
                <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4 col-span-4">
                    <a aria-label="anchor" href="{{ url('gallery') }}" class="chat-media">
                        <img src="{{ asset('build/assets/images/media/media-64.jpg') }}" alt="">
                    </a>
                </div>
                <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4 col-span-4">
                    <a aria-label="anchor" href="{{ url('gallery') }}" class="chat-media">
                        <img src="{{ asset('build/assets/images/media/media-13.jpg') }}" alt="">
                    </a>
                </div>
                <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4 col-span-4">
                    <a aria-label="anchor" href="{{ url('gallery') }}" class="chat-media">
                        <img src="{{ asset('build/assets/images/media/media-19.jpg') }}" alt="">
                    </a>
                </div>
                <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4 col-span-4">
                    <a aria-label="anchor" href="{{ url('gallery') }}" class="chat-media">
                        <img src="{{ asset('build/assets/images/media/media-20.jpg') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <x-modal maxWidth="lg">
        @slot('slot')
            @if ($addClientTicket)
                <livewire:client.support.modals.new-client-ticket />
            @endif
        @endslot
    </x-modal>
</div>
