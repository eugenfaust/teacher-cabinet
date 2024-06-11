<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {Link, useForm} from '@inertiajs/vue3';
import {ref} from 'vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";


const props = defineProps(
    {
        id: {
            type: Number
        }
    }
)
const form = useForm({
    title: '',
    files: null,
    user_id: props.id,
});
const upload = () => {
    form.post(route('admin.note.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <section>
        <form @submit.prevent="upload" class="mt-6 space-y-6 flex flex-col">
            <div>
                <InputLabel for="password_confirmation" value="Название конспекта"/>

                <TextInput
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.title" class="mt-2"/>
            </div>
            <input type="file" @input="form.files = $event.target.files" multiple/>
            <InputError :message="form.errors.files" class="mt-2"/>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>
            <div class="flex items-center gap-4 self-center">
                <PrimaryButton :disabled="form.processing">Добавить</PrimaryButton>
                <Link :href="route('admin.note.index', { id })" as="button"
                      class="max-w-32 p-2 border-gray-300 border rounded hover:bg-gray-300 transition">Назад
                </Link>
            </div>
        </form>
    </section>
</template>
