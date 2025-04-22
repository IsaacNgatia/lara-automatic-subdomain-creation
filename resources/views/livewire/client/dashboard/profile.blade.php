<div>
    <div class="box">
        <div class="box-body">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <span class="block text-[0.9375rem] font-semibold">My Profile</span>
                </div>
            </div>
            <div class="text-center mb-4">
                <div class="mb-4">
                    <span class="avatar avatar-xxl avatar-rounded circle-progress p-1">
                        <img src="{{ asset('build/assets/images/faces/9.jpg') }}" alt="">
                    </span>
                </div>
                <div>
                    <h5 class="font-semibold !mb-0 text-[1.25rem]">{{ $profile->official_name }}</h5>
                    <p class="text-[.8125rem] text-[#8c9097] dark:text-white/50">
                        {{ $profile->email }}
                    </p>
                </div>
            </div>
            <div class=" text-center">
                <a href="{{ route('client.profile') }}"
                    class="ti-btn ti-btn-primary btn-wave !me-[0.375rem] !font-medium !py-1 !px-2 !text-[0.75rem]">
                    Edit Profile
                </a>
                <a href="{{ route('client.profile') }}"
                    class="ti-btn bg-primary btn-wave text-white !py-1 !px-2 !text-[0.75rem]">
                    View Profile
                </a>
            </div>
        </div>
    </div>
</div>
