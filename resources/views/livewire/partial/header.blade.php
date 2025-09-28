<header
    class="flex z-50 sticky top-0 flex-wrap md:justify-start md:flex-nowrap w-full bg-white text-sm py-3 md:py-0 dark:bg-gray-800 shadow-md opacity-90">
    <nav class="max-w-[85rem] w-full mx-auto px-4 md:px-6 lg:px-8" aria-label="Global">
        <div class="relative md:flex md:items-center md:justify-between">
            <div class="flex items-center justify-between">
                <a class="flex-none text-xl font-bold dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                    href="/" aria-label="/" wire:navigate> <span class="text-red-600 dark:text-red-600">Drive</span>
                    <span class="text-gray-600 dark:text-gray-600">&</span> Go</a>
                <div class="md:hidden">
                    <button type="button"
                        class="hs-collapse-toggle flex justify-center items-center w-9 h-9 text-sm font-bold rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                        data-hs-collapse="#navbar-collapse-with-animation"
                        aria-controls="navbar-collapse-with-animation" aria-label="Toggle navigation">
                        <svg class="hs-collapse-open:hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" x2="21" y1="6" y2="6" />
                            <line x1="3" x2="21" y1="12" y2="12" />
                            <line x1="3" x2="21" y1="18" y2="18" />
                        </svg>
                        <svg class="hs-collapse-open:block hidden flex-shrink-0 w-4 h-4"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="navbar-collapse-with-animation"
                class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block">
                <div
                    class="overflow-hidden overflow-y-auto max-h-[75vh] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500">
                    <div
                        class="flex flex-col gap-x-0 mt-5 divide-y divide-dashed divide-gray-200 md:flex-row md:items-center md:justify-end md:gap-x-7 md:mt-0 md:ps-7 md:divide-y-0 md:divide-solid dark:divide-gray-700">

                        <a class="font-bold {{ request()->is('/') ? 'text-red-600' : 'text-gray-500' }}  py-3 md:py-6 dark:text-red-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                            href="/" aria-current="/" wire:navigate>Home</a>

                        <a class="font-bold {{ request()->is('browse-cars') ? 'text-red-600' : 'text-gray-500' }} hover:text-gray-400 py-3 md:py-6 dark:text-gray-400 dark:hover:text-gray-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                            href="/browse-cars" wire:navigate>
                            Browse Cars
                        </a>

                        @guest

                            @if (!request()->routeIs('login'))
                                <div>
                                    <button command="show-modal" commandfor="dialog"
                                        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                        <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                            <circle cx="12" cy="7" r="4" />
                                        </svg>Log
                                        In</button>
                                    <el-dialog>
                                        <dialog id="dialog" aria-labelledby="dialog-title"
                                            class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                                            <el-dialog-backdrop
                                                class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in">
                                            </el-dialog-backdrop>

                                            <div tabindex="0"
                                                class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                                                <el-dialog-panel
                                                    class="relative transform overflow-hidden  text-left    transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                                                    @livewire('auth.login')
                                                </el-dialog-panel>
                                            </div>
                                        </dialog>
                                    </el-dialog>
                                @else
                                    <div>
                                        <button command="show-modal" commandfor="dialog"
                                            class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                            <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                                <circle cx="12" cy="7" r="4" />
                                            </svg>Register
                                        </button>
                                        <el-dialog>
                                            <dialog id="dialog" aria-labelledby="dialog-title"
                                                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                                                <el-dialog-backdrop
                                                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in">
                                                </el-dialog-backdrop>

                                                <div tabindex="0"
                                                    class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                                                    <el-dialog-panel
                                                        class="relative transform overflow-hidden  text-left    transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                                                        @livewire('auth.register')
                                                    </el-dialog-panel>
                                                </div>
                                            </dialog>
                                        </el-dialog>
                                    </div>
                            @endif
                        @endguest


                        @auth
                            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false"
                                @keydown.escape.window="open = false" class="relative">
                                {{-- {{ dd('/storage/' . Auth::user()->avatar) }} --}}
                                <button @click="open = !open"
                                    class="flex items-center w-full text-gray-500 hover:text-gray-400 font-bold dark:text-gray-400 dark:hover:text-gray-500 shadow-2xl border-2 rounded-full p-2">
                                    <img src="{{ asset('/storage/' . Auth::user()->avatar) }}"
                                        alt="{{ Auth::user()->name }}'s avatar" class="w-8 h-8 rounded-full object-cover">


                                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>

                                <div x-show="open" x-cloak x-transition @click.outside="open = false"
                                    class="fixed right-4 md:right-8 top-17 md:top-17 w-40 bg-white shadow-lg rounded-b-md  p-2 z-50 dark:bg-neutral-800">
                                    @if (Auth::user()->role === 'admin')
                                        <a class="block px-3 py-2 rounded-lg text-sm font-bold text-gray-500 hover:bg-red-100"
                                            href="/admin" wire:navigate>Admin Panel</a>
                                    @else
                                        <a class="block px-3 py-2 rounded-lg text-sm font-bold text-gray-500 hover:bg-red-100"
                                            href="/my-car" wire:navigate>My Rentals</a>
                                        <a class="block px-3 py-2 rounded-lg text-sm font-bold text-gray-500 hover:bg-red-100"
                                            href="/settings" wire:navigate>Settings</a>
                                    @endif
                                    <a class="block px-3 py-2 rounded-lg text-sm font-bold text-gray-500 hover:bg-red-100"
                                        href="/logout" wire:navigate>Logout</a>
                                </div>
                            </div>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
