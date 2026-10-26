<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const user = usePage().props.auth.user;

const menus = [
     { label: 'Data Produk', routeName: 'products.index', pattern: 'products.*' },
    { label: 'Dashboard', routeName: 'dashboard' },
    { label: 'Tentang', routeName: 'tentang' },
];
</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <aside class="flex w-64 flex-col bg-gray-800 text-white">
            <div class="flex items-center gap-2 border-b border-gray-700 p-4">
                <ApplicationLogo class="h-8 w-8 fill-current text-white" />
                <span class="font-bold">Toko Sederhana</span>
            </div>

            <nav class="flex-1 space-y-1 p-3">
                <Link
                    v-for="m in menus"
                    :key="m.routeName"
                    :href="route(m.routeName)"
                    class="block rounded px-3 py-2 text-sm"
                    :class="route().current(m.pattern ?? m.routeName) ? 'bg-gray-700 font-semibold' : 'hover:bg-gray-700'"
                >
{{ m.label }}
                </Link>
            </nav>

            <div class="border-t border-gray-700 p-4 text-sm">
                <div>{{ user.name }}</div>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="mt-2 text-red-300 hover:text-red-200"
                >
                    Logout
                </Link>
            </div>
        </aside>

        <div class="flex flex-1 flex-col">
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="px-6 py-4">
                    <slot name="header" />
                </div>
            </header>

            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
