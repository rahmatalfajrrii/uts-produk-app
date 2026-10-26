<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

const props = defineProps({
    products: Array,
    filters: Object,
});

const flash = computed(() => usePage().props.flash?.success);
const search = ref(props.filters.search ?? '');

watch(search, (value) => {
    router.get(route('products.index'), { search: value }, { preserveState: true, replace: true });
});

const hapus = (p) => {
    if (confirm('Yakin ingin menghapus produk ' + p.nama_produk + '?')) {
        router.delete(route('products.destroy', p.id));
    }
};

const rupiah = (n) =>
    new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(n);
</script>

<template>
    <Head title="Data Produk" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Data Produk</h2>
        </template>

        <div class="rounded bg-white p-6 shadow">
            <div v-if="flash" class="mb-4 rounded bg-green-100 p-3 text-sm text-green-800">{{ flash }}</div>

            <div class="mb-4 flex items-center justify-between gap-4">
                <input v-model="search" type="text" placeholder="Cari nama produk..." class="w-64 rounded border-gray-300 text-sm" />
                <Link :href="route('products.create')" class="rounded bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">
                    + Tambah Produk
                </Link>
            </div>

            <table class="w-full text-left text-sm">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="p-2">No</th>
                        <th class="p-2">Kode</th>
                        <th class="p-2">Nama Produk</th>
                        <th class="p-2">Kategori</th>
                        <th class="p-2">Harga</th>
                        <th class="p-2">Stok</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(p, i) in products" :key="p.id" class="border-b">
                        <td class="p-2">{{ i + 1 }}</td>
                        <td class="p-2">{{ p.kode_produk }}</td>
                        <td class="p-2">{{ p.nama_produk }}</td>
                        <td class="p-2">{{ p.kategori }}</td>
                        <td class="p-2">{{ rupiah(p.harga) }}</td>
                        <td class="p-2">{{ p.stok }}</td>
                        <td class="p-2">
                            <Link :href="route('products.edit', p.id)" class="mr-3 text-indigo-600 hover:underline">Edit</Link>
                            <button @click="hapus(p)" class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                    <tr v-if="products.length === 0">
                        <td colspan="7" class="p-4 text-center text-gray-500">Data produk tidak ditemukan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
