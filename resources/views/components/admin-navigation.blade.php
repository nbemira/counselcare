<nav class="bg-blue-100 text-gray-700 border-b border-gray-200 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> <!-- Increased height to accommodate larger logo -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.manage-students') }}">
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="w-32 h-32"> <!-- Adjusted width and height to 32 -->
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                    @if (Auth::user()->role === 'admin')
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('admin.manage-students')" :active="request()->routeIs('admin.manage-students')">
                                {{ __('Manage Students') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.manage_counsellors')" :active="request()->routeIs('admin.manage_counsellors')">
                                {{ __('Manage Counsellors') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.manage_psychologists')" :active="request()->routeIs('admin.manage_psychologists')">
                                {{ __('Manage Psychologists') }}
                            </x-nav-link>
                        </div>
                    @else
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 relative">
                <div class="relative">
                    <button onclick="toggleDropdown()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 focus:outline-none transition ease-in-out duration-150 transform hover:scale-105">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 011.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-50">
                    <a href="{{ route('profile.update-password-form') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 icon icon-tabler icons-tabler-outline icon-tabler-password-user">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 17v4 M10 20l4 -2 M10 18l4 2 M5 17v4 M3 20l4 -2 M3 18l4 2 M19 17v4 M17 20l4 -2 M17 18l4 2 M9 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0 M7 14a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2" />
                        </svg>
                        {{ __('Update Password') }}
                    </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 icon icon-tabler icons-tabler-outline icon-tabler-logout"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button onclick="toggleResponsiveMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-white hover:bg-blue-300 focus:outline-none focus:bg-blue-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="menu-open-icon" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="menu-close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="responsive-menu" class="hidden sm:hidden bg-blue-300">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.manage-students')" :active="request()->routeIs('admin.manage-students')">
                {{ __('Manage Students') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.manage_counsellors')" :active="request()->routeIs('admin.manage_counsellors')">
                {{ __('Manage Counsellors') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.manage_psychologists')" :active="request()->routeIs('admin.manage_psychologists')">
                {{ __('Manage Psychologists') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.update-password-form')">
                    {{ __('Update Password') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('hidden');
    }

    function toggleResponsiveMenu() {
        const responsiveMenu = document.getElementById('responsive-menu');
        const menuOpenIcon = document.getElementById('menu-open-icon');
        const menuCloseIcon = document.getElementById('menu-close-icon');
        
        responsiveMenu.classList.toggle('hidden');
        menuOpenIcon.classList.toggle('hidden');
        menuCloseIcon.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownButton = dropdownMenu.previousElementSibling;
        
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
