<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import moment from "moment/moment.js";
import FileBox from "@/Components/FileBox.vue";

defineProps({
    user: {
        type: Object,
    },
    notes: {
        type: Array
    }
});

const formatDate = (date) => {
    return moment(date).format('DD.MM.YYYY, HH:mm');
}
const deleteHomework = (id) => {
    if (confirm("Вы уверены, что хотите удалить конспект?")) {
        router.delete(route('admin.note.delete', {id}));
    }
}
</script>

<template>
    <Head title="Задания"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex gap-4 items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Конспекты ученика - {{ user.name }}</h2>
                <Link :href="route('users.show', {id: user.id })" as="button" class="max-w-32 px-2 border-gray-300 border rounded-xl hover:bg-gray-300 transition">Назад</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col items-center gap-4 px-2">
                    <Link :href="route('admin.note.create', {id: user.id})" as="button"
                          class="max-w-32 p-2 border-green-500 border rounded self-end hover:bg-green-500 transition">Добавить
                    </Link>
                    <span v-if="notes.data.length === 0">Конспектов у ученика нет</span>
                    <div class="flex max-lg:flex-col gap-4">
                        <FileBox v-for="note in notes.data" :key="note.id" :info="note" can-delete route-name="note.file.show" delete-route-name="admin.note.delete"/>
                    </div>
                    <div class="flex">
                        <template v-for="link in notes.links" :key="key">
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
