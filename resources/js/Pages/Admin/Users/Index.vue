<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
defineProps({
    users: {
        type: Array,
    },
});
</script>

<template>
    <Head title="Ученики"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Список учеников</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex gap-2 flex-col items-center p-2">
                    <Link as="button" type="button" :href="route('users.create')" class="p-2 border-green-500 border rounded self-end hover:bg-green-500 transition">Добавить</Link>
                    <div class="flex gap-2 flex-col lg:flex-row">
                        <Link  as="button" type="button" v-for="user in users.data" class="p-2 border rounded hover:bg-gray-300 transition border-gray-300" :href="route('users.show', {'id': user.id})">
                            {{ user.name }}
                        </Link>
                    </div>
                    <span v-if="users.length === 0">Учеников не найдено.</span>
                    <div class="flex">
                        <template v-for="link in users.links" :key="key">
                            <div
                                v-if="link.url === null"
                                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                v-html="link.label"
                            />

                            <Link
                                v-else
                                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                                :class="{ 'bg-white': link.active }"
                                :href="link.url"
                                v-html="link.label"
                            />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
