<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import moment from "moment";
import FileBox from "@/Components/FileBox.vue";

defineProps(
    {
        homeworks: {
            type: Array,
        },
    }
)
</script>

<template>
    <Head title="Задания"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Задания</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-4">
                    <div class="flex  gap-5 lg:gap-2 flex-col items-center">
                        <div class="flex flex-col justify-center gap-2 items-center">
                            <span class="font-semibold">Последние задания</span>
                            <div class="flex flex-col lg:flex-row gap-2">
                                <FileBox v-for="homework in homeworks.data" :key="homework.id" :info="homework"
                                         route-name="homework.file.show"/>
                            </div>
                        </div>
                        <div class="flex mt-2">
                            <template v-for="link in homeworks.links" :key="key">
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
        </div>
    </AuthenticatedLayout>
</template>
