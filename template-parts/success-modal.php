            <!-- modal starts -->
            <div 
            x-cloak
            x-show.transition="status" 
            class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
            >
            <div 
            class="max-w-3xl px-6 py-4 mx-auto text-left bg-white rounded shadow-lg"
            @click.away="status = false"
            x-transition:enter="motion-safe:ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            >
                <div class="bg-white rounded px-8 py-8 max-w-lg mx-auto">
                    <div class="flex items-center justify-between">
                    <h5 class="mr-3 text-black max-w-none" x-text="modalHeaderText"></h5>          
                    <span class="mr-3 text-black max-w-none" x-text="modalBodyText"></span>          
                  <button type="button" class="z-50 cursor-pointer" @click="status = false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  </button>
                    </div>
                </div>         
            </div>
            </div>
            <!-- modal ends -->