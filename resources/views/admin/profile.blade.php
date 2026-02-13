@extends('layouts.admin')
@section('title', 'Profil Saya')
@section('subtitle', 'Kelola informasi akun administrator Anda')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-surface rounded-3xl shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <div class="flex items-start">
                <div class="w-12 h-12 rounded-2xl bg-[#FFF0F0] flex items-center justify-center text-primary mr-5">
                    <i class="fas fa-user-shield text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-heading mb-1">Edit Profile Admin</h3>
                    <p class="text-xs text-gray-400 font-medium tracking-wide">Kelola keamanan dan informasi akun Anda</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="p-8">
            @csrf
            
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Basic Info -->
            <div class="mb-10">
                <h4 class="text-sm font-bold text-heading mb-6 pb-2 border-b border-gray-100 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-primary/50"></i> Informasi Dasar
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full bg-gray-50/50 border border-gray-100 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Alamat Email</label>
                        <input type="email" value="{{ $user->email }}" readonly 
                               class="w-full bg-gray-100 border border-gray-100 rounded-xl px-4 py-3 text-sm text-gray-400 cursor-not-allowed">
                        <p class="text-[10px] text-gray-400 mt-1 italic">* Email tidak dapat diubah</p>
                    </div>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-heading mb-6 pb-2 border-b border-gray-100 flex items-center">
                    <i class="fas fa-lock mr-2 text-primary/50"></i> Keamanan Akun
                </h4>
                <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-50">
                    <p class="text-xs text-gray-500 mb-6 flex items-center">
                        <i class="fas fa-shield-alt mr-2 text-primary"></i> Kosongkan jika tidak ingin mengubah password
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Password Baru</label>
                            <input type="password" name="password" 
                                   class="w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all"
                                   placeholder="Min. 8 karakter">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-8 mt-4 border-t border-gray-50">
                <button type="submit" class="bg-primary text-white px-10 py-3.5 rounded-xl text-sm font-bold hover:bg-[#632429] transition-all shadow-md hover:shadow-lg flex items-center group">
                    <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
