<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pilih Menu Favoritmu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 md:p-0">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2 px-4 sm:px-0">Daftar Menu Tersedia</h3>
                <p class="text-md text-gray-600 dark:text-gray-400 mb-6 px-4 sm:px-0">Pesan sekarang sebelum kehabisan!</p>
                
                @if (session('success'))
                    <div class="flex items-center bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg relative mb-4" role="alert">
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                     <div class="flex items-center bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg relative mb-4" role="alert">
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($menus as $menu)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col group">
                            {{-- Gambar Menu --}}
                            <div class="relative">
                                @if($menu->gambar)
                                    <img src="{{ asset('images/menu/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="w-full h-56 object-cover">
                                @else
                                    <div class="w-full h-56 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-gray-500">No Image</span>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 px-2 py-1 text-xs font-semibold rounded-full
                                    @if($menu->stok > 10) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                    Stok: {{ $menu->stok }}
                                </div>
                            </div>

                            {{-- Detail & Form --}}
                            <div class="p-6 flex flex-col flex-grow">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $menu->nama_menu }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 flex-grow">{{ $menu->deskripsi }}</p>
                                
                                <div class="mt-4 flex justify-between items-center">
                                    <p class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                    
                                    <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                                        @csrf
                                        <div class="flex items-center">
                                            <input type="number" name="jumlah" value="1" min="1" max="{{ $menu->stok }}" class="w-16 text-center bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-l-md focus:ring-0 focus:border-indigo-500 dark:text-gray-200">
                                            <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-0 transition ease-in-out duration-150">
                                                + Pesan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                             <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">Menu Tidak Ditemukan</h3>
                            <p class="mt-1 text-sm text-gray-500">Saat ini tidak ada menu yang tersedia. Silakan cek kembali nanti.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>