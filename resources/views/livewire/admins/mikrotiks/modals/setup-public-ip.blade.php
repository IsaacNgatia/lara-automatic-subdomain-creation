<div class="grid grid-cols-12 gap-6  m-10">
    <div class="xl:col-span-12 col-span-12">
        <div class="text-start">
            <p class="text-[.9375rem] font-semibold mb-2">By clicking the <strong class="font-bold">'Proceed Creating
                    Files'</strong>
                button below, the
                following will happen</p>
            <ul class="list-disc list-inside text-gray-800 dark:text-white">
                <li>Creation of necessary files together with a script to be executed in your mikrotik.</li>
                <li>Automatic addition of the mikrotik into your system</li>
            </ul>
        </div>
    </div>
    <div class="lg:col-span-12 col-span-12 my-2">
        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
            wire:click="createOvpnFiles()" class="ti-btn btn-wave ti-btn-secondary-full w-full cursor-pointer">
            <span wire:loading.remove wire:target="createOvpnFiles">Proceed
                Creating
                Files</span>
            <span wire:loading wire:target="createOvpnFiles"> Creating
                Files</span>

        </button>
    </div>
    <div class="xl:col-span-12 col-span-12">
        <div class="text-start">
            <p class="text-[.9375rem] font-semibold mb-2">Download your files:</p>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left">File Name</th>
                        <th class="text-left">Created At</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td class="py-2">{{ basename($file['file']) }}</td>
                            <td class="py-2">{{ $this->formatLastModifiedTime($file['last_modified']) }}</td>
                            <td class="py-2 text-right">
                                <button wire:click="downloadFile('{{ $file['file'] }}')"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Download
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
