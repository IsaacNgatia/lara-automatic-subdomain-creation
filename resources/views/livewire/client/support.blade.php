    <div class="main-chart-wrapper p-2 gap-2 lg:flex">
        <div class="chat-info border dark:border-defaultborder/10">
            <a aria-label="anchor" href="javascript:void(0)"
                class="hs-dropdown-toggle ti-btn ti-btn btn-wave bg-secondary text-white !font-medium ti-btn-icon !rounded-full chat-add-icon">
                <i class="ri-add-line"></i>
            </a>

            <button type="button"
                class="hs-dropdown-toggle ti-btn  ti-btn btn-wave bg-secondary text-white !font-medium ti-btn-icon !rounded-full chat-add-icon"
                data-hs-overlay="#hs-vertically-centered-modal">
                <i class="ri-add-line"></i>
            </button>

            <div id="hs-vertically-centered-modal" class="hs-overlay hidden ti-modal">
                <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out min-h-[calc(100%-3.5rem)] flex items-center">
                    <div class="ti-modal-content">
                        <div class="ti-modal-header">
                            <h6 class="modal-title text-[1rem] font-semibold" id="staticBackdropLabel2">New Ticket
                            </h6>
                            <button type="button" class="hs-dropdown-toggle ti-modal-close-btn"
                                data-hs-overlay="#hs-vertically-centered-modal">
                                <span class="sr-only">Close</span>
                                <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z"
                                        fill="currentColor" />
                                </svg>
                            </button>
                        </div>
                        <div class="ti-modal-body">
                            <form wire:submit="createTicket">
                            {{-- <form action="#" method="POST"> --}}
                                {{-- @csrf

                                <div
                                    class="box-body !pt-0 xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                                    <label for="hs-select-label" class="ti-form-select rounded-sm !py-2 !px-0 label">Ticket
                                        Type</label>
                                    <select id="hs-select-label" class="ti-form-select rounded-sm !py-2 !px-3"
                                        name="type">
                                        <option selected>Select Option</option>
                                        <option value="1">Sales and Billing</option>
                                        <option value="2">Technical</option>
                                    </select>
                                </div> --}}

                                <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                                    <label for="input-label" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="input-label" wire:model="topic">
                                </div>

                                <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                                    <label for="text-area" class="form-label">Description</label>
                                    <textarea class="form-control" id="text-area" rows="6" wire:model="description"></textarea>
                                </div>

                                <div class="ti-modal-footer">
                                    <button type="button" class="hs-dropdown-toggle ti-btn  btn-wave ti-btn-secondary-full"
                                        data-hs-overlay="#hs-vertically-centered-modal">
                                        Close
                                    </button>
                                    <button type="submit" class="ti-btn  btn-wave ti-btn-primary-full">
                                        Create
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>


            <div class="flex items-center justify-between w-full p-4 border-b dark:border-defaultborder/10">
                <div>
                    <h5 class="font-semibold mb-0 text-[1.25rem] !text-defaulttextcolor dark:text-defaulttextcolor/70">
                        Tickets</h5>
                </div>
                {{-- <div class="hs-dropdown ti-dropdown">
                    <button aria-label="button" class="ti-btn btn-wave ti-btn-icon ti-btn-secondary text-secondary"
                        type="button" aria-expanded="false">
                        <i class="ri-settings-3-line"></i>
                    </button>
                    <ul class="hs-dropdown-menu ti-dropdown-menu hidden">
                        <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                href="javascript:void(0);">Action</a></li>
                        <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                href="javascript:void(0);">Another action</a></li>
                        <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                href="javascript:void(0);">Something else here</a></li>
                    </ul>
                </div> --}}
            </div>
            <div class="chat-search p-4 border-b dark:border-defaultborder/10">
                <div class="input-group">
                    <input type="text" class="form-control !bg-light border-0 !rounded-s-md" placeholder="Search Chat"
                        aria-describedby="button-addon2">
                    <button aria-label="button" class="ti-btn btn-wave ti-btn-light !rounded-s-none !mb-0" type="button"
                        id="button-addon2"><i class="ri-search-line text-[#8c9097] dark:text-white/50"></i></button>
                </div>
            </div>
            {{-- <nav class="flex border-b border-defaultborder dark:border-defaultborder/10" aria-label="Tabs" role="tablist">
                <a class="hs-tab-active:border-b-2 hs-tab-active:border-b-primary hs-tab-active:bg-primary/10 hs-tab-active:text-primary cursor-pointer border-e dark:border-defaultborder/10 text-defaulttextcolor py-2 px-4 flex-grow  text-sm font-medium text-center rounded-none active"
                    id="users-item" data-hs-tab="#users-tab-pane" aria-controls="users-tab-pane">
                    <i
                        class="ri-history-line me-1 align-middle inline-block cursor-pointer w-[1.875rem] h-[1.875rem] p-[0.4rem] rounded-full hs-tab-active:bg-primary/10 bg-light"></i>Recent
                </a>
                <a class="hs-tab-active:border-b-2 hs-tab-active:border-b-primary hs-tab-active:bg-primary/10 hs-tab-active:text-primary cursor-pointer border-e dark:border-defaultborder/10 text-defaulttextcolor py-2 px-4 text-sm flex-grow font-medium text-center  rounded-none "
                    id="groups-item" data-hs-tab="#groups-tab-pane" aria-controls="groups-tab-pane">
                    <i
                        class="ri-group-2-line me-1 align-middle inline-block w-[1.875rem] h-[1.875rem] p-[0.4rem] rounded-full hs-tab-active:bg-primary/10 bg-light"></i>Groups
                </a>
                <a class="hs-tab-active:border-b-2 hs-tab-active:border-b-primary hs-tab-active:bg-primary/10 hs-tab-active:text-primary cursor-pointer text-defaulttextcolor py-2 px-4 text-sm flex-grow font-medium text-center  rounded-none "
                    id="calls-item" data-hs-tab="#calls-tab-pane" aria-controls="calls-tab-pane">
                    <i
                        class="ri-phone-line me-1 align-middle inline-block w-[1.875rem] h-[1.875rem] p-[0.4rem] rounded-full hs-tab-active:bg-primary/10 bg-light"></i>Calls
                </a>
            </nav> --}}
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active !border-0 chat-users-tab" id="users-tab-pane"
                    aria-labelledby="users-item" role="tabpanel" tabindex="0">
                    <ul class="list-none mb-0 mt-2 chat-users-tab" id="chat-msg-scroll">
                        <li class="!pb-0 !pt-0">
                            <p class="text-[#8c9097] dark:text-white/50 text-[0.6875rem] font-semibold mb-2 opacity-[0.7]">
                                ACTIVE CHATS</p>
                        </li>
                        @foreach ($tickets as $ticket)
                            <li class="checkforactive">
                                {{-- <a href="javascript:void(0);" onclick="changeTheInfo(this,'Sujika','5','online')"> --}}
                                <a href="javascript:void(0);" onclick="changeTheInfo(this,'Sujika','5','online')">
                                    <div class="flex items-start">
                                        <div class="me-1 leading-none">
                                            <span class="avatar avatar-md online me-2 avatar-rounded">
                                                <img src="{{ asset('build/assets/images/faces/5.jpg') }}" alt="img">
                                            </span>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="mb-0 font-semibold">
                                                {{ $ticket->case_number }} <span
                                                    class="ltr:float-right rtl:float-left text-[#8c9097] dark:text-white/50 font-normal text-[0.6875rem]">{{ $ticket->created_at->diffForHumans() }}</span>
                                            </p>
                                            <p class="text-[0.75rem] mb-0">
                                                <span class="chat-msg text-truncate">{{ $ticket->title }}</span>
                                                <span class="chat-read-icon ltr:float-right rtl:float-left align-middle"><i
                                                        class="ri-check-double-fill"></i></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-chat-area border dark:border-defaultborder/10">
            <div class="sm:flex items-center p-2 border-b dark:border-defaultborder/10">
                <div class="flex items-center leading-none">
                    <span class="avatar avatar-lg online me-4 avatar-rounded chatstatusperson">
                        <img class="chatimageperson" src="{{ asset('build/assets/images/faces/2.jpg') }}" alt="img">
                    </span>
                    <div class="flex-grow">
                        <p class="mb-1 font-semibold text-[.875rem]">
                            <a href="javascript:void(0);"
                                class="chatnameperson responsive-userinfo-open !text-defaulttextcolor dark:text-defaulttextcolor/70">TKT-{{ $ticket->id }}</a>
                        </p>
                        <p class="text-[#8c9097] dark:text-white/50 mb-0 chatpersonstatus !text-defaultsize">online</p>
                    </div>
                </div>
            </div>
            <div class="chat-content" id="main-chat-content">
                <ul class="list-none">
                    @foreach ($ticket->replies as $response)
                    <li class="chat-item-start">
                        <div class="chat-list-inner">
                            <div class="chat-user-profile">
                                <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                    <img class="chatimageperson" src="{{ asset('build/assets/images/faces/2.jpg') }}"
                                        alt="img">
                                </span>
                            </div>
                            <div class="ms-4">
                                <span class="chatting-user-info">
                                    <span class="chatnameperson">Emiley Jackson</span> <span
                                        class="msg-sent-time">11:48PM</span>
                                </span>
                                <div class="main-chat-msg">
                                    <div>
                                        <p class="mb-0">Nice to meet you 😀</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="chat-item-end">
                        <div class="chat-list-inner">
                            <div class="me-3">
                                <span class="chatting-user-info">
                                    <span class="msg-sent-time"><span class="chat-read-mark align-middle inline-flex"><i
                                                class="ri-check-double-line"></i></span>11:50PM</span> You
                                </span>
                                <div class="main-chat-msg">
                                    <div>
                                        <p class="mb-0">It is a long established fact that a reader will be
                                            distracted by the readable content of a page when looking at its
                                            layout</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-user-profile">
                                <span class="avatar avatar-md online avatar-rounded">
                                    <img src="{{ asset('build/assets/images/faces/15.jpg') }}" alt="img">
                                </span>
                            </div>
                        </div>
                    </li>
                        
                    @endforeach
                </ul>
            </div>
            <div class="chat-footer">
                <input class="form-control w-full !rounded-md" placeholder="Type your message here..." type="text">
                <a aria-label="anchor" class="ti-btn btn-wave ti-btn-icon !mx-2 ti-btn-success"
                    href="javascript:void(0)">
                    <i class="ri-emotion-line"></i>
                </a>
                <a aria-label="anchor" class="ti-btn btn-wave bg-primary text-white  ti-btn-icon ti-btn-send"
                    href="javascript:void(0)">
                    <i class="ri-send-plane-2-line"></i>
                </a>
            </div>
        </div>
        <div class="chat-user-details border dark:border-defaultborder/10" id="chat-user-details">
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
        </div>
    </div>
