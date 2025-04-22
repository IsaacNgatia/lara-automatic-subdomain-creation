@extends('admins.layouts.master')

@section('styles')
@endsection

@section('content')
    <div class="main-chart-wrapper p-2 gap-2 lg:flex">
        <div class="main-chat-area border dark:border-defaultborder/10">
            <div class="chat-content" id="main-chat-content">
                <ul class="list-none">
                    <li class="chat-day-label">
                        <span>Today</span>
                    </li>
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
                    <li class="chat-item-start">
                        <div class="chat-list-inner">
                            <div class="chat-user-profile">
                                <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                    <img class="chatimageperson" src="{{ asset('build/assets/images/faces/2.jpg') }}"
                                        alt="img">
                                </span>
                            </div>
                            <div class="ms-3">
                                <span class="chatting-user-info">
                                    <span class="chatnameperson">Emiley Jackson</span> <span
                                        class="msg-sent-time">11:51PM</span>
                                </span>
                                <div class="main-chat-msg">
                                    <div>
                                        <p class="mb-0">Who are you ?</p>
                                    </div>
                                    <div>
                                        <p class="mb-0">I don't know anyone named jeremiah.</p>
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
                                                class="ri-check-double-line"></i></span>11:52PM</span> You
                                </span>
                                <div class="main-chat-msg">
                                    <div>
                                        <p class="mb-0">Some of the recent images taken are nice 👌</p>
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
                    <li class="chat-item-start">
                        <div class="chat-list-inner">
                            <div class="chat-user-profile">
                                <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                    <img class="chatimageperson" src="{{ asset('build/assets/images/faces/2.jpg') }}"
                                        alt="img">
                                </span>
                            </div>
                            <div class="ms-3">
                                <span class="chatting-user-info">
                                    <span class="chatnameperson">Emiley Jackson</span> <span
                                        class="msg-sent-time">11:55PM</span>
                                </span>
                                <div class="main-chat-msg">
                                    <div>
                                        <p class="mb-0">Here are some of them have a look</p>
                                    </div>
                                    <div>
                                        <p class="mb-0 sm:flex block">
                                            <a aria-label="anchor" href="{{ url('gallery') }}"
                                                class="avatar avatar-xl m-1 "><img
                                                    src="{{ asset('build/assets/images/media/media-64.jpg') }}"
                                                    alt="" class="rounded-md"></a>
                                            <a aria-label="anchor" href="{{ url('gallery') }}"
                                                class="avatar avatar-xl m-1 "><img
                                                    src="{{ asset('build/assets/images/media/media-63.jpg') }}"
                                                    alt="" class="rounded-md"></a>
                                            <a aria-label="anchor" href="{{ url('gallery') }}"
                                                class="avatar avatar-xl m-1 "><img
                                                    src="{{ asset('build/assets/images/media/media-62.jpg') }}"
                                                    alt="" class="rounded-md"></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="chat-item-end">
                        <div class="chat-list-inner">
                            <div class="me-4">
                                <span class="chatting-user-info">
                                    <span class="msg-sent-time"><span class="chat-read-mark align-middle inline-flex"><i
                                                class="ri-check-double-line"></i></span>11:52PM</span> You
                                </span>
                                <div class="main-chat-msg">
                                    <div class="flex">
                                        <a aria-label="anchor" href="javascript:void(0)" class="text-white"><i
                                                class="ri-play-circle-line align-middle"></i></a>
                                        <span class="mx-1 flex flex-wrap">
                                            <svg width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                            <svg class="chat_audio" width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                            <svg class="chat_audio" width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                            <svg class="chat_audio" width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                            <svg class="chat_audio" width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                            <svg class="chat_audio" width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                            <svg class="chat_audio" width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                            <svg class="chat_audio" width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                            <svg class="chat_audio" width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                            <svg class="chat_audio" width="20" height="20">
                                                <defs></defs>
                                                <g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg"
                                                        data-name="Layer 3" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path
                                                            d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z"
                                                            fill="rgba(255, 255, 255, 0.5)"></path>
                                                    </svg></g>
                                            </svg>
                                        </span>
                                        <a aria-label="anchor" href="javascript:void(0)" class="text-white"><i
                                                class="ri-download-2-line align-middle"></i></a>
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
                    <li class="chat-item-start">
                        <div class="chat-list-inner">
                            <div class="chat-user-profile">
                                <span class="avatar avatar-md online avatar-rounded">
                                    <img class="chatimageperson" src="{{ asset('build/assets/images/faces/2.jpg') }}"
                                        alt="img">
                                </span>
                            </div>
                            <div class="ms-3">
                                <span class="chatting-user-info chatnameperson">
                                    Emiley Jackson <span class="msg-sent-time">11:45PM</span>
                                </span>
                                <div class="main-chat-msg">
                                    <div>
                                        <p class="mb-0">Happy to talk with you,chat you later 👋</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
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
    </div>
@endsection

@section('scripts')
    <!-- Chat JS -->
    <script src="{{ asset('build/assets/chat.js') }}"></script>
@endsection
