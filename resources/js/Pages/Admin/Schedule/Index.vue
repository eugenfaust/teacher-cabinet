<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import moment from "moment/moment.js";

defineProps({
    user: {
        type: Object,
    },
    closest_schedule: {
        type: Object,
    },
    schedules: {
        type: Array
    }
});

const formatDate = (date) => {
    return moment(date).format('DD.MM.YYYY, HH:mm');
}
const deleteSchedule = (id) => {
    if (confirm("Вы уверены, что хотите удалить урок?")) {
        router.delete(route('admin.schedule.delete', {id}));
    }
}
</script>

<template>
    <Head title="Ученики"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex gap-4 items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ученик - {{ user.name }}</h2>
                <Link :href="route('users.show', {id: user.id })" as="button" class="max-w-32 px-2 border-gray-300 border rounded-xl hover:bg-gray-300 transition">Назад</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="route('admin.schedule.create', {id: user.id})" as="button"
                          class="max-w-32 p-2 border-green-500 border rounded self-end hover:bg-green-500 transition">Добавить
                    </Link>
                    <span v-if="schedules.data.length === 0">Занятий у ученика нет</span>
                    <span v-else>Ближайшее занятие: {{ formatDate(closest_schedule.scheduled_at) }}</span>
                    <div class="p-2 border-gray-400 border rounded-xl flex flex-col" v-for="schedule in schedules.data">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" fill="currentColor" class="cursor-pointer h-6 w-6 self-end -mb-2 -mt-4 -mr-5 text-red-500" @click="deleteSchedule(schedule.id)">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                        </svg>


                        <span>{{ formatDate(schedule.scheduled_at) }}</span>
                    </div>
                    <div class="flex">
                        <template v-for="link in schedules.links" :key="key">
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
