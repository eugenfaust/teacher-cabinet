<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import {onMounted, ref} from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const emailInput = ref(null);
const nameInput = ref(null);
const props = defineProps({
    user: {
        type: Object
    }
});
const form = useForm({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    password: undefined,
    password_confirmation: undefined,
});
const updatePassword = () => {
    form.put(route('users.update'), {
        preserveScroll: true,
        // onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.email) {
                emailInput.value.focus();
            }
            if (form.errors.name) {
                nameInput.value.focus();
            }
        },
    });
};

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Обновление ученика - {{ user.name }}</h2>


        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6 flex flex-col">
            <div>
                <InputLabel for="name" value="Имя" />

                <TextInput
                    id="name"
                    ref="nameInput"
                    v-model="form.name"
                    :default="user.name"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div>
                <InputLabel for="email" value="E-mail" />

                <TextInput
                    id="email"
                    ref="emailInput"
                    v-model="form.email"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password" value="Пароль" />
                <InputLabel for="password" value="Если пароль не нужно менять - не трогайте эти поля" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Подтвердите пароль" />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div class="flex items-center gap-4 self-center">
                <PrimaryButton :disabled="form.processing">Обновить</PrimaryButton>

            </div>
        </form>
    </section>
</template>
