 <!-- Start:: Grouped Vouchers -->
 <div class="grid grid-cols-12 gap-6">
     <div class="col-span-12">
         <div class="box custom-box">
             <div class="box-header justify-between">
                 <div class="box-title">
                     Grouped Cash Vouchers Table
                 </div>

             </div>
             <div class="box-body space-y-3">
                 <div class="flex justify-between">
                     <div class="download-data">
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-csv">
                             CSV</button>
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-json">
                             JSON</button>
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-xlsx">
                             XLSX</button>
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-pdf">
                             PDF</button>
                         <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-html">
                             HTML</button>
                     </div>
                     <div>
                         <div class="relative">
                             <input type="text" id="hs-search-box-with-loading-1" name="hs-search-box-with-loading-1"
                                 class="ti-form-input rounded-sm ps-11 focus:z-10" placeholder="Input search">
                             <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                 <div class="animate-spin inline-block w-4 h-4 border-[3px] border-current border-t-transparent text-primary rounded-full"
                                     role="status" aria-label="loading">
                                     <span class="sr-only">Loading...</span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="table-responsive">
                     <table class="table whitespace-nowrap table-bordered min-w-full">
                         <thead>
                             <tr class="border-b border-defaultborder">
                                 <th scope="col" class="text-start">Id</th>
                                 <th scope="col" class="text-start">Display Name</th>
                                 <th scope="col" class="text-start">Profile</th>
                                 <th scope="col" class="text-start">Time Limit</th>
                                 <th scope="col" class="text-start">Data Limit</th>
                                 <th scope="col" class="text-start">Router Name</th>
                                 <th scope="col" class="text-start">Price</th>
                                 <th scope="col" class="text-start">Total</th>
                                 <th scope="col" class="text-start">Sold</th>
                                 <th scope="col" class="text-start">unsold</th>
                                 <th scope="col" class="text-start">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr class="border-b border-defaultborder">
                                 <td>1</td>

                                 <td>Isaac Ngatia</td>
                                 <td>12.12.12.12</td>
                                 <td>kimosukuro@gmail.com</td>
                                 <td>Router 1</td>
                                 <td>5GB</td>
                                 <td>6Hrs</td>
                                 <td>Default</td>
                                 <td>3000</td>
                                 <td>2024-08-25 14:05:09</td>
                                 <td>
                                     <div class="hstack flex gap-2 flex-wrap">
                                         <a aria-label="anchor" href="javascript:void(0);"
                                             class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-info/10 text-info hover:bg-info hover:text-white hover:border-info"><i
                                                 class="ri-eye-line"></i></a>
                                         <button type="button"
                                             class="ti-btn btn-wave ti-btn-danger-full custom-button !rounded-full max-h-[2rem] max-w-[6rem]">
                                             <span class="custom-ti-btn-icons max-h-[1.9rem] max-w-[1.9rem]"><i
                                                     class="ri-delete-bin-5-line text-danger"></i></span>
                                             <p class="text-xs">unsold</p>
                                         </button>
                                         <button type="button"
                                             class="ti-btn btn-wave ti-btn-danger-full custom-button !rounded-full max-h-[2rem] max-w-[4.5rem]">
                                             <span class="custom-ti-btn-icons max-h-[1.8rem] max-w-[1.8rem]"><i
                                                     class="ri-delete-bin-5-line text-danger"></i></span>
                                             <p class="text-xs">all</p>
                                         </button>
                                     </div>
                                 </td>
                             </tr>
                             <tr class="border-b border-defaultborder">
                                 <td>1</td>
                                 <td>Isaac Ngatia</td>
                                 <td>12.12.12.12</td>
                                 <td>hasimna2132@gmail.com</td>
                                 <td>Router 1</td>
                                 <td>5GB</td>
                                 <td>6Hrs</td>
                                 <td>Default</td>
                                 <td>3000</td>
                                 <td>2024-08-25 14:05:09</td>
                                 <td>
                                     <div class="hstack flex gap-2 flex-wrap">
                                         <a aria-label="anchor" href="javascript:void(0);"
                                             class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-info/10 text-info hover:bg-info hover:text-white hover:border-info"><i
                                                 class="ri-eye-line"></i></a>
                                         <button type="button"
                                             class="ti-btn btn-wave ti-btn-danger-full custom-button !rounded-full max-h-[2rem] max-w-[6rem]">
                                             <span class="custom-ti-btn-icons max-h-[1.9rem] max-w-[1.9rem]"><i
                                                     class="ri-delete-bin-5-line text-danger"></i></span>
                                             <p class="text-xs">unsold</p>
                                         </button>
                                         <button type="button"
                                             class="ti-btn btn-wave ti-btn-danger-full custom-button !rounded-full max-h-[2rem] max-w-[4.5rem]">
                                             <span class="custom-ti-btn-icons max-h-[1.8rem] max-w-[1.8rem]"><i
                                                     class="ri-delete-bin-5-line text-danger"></i></span>
                                             <p class="text-xs">all</p>
                                         </button>
                                     </div>
                                 </td>
                             </tr>
                             <tr class="border-b border-defaultborder">
                                 <td>1</td>
                                 <td>Isaac Ngatia</td>
                                 <td>12.12.12.12</td>
                                 <td>azimokhan421@gmail.com</td>
                                 <td>Router 1</td>
                                 <td>10GB</td>
                                 <td>6Hrs</td>
                                 <td>default</td>
                                 <td>3000</td>
                                 <td>2024-08-25 14:05:09</td>
                                 <td>
                                     <div class="hstack flex gap-2 flex-wrap">
                                         <a aria-label="anchor" href="javascript:void(0);"
                                             class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-info/10 text-info hover:bg-info hover:text-white hover:border-info"><i
                                                 class="ri-eye-line"></i></a>
                                         <button type="button"
                                             class="ti-btn btn-wave ti-btn-danger-full custom-button !rounded-full max-h-[2rem] max-w-[6rem]">
                                             <span class="custom-ti-btn-icons max-h-[1.9rem] max-w-[1.9rem]"><i
                                                     class="ri-delete-bin-5-line text-danger"></i></span>
                                             <p class="text-xs">unsold</p>
                                         </button>
                                         <button type="button"
                                             class="ti-btn btn-wave ti-btn-danger-full custom-button !rounded-full max-h-[2rem] max-w-[4.5rem]">
                                             <span class="custom-ti-btn-icons max-h-[1.8rem] max-w-[1.8rem]"><i
                                                     class="ri-delete-bin-5-line text-danger"></i></span>
                                             <p class="text-xs">all</p>
                                         </button>
                                     </div>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
                 <div class="py-4 px-3">
                     <div class="flex ">
                         <div class="flex space-x-4 items-center mb-3">
                             <label class="w-32 text-sm font-medium ">Per Page</label>
                             <select
                                 class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                 <option value="5">5</option>
                                 <option value="10">10</option>
                                 <option value="20">20</option>
                                 <option value="50">50</option>
                                 <option value="100">100</option>
                             </select>
                         </div>
                     </div>
                 </div>
             </div>

         </div>
     </div>
 </div>
