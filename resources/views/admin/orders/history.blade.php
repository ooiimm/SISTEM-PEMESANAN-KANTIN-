<!-- resources/views/admin/orders/history.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pesanan Selesai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">

                @forelse ($orders as $order)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        {{-- Bagian Info Utama --}}
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col md:flex-row justify-between md:items-start">
                                {{-- Info Kiri --}}
                                <div>
                                    <div class="flex items-center space-x-2 mb-2">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Selesai
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Pesanan #{{ $order->id }} - Meja {{ $order->nomor_meja }}</span>
                                    </div>
                                    <p class="font-bold text-lg text-gray-900 dark:text-white">Pemesan: {{ $order->user->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Waktu Selesai: {{ $order->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                                {{-- Info Kanan (Total Harga) --}}
                                <div class="mt-4 md:mt-0 text-left md:text-right">
                                    <p class="font-extrabold text-2xl text-gray-800 dark:text-white">Rp {{ number_format($order->total_harga) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Bagian Detail Item yang Terpisah --}}
                        @if($order->items->isNotEmpty())
                            <div class="p-6 bg-gray-50 dark:bg-gray-800/50">
                                <h4 class="font-semibold mb-2 text-gray-700 dark:text-gray-300">Detail Item yang Dipesan:</h4>
                                <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                                    @foreach($order->items as $item)
                                        <li><span class="font-semibold">{{ $item->jumlah }}x</span> {{ $item->menu->nama_menu }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h7.5M3.75 12a9 9 0 1118 0 9 9 0 01-18 0z" /></svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">Belum Ada Riwayat Pesanan</h3>
                        <p class="mt-1 text-sm text-gray-500">Pesanan yang telah selesai akan muncul di sini.</p>
                    </div>
                @endforelse
                
                {{-- Link Paginasi --}}
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>