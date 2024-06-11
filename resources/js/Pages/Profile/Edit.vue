<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head, usePage} from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
const user = usePage().props.auth.user;
const telegramBot = `https://t.me/${import.meta.env.VITE_APP_TELEGRAM_BOT}/?start=${user.tg_hash}`;
</script>

<template>
    <Head title="Профиль"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Профиль</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl"/>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Телеграм бот</h2>
                    </header>

                    <div class="flex flex-col gap-1 mt-5">
                        <span class="text-xl font-semibold">Статус бота: {{ user.tg_id === 0 ? "не"  : ""}} привязан</span>
                        <span class="text-lg" v-if="user.tg_id !== 0">Ваш телеграм ID: {{ user.tg_id }}</span>
                        <span>Для смены аккаунта или первой привязке бота перейдите по ссылке и нажмите кнопку "Старт"</span>
                        <a :href="telegramBot" class="underline">Привязать</a>
                        <span>С подключенным телеграм ботом Вы будете получать уведомления о новых заданиях, конспектах и запланированных занятиях</span>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
