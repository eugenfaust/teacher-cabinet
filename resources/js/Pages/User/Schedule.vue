<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import moment from "moment";
import FileBox from "@/Components/FileBox.vue";

defineProps(
    {
        schedules: {
            type: Array,
        },
    }
)

const formatDate = (date) => {
    return moment(date).format('HH:mm, DD.MM.YYYY');
}
</script>

<template>
    <Head title="Расписание"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Задания</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-4 items-center gap-4">
                    <span class="font-semibold text-xl">Всего запланировано занятий: {{ schedules.total }}</span>
                    <span class="p-2 border border-gray-400 rounded-xl hover:bg-gray-400 transition" v-for="schedule in schedules.data" :key="schedule.id">{{formatDate(schedule.scheduled_at)}}</span>
                    <div class="flex mt-2">
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
