<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import CreateForm from "@/Pages/Admin/Note/Partials/CreateForm.vue";

defineProps({
    id: {
        type: Number
    }
});
</script>

<template>
    <Head title="Добавление урока"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавление конспекта</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex gap-2 flex-col items-center">
                    <CreateForm
                        :id="id"
                        class="max-w-xl"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
