<!-- resources/views/cart/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Keranjang Pesanan Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="flex items-center bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded-md relative mb-4" role="alert">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="flex items-center bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-md relative mb-4" role="alert">
                             <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    @if(empty($cart))
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">Keranjang Kosong</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda belum menambahkan menu apa pun ke keranjang.</p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Kembali ke Menu
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Daftar Item Keranjang -->
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-200 dark:divide-gray-700">
                                @php $total = 0 @endphp
                                @foreach($cart as $id => $details)
                                    @php $total += $details['harga'] * $details['jumlah'] @endphp
                                    <li class="flex py-6">
                                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
                                            @if(!empty($details['gambar']))
                                                <img src="{{ asset('images/menu/' . $details['gambar']) }}" alt="{{ $details['nama_menu'] }}" class="h-full w-full object-cover object-center">
                                            @else
                                                <div class="h-full w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                    <span class="text-xs text-gray-500">No Image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex flex-1 flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                                    <h3>{{ $details['nama_menu'] }}</h3>
                                                    <p class="ml-4">Rp {{ number_format($details['harga'] * $details['jumlah']) }}</p>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500">Harga Satuan: Rp {{ number_format($details['harga']) }}</p>
                                            </div>
                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                <p class="text-gray-500">Jumlah: {{ $details['jumlah'] }}</p>
                                                <div class="flex">
                                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <!-- Ringkasan & Total -->
                        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-6 sm:px-6 mt-8">
                            <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                <p>Subtotal</p>
                                <p>Rp {{ number_format($total) }}</p>
                            </div>
                            
                        </div>
                        
                        <!-- Form Pemesanan -->
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                             <h3 class="text-lg font-bold mb-4">Selesaikan Pemesanan</h3>
                             <form action="{{ route('order.place') }}" method="POST">
                                 @csrf
                                 <div class="mb-4">
                                     <x-input-label for="nomor_meja" :value="__('Masukkan Nomor Meja Anda')" />
                                     <x-text-input id="nomor_meja" class="block mt-1 w-full md:w-1/3" type="number" name="nomor_meja" required :value="old('nomor_meja')" placeholder="Contoh: 12" />
                                     <x-input-error :messages="$errors->get('nomor_meja')" class="mt-2" />
                                 </div>
                                 <x-primary-button class="w-full justify-center md:w-auto">
                                     Buat Pesanan Sekarang
                                 </x-primary-button>
                             </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>