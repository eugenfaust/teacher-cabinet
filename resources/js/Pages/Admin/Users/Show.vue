<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import moment from "moment";
import { router} from "@inertiajs/vue3";

defineProps({
    user: {
        type: Object,
    },
});

function deleteUser(id) {
    if (confirm("Вы уверены, что хотите удалить пользователя?")) {
        router.delete(`delete/${id}`);
    }
}
</script>

<template>
    <Head :title="user.name"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex gap-4 items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ученик - {{ user.name }}</h2>
                <Link :href="route('users.index')" as="button" class="max-w-32 px-2 border-gray-300 border rounded-xl hover:bg-gray-300 transition">Назад</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col items-center gap-4">
                    <span>Имя: {{ user.name }}</span>
                    <span>Email: {{ user.email }}</span>
                    <span>Добавлен: {{ moment(user.created_at).format('DD.MM.YYYY, HH:mm') }}</span>
                    <div class="flex gap-2">
                        <Link :href="route('admin.schedule.index', {'user': user.id})" as="button" class="max-w-32 p-2 border-blue-500 border rounded hover:bg-blue-500 transition">Расписание</Link>
                        <Link :href="route('admin.homework.index', {'user': user.id})" as="button" class="max-w-32 p-2 border-blue-500 border rounded hover:bg-blue-500 transition">Задания</Link>
                        <Link :href="route('admin.note.index', {'user': user.id})" as="button" class="max-w-32 p-2 border-blue-500 border rounded hover:bg-blue-500 transition">Конспекты</Link>
                    </div>
                    <div class="flex gap-2">
                        <button @click="deleteUser(user.id)" class="max-w-32 p-2 border-red-500 border rounded hover:bg-red-500 transition">Удалить</button>
                        <Link :href="route('users.edit', {'id': user.id})" as="button" class="max-w-32 p-2 border-green-500 border rounded hover:bg-green-500 transition">Изменить</Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
