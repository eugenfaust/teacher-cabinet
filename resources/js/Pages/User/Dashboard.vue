<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import moment from "moment";
import FileBox from "@/Components/FileBox.vue";

defineProps(
    {
        scheduled: {
            type: Object,
        },
        homeworks: {
            type: Array,
        },
        notes: {
            type: Array,
        },
    }
)
const formatDate = (date) => {
    return moment(date).fromNow();
}
</script>

<template>
    <Head title="Сводка"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Сводка</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-4">
                    <div v-if="scheduled">
                        <div class="flex items-center gap-2 self-center" v-if="scheduled.scheduled_at > new Date()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-12 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <span>Ближайшее занятие через {{ formatDate(scheduled.scheduled_at)}}</span>
                        </div>
                        <span v-else class="self-center text-xl">Запланированных занятий пока нет.</span>
                    </div>
                    <div class="flex justify-around gap-5 lg:gap-2 flex-col lg:flex-row mt-5">
                        <div class="flex flex-col justify-center gap-2 items-center">
                            <span class="font-semibold">Последние конспекты</span>
                            <div class="flex gap-2 flex-col">
                                <FileBox v-for="note in notes" :key="note.id" :info="note" route-name="note.file.show"/>
                            </div>
                            <span v-if="notes.length === 0">Конспектов пока нет.</span>
                        </div>
                        <div class="flex flex-col justify-center gap-2 items-center">
                            <span class="font-semibold">Последние задания</span>
                            <div class="flex flex-col gap-2">
                                <FileBox v-for="homework in homeworks" :key="homework.id" :info="homework"
                                         route-name="homework.file.show"/>
                            </div>
                            <span v-if="homeworks.length === 0">Заданий пока нет.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
