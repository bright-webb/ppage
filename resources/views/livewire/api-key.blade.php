<div>
    <h2 class="text-3xl dark:text-white mb-3">Your API Key</h2>
                <hr/>
                <p wire:loading wire:target="generateApiKey">
                    <svg class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0116 0"></path>
                    </svg>
                </p>
                @if(isset($apiKey) && $apiKey == '')
                    <p class="text-2xl dark:text-white mt-3">No API Key Found</p>
                @elseif(isset($apiKey) && $apiKey != '')
                    <p class="text-2xl dark:text-white mt-3">{{ $apiKey }}</p>
                @else
                
                    <p class="text-2xl dark:text-white mt-3">No API Key Found</p>
                @endif
                <br />
                <hr/>
                <br />
                <button type="button" wire:click="generateApiKey" class="py-3 px-4 inline-flex items-center gap-x-2 rounded-md border border-transparent font-semibold text-white bg-gray-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all text-lg" >Generate API Key</button>
</div>
