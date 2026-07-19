<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Buat Pengaduan Baru') }}
            </h2>
           <a href="{{ route('complaints.index') }}" 
   class="group inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 px-4 py-2.5 rounded-xl shadow-xs hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 ease-out tracking-wide">
    <!-- Ikon Panah Kembali yang bergeser ke kiri saat di-hover -->
    <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    <span>Kembali</span>
</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold text-gray-800">Formulir Pelaporan Kerusakan</h3>
                    <p class="text-sm text-gray-500">Mohon isi data kerusakan sedetail mungkin untuk memudahkan teknisi dalam melakukan perbaikan.</p>
                </div>

                <!-- Pastikan enctype="multipart/form-data" terpasang untuk upload file -->
                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Judul Aduan -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengaduan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                               placeholder="Contoh: AC Bocor dan Meneteskan Air" required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid untuk Lokasi, Kategori, dan Kode Barang -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        
                        <!-- Lokasi -->
                        <div>
                            <label for="location_id" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Ruangan <span class="text-red-500">*</span></label>
                            <select name="location_id" id="location_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->room_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori Barang <span class="text-red-500">*</span></label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kode Barang (Opsional) -->
                        <div>
                            <label for="kode_barang" class="block text-sm font-medium text-gray-700 mb-1">Kode Barang <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="kode_barang" id="kode_barang" value="{{ old('kode_barang') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                   placeholder="Contoh: INV/KOMP/001">
                            @error('kode_barang')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Deskripsi Kerusakan -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kerusakan <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="5" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                  placeholder="Jelaskan secara rinci kerusakan yang terjadi..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200 border-dashed">
                        <label for="photo_path" class="block text-sm font-medium text-gray-700 mb-2">Lampiran Foto <span class="text-xs text-gray-400 font-normal">(Opsional, Maksimal 2MB per file)</span></label>
                        <input type="file" name="photo_path[]" id="photo_path" accept="image/*" multiple 
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100 cursor-pointer form-control">
                        <p class="text-xs text-gray-500 mt-2">Format yang diizinkan: JPG, JPEG, PNG, GIF. Tahan tombol CTRL/Command saat memilih untuk upload lebih dari 1 foto.</p>
                        
                        <!-- Error untuk upload foto secara umum -->
                        @error('photo_path')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Error untuk spesifik file di dalam array (jika ada yg gagal validasi) -->
                        @error('photo_path.*')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end pt-4 border-t">
                       <button type="submit" 
        class="group inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-3 px-6 rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 ease-out tracking-wide cursor-pointer">
    <span>Kirim Pengaduan</span>
    
    <!-- Ikon Pesawat Kertas yang terbang/miring sedikit ke kanan-atas saat di-hover -->
    <svg class="w-4 h-4 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
    </svg>
</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>