<div class="xxl:col-span-3 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12">
    <div class="box bg-white border-0">
        <div class="alert custom-alert1 alert-danger" id="dismiss-alert72">
            <button wire:click="cancel" type="button" class="btn-close ms-auto" data-hs-remove-element="#dismiss-alert72"
                aria-label="Close"><i class="bi bi-x"></i></button>
            <div class="text-center px-5 pb-0">
                <svg class="custom-alert-icon fill-danger inline-flex" xmlns="http://www.w3.org/2000/svg"
                    height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z" />
                </svg>
                <h5 class="text-[1.25rem] !font-medium">{{ $title }}</h5>
                <p class="">{{ $message }}</p>
                @if ($list)
                    <div class="text-start">
                        <p class="text-[.9375rem] font-semibold mb-1">The following data related to the user will be
                            deleted:</p>
                        <ul class="task-details-key-tasks ps-[2rem] mb-0">
                            @foreach ($list as $item)
                                <li wire:key="{{ $item }}" class="py-1">{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="">
                    <button wire:click="delete" type="button"
                        class="ti-btn !py-1 !px-2 !text-[0.75rem] !font-medium bg-danger text-white m-1">
                        <span wire:loading wire:target="delete" class="me-2">Deleting... </span>
                        <span class="me-2">Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
