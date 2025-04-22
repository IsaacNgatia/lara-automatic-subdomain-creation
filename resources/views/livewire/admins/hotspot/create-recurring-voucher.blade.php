<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Add Recurring Hotspot User
                </div>
            </div>
            <div class="box-body">
                <form class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-0">
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header">Personal Information</div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class=" col-span-12">
                                <label class="form-label">Hotspot Name</label>
                                <input type="text" class="form-control" placeholder="Jane Doe"
                                    aria-label="Last name">
                            </div>
                            <div class="col-span-12">
                                <label class="form-label">Official Name</label>
                                <input type="text" class="form-control" placeholder="First name"
                                    aria-label="First name">
                            </div>
                            <div class="col-span-12">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <input type="email" class="form-control" id="inputEmail4">
                            </div>

                            <div class="col-span-12">
                                <label for="inputAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                            </div>


                            <div class=" col-span-12">
                                <label for="inputIpAddress" class="form-label">Hotspot Password</label>
                                <input type="text" class="form-control" id="hspPass">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header">Mikrotik Information</div>

                        <div class="grid grid-cols-12 gap-4 mt-4">

                            <div class=" col-span-12">
                                <label for="inputState" class="form-label">Select Package</label>
                                <div class="flex justify-between gap-4">
                                    <select id="inputState" class="form-select !py-[0.59rem]">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                    <button type="button" class="ti-btn btn-wave ti-btn-primary-full">Add</button>
                                </div>
                            </div>
                            <div class=" col-span-12">
                                <label for="inputPassword4" class="form-label">Server</label>
                                <select id="inputState" class="form-select !py-[0.59rem]">
                                    <option selected>hsprof1</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col-span-12">
                                <label for="inputPassword4" class="form-label">Profile</label>
                                <select id="inputState" class="form-select !py-[0.59rem]">
                                    <option>default</option>
                                    <option selected>users</option>
                                </select>
                            </div>
                            <div class="col-span-12">
                                <label for="inputState" class="form-label">Status</label>
                                <select id="inputState" class="form-select !py-[0.59rem]">
                                    <option selected>Enabled</option>
                                    <option>Disabled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="text-sm md:text-base font-semibold box-header">Payment Information</div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class=" col-span-12">
                                <label for="inputState" class="form-label">Reference Number</label>
                                <div class="flex justify-between gap-4">
                                    <input type="text" class="form-control" placeholder="Reference Number"
                                        aria-label="First name">
                                    <button type="button"
                                        class="ti-btn btn-wave ti-btn-primary-full">Generate</button>
                                </div>
                            </div>
                            <div class=" col-span-12">
                                <label class="form-label">Bill Amount</label>
                                <input type="text" class="form-control" placeholder="Last name"
                                    aria-label="Last name">
                            </div>
                            <div class="col-span-12">
                                <label for="inputEmail4" class="form-label">Billing Cycle</label>
                                <div class="flex justify-between gap-4"><select id="inputState"
                                        class="form-select !py-[0.59rem]">
                                        <option>Days</option>
                                        <option>Weeks</option>
                                        <option selected>Months</option>
                                        <option>Years</option>
                                    </select>
                                    <input type="email" class="form-control" id="inputEmail4" value="1">
                                </div>
                            </div>
                            <div class="col-span-12">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" placeholder="Last name"
                                    aria-label="Last name">
                            </div>
                            <div class=" col-span-12">
                                <label for="inputPassword4" class="form-label">Expiry date</label>
                                <div class="form-group mb-0">
                                    <div class="input-group">
                                        <div class="input-group-text text-[#8c9097] dark:text-white/50 !border-e-0"> <i
                                                class="ri-calendar-line"></i> </div>
                                        <input type="text" class="form-control" id="weeknum"
                                            placeholder="Choose date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sendSms">
                                    <label class="form-check-label" for="sendSms">
                                        Send sms
                                    </label>
                                </div>
                            </div>
                            <div class="col-span-6 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sendEmail">
                                    <label class="form-check-label" for="sendEmail">
                                        Send email
                                    </label>
                                </div>
                            </div>
                            <div class="col-span-12">
                                <button type="submit"
                                    class="ti-btn btn-wave ti-btn-primary-full w-full">Submit</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
