<script setup>
import {router} from "@inertiajs/vue3";
import moment from "moment";

const props = defineProps({
    info: {
        type: Object,
    },
    canDelete: {
        type: Boolean
    },
    routeName: {
        type: String
    },
    deleteRouteName: {
        type: String
    }
});
const formatDate = (date) => {
    return moment(date).format('DD.MM.YYYY, HH:mm');
}
const deleteHomework = (id) => {
    if (confirm("Вы уверены, что хотите удалить?")) {
        router.delete(route(props.deleteRouteName, {id}));
    }
}
</script>

<template>
    <div class="p-2 border-gray-400 justify-between border rounded-xl flex flex-col max-w-sm text-center" >
        <svg xmlns="http://www.w3.org/2000/svg" v-if="canDelete"  viewBox="0 0 24 24" fill="currentColor" class="cursor-pointer h-6 w-6 self-end -mb-2 -mt-4 -mr-5 text-red-500" @click="deleteHomework(info.id)">
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
        </svg>
        <span class="text-2xl font-semibold self-center">{{info.title}}</span>
        <div class="flex gap-2 justify-center">
            <a :href="route(routeName, file.id)" v-for="file in info.files" :key="file.id" class="flex flex-col gap-1 items-center cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>

                <span class="text-sm">{{ file.original_name }}</span>
            </a>
        </div>
        <span class="self-end mt-2">Добавлено: {{ formatDate(info.created_at) }}</span>
    </div>
</template>
