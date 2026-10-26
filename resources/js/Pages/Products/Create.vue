<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    kode_produk: '',
    nama_produk: '',
    kategori: '',
    harga: '',
    stok: '',
});
const fields = [
    { key: 'kode_produk', label: 'Kode Produk', type: 'text' },
    { key: 'nama_produk', label: 'Nama Produk', type: 'text' },
    { key: 'kategori', label: 'Kategori', type: 'text' },
    { key: 'harga', label: 'Harga (Rp)', type: 'number' },
    { key: 'stok', label: 'Stok', type: 'number' },
];

const submit = () => form.post(route('products.store'));
</script>

<template>
    <Head title="Tambah Produk" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Tambah Produk</h2>
        </template>

        <form @submit.prevent="submit" class="max-w-xl space-y-4 rounded bg-white p-6 shadow">
            <div v-for="f in fields" :key="f.key">
                <label class="block text-sm font-medium text-gray-700">{{ f.label }}</label>
                <input v-model="form[f.key]" :type="f.type" class="mt-1 w-full rounded border-gray-300" />
                <p v-if="form.errors[f.key]" class="mt-1 text-sm text-red-600">{{ form.errors[f.key] }}</p>
            </div>
            <div class="flex gap-2">
                <button type="submit" :disabled="form.processing" class="rounded bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">
                    Simpan
                </button>
                <Link :href="route('products.index')" class="rounded border px-4 py-2 text-sm">Batal</Link>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
