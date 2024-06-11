<script setup>
import {Head, Link} from '@inertiajs/vue3';

const author = import.meta.env.VITE_APP_AUTHOR;
const authorTelegram = import.meta.env.VITE_APP_AUTHOR_TELEGRAM;
defineProps({
    canLogin: {
        type: Boolean,
    },
});

</script>

<template>
    <Head title="Главная"/>

    <div
        class="relative min-h-screen flex flex-col items-center justify-center"
    >
        <div class="relative w-full max-w-2xl lg:max-w-7xl flex flex-col  min-h-screen">
            <header class="items-center p-2 bg-gray-400 flex justify-between text-white">
                <div class="flex gap-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-8 h-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                    </svg>
                    <span>Кабинет учителя</span>
                </div>
                <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                    <div v-if="$page.props.auth.user">
                        <Link
                            v-if="$page.props.auth.user.is_admin"
                            :href="route('users.index')"
                            class="rounded-md px-3 py-2 ring-1 ring-transparent"
                        >
                            Кабинет
                        </Link>
                        <Link
                            v-else
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 ring-1 ring-transparent"
                        >
                            Кабинет
                        </Link>
                    </div>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="rounded-md px-3 py-2 ring-1 ring-transparent"
                        >
                            Войти
                        </Link>
                    </template>
                </nav>
            </header>

            <main class="mt-6 self-center">
                <div class="flex flex-col gap-5">
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center p-5 border-2 rounded-xl border-gray-500 max-w-xs w-full">
                            <span class="text-center text-xl">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur cum dicta hic impedit magni maiores, non, pariatur placeat provident, ratione suscipit ut voluptatibus? Deleniti doloribus fuga minus rerum totam?</span>
                        </div>
                        <div class="flex flex-col items-center p-5 border-2 rounded-xl border-gray-500 max-w-xs w-full">
                            <span class="text-center text-xl">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur cum dicta hic impedit magni maiores, non, pariatur placeat provident, ratione suscipit ut voluptatibus? Deleniti doloribus fuga minus rerum totam?</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center p-5 border-2 rounded-xl border-gray-500 max-w-[40rem] self-center w-full">
                        <span class="text-center text-xl">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur cum dicta hic impedit magni maiores, non, pariatur placeat provident, ratione suscipit ut voluptatibus? Deleniti doloribus fuga minus rerum totam?</span>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center p-5 border-2 rounded-xl border-gray-500 max-w-xs w-full">
                            <span class="text-center text-xl">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur cum dicta hic impedit magni maiores, non, pariatur placeat provident, ratione suscipit ut voluptatibus? Deleniti doloribus fuga minus rerum totam?</span>
                        </div>
                        <div class="flex flex-col items-center p-5 border-2 rounded-xl border-gray-500 max-w-xs w-full">
                            <span class="text-center text-xl">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur cum dicta hic impedit magni maiores, non, pariatur placeat provident, ratione suscipit ut voluptatibus? Deleniti doloribus fuga minus rerum totam?</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center p-5 border-2 rounded-xl border-gray-500 max-w-[40rem] self-center w-full">
                        <span class="text-center text-xl">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur cum dicta hic impedit magni maiores, non, pariatur placeat provident, ratione suscipit ut voluptatibus? Deleniti doloribus fuga minus rerum totam?</span>
                    </div>
                </div>
            </main>

            <footer class="py-16 text-center text-sm text-black">
                Разработчик - <a :href="authorTelegram" class="underline">{{ author }}</a>
            </footer>
        </div>
    </div>
</template>
