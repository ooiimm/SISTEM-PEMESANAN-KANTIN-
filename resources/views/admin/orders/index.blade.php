<!-- resources/views/admin/orders/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 md:p-0">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2 px-4 sm:px-0">Daftar Pesanan Masuk</h3>
                <p class="text-md text-gray-600 dark:text-gray-400 mb-6 px-4 sm:px-0">Pesanan yang perlu diproses akan muncul di sini.</p>

                @if (session('success'))
                    <div class="flex items-center bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg relative mb-4" role="alert">
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                
                <div class="space-y-4">
                    @forelse ($orders as $order)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex flex-col md:flex-row justify-between md:items-center">
                                    {{-- Info Kiri --}}
                                    <div>
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                Meja: {{ $order->nomor_meja }}
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Pesanan #{{ $order->id }}</span>
                                        </div>
                                        <p class="font-bold text-lg text-gray-900 dark:text-white">Pemesan: {{ $order->user->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">NIM: {{ $order->user->nim }} | Waktu: {{ $order->created_at->format('H:i') }}</p>
                                    </div>
                                    {{-- Info Kanan --}}
                                    <div class="mt-4 md:mt-0 text-left md:text-right">
                                        <p class="font-extrabold text-2xl text-gray-800 dark:text-white">Rp {{ number_format($order->total_harga) }}</p>
                                        <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('PATCH')
                                            <x-primary-button>
                                                Tandai Selesai
                                            </x-primary-button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 bg-gray-50 dark:bg-gray-800/50">
                                <h4 class="font-semibold mb-2 text-gray-700 dark:text-gray-300">Detail Item:</h4>
                                <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                                    @foreach($order->items as $item)
                                        <li><span class="font-semibold">{{ $item->jumlah }}x</span> {{ $item->menu->nama_menu }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">Tidak ada pesanan masuk</h3>
                            <p class="mt-1 text-sm text-gray-500">Semua pesanan sudah selesai diproses. Kerja bagus!</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>