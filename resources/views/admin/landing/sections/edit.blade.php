@extends('layouts.admin')

@section('title', 'Edit Section: ' . $section->name)
@section('subtitle', 'Update content for ' . $section->name)

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.landing.sections.update', $section->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if($section->key == 'hero')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Headline</label>
                    <input type="text" name="headline" value="{{ $section->content['headline'] ?? '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tagline (WYSIWYG)</label>
                    <textarea name="tagline" rows="4" class="wysiwyg">{{ $section->content['tagline'] ?? '' }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Website</label>
                        <input type="text" name="site_name" value="{{ $section->content['site_name'] ?? 'The Secret' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Logo Website (Kiri Atas & Wax Seal)</label>
                        @if(isset($section->content['logo_url']))
                            <div class="mb-2">
                                <img src="{{ $section->content['logo_url'] }}" alt="Logo Preview" class="h-10 w-auto rounded border shadow-sm bg-gray-100">
                            </div>
                        @endif
                        <input type="file" name="logo_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto Utama (Hero Bagian Kiri)</label>
                        @if(isset($section->content['image_url']))
                            <div class="mb-2">
                                <img src="{{ $section->content['image_url'] }}" alt="Hero Preview" class="h-40 w-auto rounded border shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="hero_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Primary Button Text</label>
                        <input type="text" name="primary_button" value="{{ $section->content['primary_button'] ?? '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Primary Button URL</label>
                        <input type="text" name="primary_url" value="{{ $section->content['primary_url'] ?? '#products' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Secondary Button Text</label>
                        <input type="text" name="secondary_button" value="{{ $section->content['secondary_button'] ?? '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Secondary Button URL</label>
                        <input type="text" name="secondary_url" value="{{ $section->content['secondary_url'] ?? '#about' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

        @elseif($section->key == 'about')
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Badge</label>
                    <input type="text" name="badge" value="{{ $section->content['badge'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Title</label>
                    <input type="text" name="title" value="{{ $section->content['title'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" class="wysiwyg">{{ $section->content['description'] ?? $section->content['content'] ?? '' }}</textarea>
                </div>
                
                <div x-data="{ stats: {{ json_encode($section->content['stats'] ?? []) }} }" class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-6">Statistik / Counter</label>
                    <div class="space-y-4">
                        <template x-for="(item, index) in stats" :key="index">
                            <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                <div class="flex-1">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Label (Contoh: Alumni)</label>
                                    <input type="text" :name="'stats['+index+'][label]'" x-model="item.label" class="w-full p-2 border-0 border-b border-gray-100 focus:ring-0 focus:border-primary text-sm" placeholder="Label">
                                </div>
                                <div class="flex-1">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Nilai (Contoh: 5000+)</label>
                                    <input type="text" :name="'stats['+index+'][value]'" x-model="item.value" class="w-full p-2 border-0 border-b border-gray-100 focus:ring-0 focus:border-primary text-sm" placeholder="Value">
                                </div>
                                <button type="button" @click="stats.splice(index, 1)" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="stats.push({label: '', value: ''})" class="mt-4 px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl text-primary text-sm font-bold hover:bg-white/50 transition-colors w-full">
                        <i class="fas fa-plus mr-2"></i> Tambah Statistik
                    </button>
                </div>
            </div>

        @elseif($section->key == 'problem')
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Title</label>
                    <input type="text" name="title" value="{{ $section->content['title'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" class="wysiwyg">{{ $section->content['description'] ?? $section->content['content'] ?? '' }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach(['card_1', 'card_2', 'card_3'] as $idx => $cardKey)
                    <div class="p-6 bg-pink-50/30 rounded-2xl border border-pink-100">
                        <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-4">Kartu #{{ $idx + 1 }}</label>
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Icon</label>
                                <div x-data="iconPicker('{{ $section->content[$cardKey]['icon'] ?? '' }}')" class="relative">
                                    <button type="button" @click="toggle" class="w-full p-2 border border-gray-200 rounded-lg text-sm bg-white hover:bg-gray-50 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <iconify-icon x-show="value" :icon="value" class="text-sm text-primary"></iconify-icon>
                                            <span x-text="value || 'Pilih Icon'" :class="!value && 'text-gray-400 text-xs'"></span>
                                        </div>
                                        <i class="fas fa-search text-[10px] text-gray-300"></i>
                                    </button>
                                    <input type="hidden" name="{{ $cardKey }}[icon]" x-model="value">
                                    <div x-show="open" @click.away="close" class="absolute z-50 mt-1 p-4 bg-white border border-gray-200 rounded-xl shadow-xl left-0 w-64">
                                        <input type="text" x-model="search" x-ref="searchInput" placeholder="Cari icon Lucide..." class="w-full p-2 mb-3 border border-gray-100 rounded-lg text-xs focus:ring-primary focus:border-primary">
                                        <div class="icon-grid max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                            <template x-for="icon in filteredIcons()" :key="icon">
                                                <button type="button" @click="selectIcon(icon)" class="p-2 rounded-lg hover:bg-primary/10 transition-colors flex items-center justify-center border border-transparent hover:border-primary/20" :class="value === icon && 'bg-primary/5 border-primary/20'">
                                                    <iconify-icon :icon="icon" class="text-lg text-gray-700"></iconify-icon>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Judul</label>
                                <input type="text" name="{{ $cardKey }}[title]" value="{{ $section->content[$cardKey]['title'] ?? '' }}" class="w-full p-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Konten</label>
                                <input type="text" name="{{ $cardKey }}[description]" value="{{ $section->content[$cardKey]['description'] ?? '' }}" class="w-full p-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        @elseif($section->key == 'explanation')
             <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Title</label>
                    <input type="text" name="title" value="{{ $section->content['title'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" class="wysiwyg">{{ $section->content['description'] ?? $section->content['content'] ?? '' }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Button Text</label>
                        <input type="text" name="button_text" value="{{ $section->content['button_text'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Button URL</label>
                        <input type="text" name="button_url" value="{{ $section->content['button_url'] ?? '#products' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

        @elseif($section->key == 'affiliate')
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Title</label>
                    <input type="text" name="title" value="{{ $section->content['title'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" class="wysiwyg">{{ $section->content['description'] ?? $section->content['content'] ?? '' }}</textarea>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    @foreach(['card_1', 'card_2', 'card_3'] as $idx => $cardKey)
                    <div class="p-6 bg-pink-50/30 rounded-2xl border border-pink-100">
                        <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-4">Langkah #{{ $idx + 1 }}</label>
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Icon</label>
                                <div x-data="iconPicker('{{ $section->content[$cardKey]['icon'] ?? '' }}')" class="relative">
                                    <button type="button" @click="toggle" class="w-full p-2 border border-gray-200 rounded-lg text-sm bg-white hover:bg-gray-50 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <iconify-icon x-show="value" :icon="value" class="text-sm text-primary"></iconify-icon>
                                            <span x-text="value || 'Pilih Icon'" :class="!value && 'text-gray-400 text-xs'"></span>
                                        </div>
                                        <i class="fas fa-search text-[10px] text-gray-300"></i>
                                    </button>
                                    <input type="hidden" name="{{ $cardKey }}[icon]" x-model="value">
                                    <div x-show="open" @click.away="close" class="absolute z-50 mt-1 p-4 bg-white border border-gray-200 rounded-xl shadow-xl left-0 w-64">
                                        <input type="text" x-model="search" x-ref="searchInput" placeholder="Cari icon Lucide..." class="w-full p-2 mb-3 border border-gray-100 rounded-lg text-xs focus:ring-primary focus:border-primary">
                                        <div class="icon-grid max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                            <template x-for="icon in filteredIcons()" :key="icon">
                                                <button type="button" @click="selectIcon(icon)" class="p-2 rounded-lg hover:bg-primary/10 transition-colors flex items-center justify-center border border-transparent hover:border-primary/20" :class="value === icon && 'bg-primary/5 border-primary/20'">
                                                    <iconify-icon :icon="icon" class="text-lg text-gray-700"></iconify-icon>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Judul</label>
                                <input type="text" name="{{ $cardKey }}[title]" value="{{ $section->content[$cardKey]['title'] ?? '' }}" class="w-full p-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Konten</label>
                                <input type="text" name="{{ $cardKey }}[description]" value="{{ $section->content[$cardKey]['description'] ?? '' }}" class="w-full p-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-2 gap-6 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Register Button URL</label>
                        <input type="text" name="register_url" value="{{ $section->content['register_url'] ?? route('register') }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Login Button URL</label>
                        <input type="text" name="login_url" value="{{ $section->content['login_url'] ?? route('login') }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

        @elseif($section->key == 'testimonials')
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Title</label>
                    <input type="text" name="title" value="{{ $section->content['title'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Description</label>
                    <input type="text" name="description" value="{{ $section->content['description'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                
                <div x-data="{ items: {{ json_encode($section->content['items'] ?? []) }} }" class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-6">Testimoni</label>
                    <div class="space-y-6">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative">
                                <button type="button" @click="items.splice(index, 1)" class="absolute top-4 right-4 text-red-300 hover:text-red-500 transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-1 space-y-4">
                                        <div>
                                            <label class="text-[10px] font-bold text-gray-400 uppercase">Nama</label>
                                            <input type="text" :name="'items['+index+'][name]'" x-model="item.name" class="w-full p-2 border border-gray-100 rounded-lg text-sm focus:ring-primary focus:border-primary">
                                        </div>
                                        <div>
                                            <label class="text-[10px] font-bold text-gray-400 uppercase">Role / Status</label>
                                            <input type="text" :name="'items['+index+'][role]'" x-model="item.role" class="w-full p-2 border border-gray-100 rounded-lg text-sm focus:ring-primary focus:border-primary">
                                        </div>
                                        <div>
                                            <label class="text-[10px] font-bold text-gray-400 uppercase">Avatar Icon</label>
                                            <div x-data="iconPicker(item.avatar)" x-init="$watch('value', v => item.avatar = v)" class="relative">
                                                <button type="button" @click="toggle" class="w-full p-2 border border-gray-100 rounded-lg text-sm bg-white hover:bg-gray-50 flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <iconify-icon x-show="value" :icon="value" class="text-sm text-primary"></iconify-icon>
                                                        <span x-text="value || 'Pilih'" :class="!value && 'text-gray-400 text-xs'"></span>
                                                    </div>
                                                    <i class="fas fa-search text-[10px] text-gray-300"></i>
                                                </button>
                                                <input type="hidden" :name="'items['+index+'][avatar]'" x-model="value">
                                                <div x-show="open" @click.away="close" class="absolute z-50 mt-1 p-4 bg-white border border-gray-200 rounded-xl shadow-xl left-0 w-64">
                                                    <input type="text" x-model="search" x-ref="searchInput" placeholder="Cari icon..." class="w-full p-2 mb-3 border border-gray-100 rounded-lg text-xs focus:ring-primary focus:border-primary">
                                                    <div class="icon-grid max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                                        <template x-for="icon in filteredIcons()" :key="icon">
                                                            <button type="button" @click="selectIcon(icon)" class="p-2 rounded-lg hover:bg-primary/10 transition-colors flex items-center justify-center border border-transparent hover:border-primary/20" :class="value === icon && 'bg-primary/5 border-primary/20'">
                                                                <iconify-icon :icon="icon" class="text-lg text-gray-700"></iconify-icon>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase">Isi Testimoni</label>
                                        <textarea :name="'items['+index+'][content]'" x-model="item.content" rows="6" class="w-full p-3 border border-gray-100 rounded-lg text-sm focus:ring-primary focus:border-primary mt-1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="items.push({name: '', role: '', avatar: '👤', content: ''})" class="mt-6 px-4 py-3 bg-white border border-dashed border-gray-300 rounded-2xl text-primary text-sm font-bold hover:bg-white/50 transition-colors w-full">
                        <i class="fas fa-plus mr-2"></i> Tambah Testimoni
                    </button>
                </div>
            </div>

        @elseif($section->key == 'contact')
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Title</label>
                    <input type="text" name="title" value="{{ $section->content['title'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Description</label>
                    <input type="text" name="description" value="{{ $section->content['description'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Warning Text</label>
                    <input type="text" name="warning_text" value="{{ $section->content['warning_text'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>
                
                <div x-data="{ channels: {{ json_encode($section->content['channels'] ?? []) }} }" class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-6">Channel Kontak (Auto-Sosmed di Dashboard)</label>
                    <div class="space-y-4">
                        <template x-for="(channel, index) in channels" :key="index">
                            <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                <div class="w-24">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase text-center block">Icon</label>
                                    <div x-data="iconPicker(channel.icon)" x-init="$watch('value', v => channel.icon = v)" class="relative">
                                        <button type="button" @click="toggle" class="w-full p-2 border border-gray-100 rounded-lg text-sm bg-white hover:bg-gray-50 flex items-center justify-center">
                                            <iconify-icon x-show="value" :icon="value" class="text-primary"></iconify-icon>
                                            <span x-show="!value">❔</span>
                                        </button>
                                        <input type="hidden" :name="'channels['+index+'][icon]'" x-model="value">
                                        <div x-show="open" @click.away="close" class="absolute z-50 mt-1 p-4 bg-white border border-gray-200 rounded-xl shadow-xl left-0 w-64">
                                            <input type="text" x-model="search" x-ref="searchInput" placeholder="Cari icon..." class="w-full p-2 mb-3 border border-gray-100 rounded-lg text-xs focus:ring-primary focus:border-primary">
                                            <div class="icon-grid max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                                <template x-for="icon in filteredIcons()" :key="icon">
                                                    <button type="button" @click="selectIcon(icon)" class="p-2 rounded-lg hover:bg-primary/10 transition-colors flex items-center justify-center border border-transparent hover:border-primary/20" :class="value === icon && 'bg-primary/5 border-primary/20'">
                                                        <iconify-icon :icon="icon" class="text-lg text-gray-700"></iconify-icon>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Nama</label>
                                    <input type="text" :name="'channels['+index+'][name]'" x-model="channel.name" class="w-full p-2 border-0 border-b border-gray-100 focus:ring-0 focus:border-primary text-sm">
                                </div>
                                <div class="flex-[2]">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">URL / Nomor</label>
                                    <input type="text" :name="'channels['+index+'][url]'" x-model="channel.url" class="w-full p-2 border-0 border-b border-gray-100 focus:ring-0 focus:border-primary text-sm">
                                </div>
                                <button type="button" @click="channels.splice(index, 1)" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="channels.push({name: '', icon: '💬', url: ''})" class="mt-4 px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl text-primary text-sm font-bold hover:bg-white/50 transition-colors w-full">
                        <i class="fas fa-plus mr-2"></i> Tambah Channel
                    </button>
                </div>
            </div>

        @elseif($section->key == 'footer')
            <div x-data="{ links: {{ json_encode($section->content['links'] ?? []) }} }" class="space-y-8">
                <div>
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Copyright Text</label>
                    <input type="text" name="copyright" value="{{ $section->content['copyright'] ?? '' }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-6">Quick Links</label>
                    <div class="space-y-4">
                        <template x-for="(link, index) in links" :key="index">
                            <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                <div class="flex-1">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Label</label>
                                    <input type="text" :name="'links['+index+'][name]'" x-model="link.name" class="w-full p-2 border-0 border-b border-gray-100 focus:ring-0 focus:border-primary text-sm">
                                </div>
                                <div class="flex-[2]">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">URL</label>
                                    <input type="text" :name="'links['+index+'][url]'" x-model="link.url" class="w-full p-2 border-0 border-b border-gray-100 focus:ring-0 focus:border-primary text-sm">
                                </div>
                                <button type="button" @click="links.splice(index, 1)" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="links.push({name: '', url: '#'})" class="mt-4 px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl text-primary text-sm font-bold hover:bg-white/50 transition-colors w-full">
                        <i class="fas fa-plus mr-2"></i> Tambah Link
                    </button>
                </div>
            </div>
        @endif

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.landing.sections.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-md hover:bg-red-900 transition-colors shadow-sm">Save Changes</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.wysiwyg').forEach(el => {
        ClassicEditor
            .create(el)
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endpush
@endsection
