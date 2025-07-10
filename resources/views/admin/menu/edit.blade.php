<!-- resources/views/admin/menu/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-6">Mengubah Detail: <span class="font-bold">{{ $menu->nama_menu }}</span></h3>

                    <!-- Tampilkan error validasi -->
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                            <ul class="list-disc pl-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('menu.update', $menu->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Menu -->
                        <div>
                            <x-input-label for="nama_menu" :value="__('Nama Menu')" />
                            <x-text-input id="nama_menu" class="block mt-1 w-full" type="text" name="nama_menu" :value="old('nama_menu', $menu->nama_menu)" required autofocus />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                        </div>

                        <!-- Harga & Stok (dalam satu baris) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <x-input-label for="harga" :value="__('Harga (Rp)')" />
                                <x-text-input id="harga" class="block mt-1 w-full" type="number" name="harga" :value="old('harga', $menu->harga)" required />
                            </div>
                            <div>
                                <x-input-label for="stok" :value="__('Stok')" />
                                <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok', $menu->stok)" required />
                            </div>
                        </div>

                        <!-- Gambar Menu -->
                        <div class="mt-4">
                            <x-input-label for="gambar" :value="__('Ganti Gambar Menu')" />
                            <div class="mt-2 flex items-center">
                                <!-- Gambar Saat Ini -->
                                <div class="flex-shrink-0 h-24 w-24">
                                     @if($menu->gambar)
                                        <img class="h-24 w-24 rounded-md object-cover" src="{{ asset('images/menu/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}">
                                    @else
                                         <div class="h-24 w-24 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <span class="text-xs text-gray-500">No Image</span>
                                         </div>
                                    @endif
                                </div>
                                <!-- Input File Baru -->
                                <div class="ml-4 flex-grow">
                                    <input id="gambar" name="gambar" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Kosongkan jika tidak ingin mengganti gambar.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Update Menu') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>