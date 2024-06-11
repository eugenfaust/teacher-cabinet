<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {Link, useForm} from '@inertiajs/vue3';


const props = defineProps(
    {
        id: {
            type: Number
        }
    }
)
const form = useForm({
    user_id: props.id,
    scheduled_at: new Date(),
});
const schedule = () => {
    form.post(route('admin.schedule.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <section>
        <form @submit.prevent="schedule" class="mt-6 space-y-6 flex flex-col">
            <InputError :message="form.errors.scheduled_at" class="mt-2" />
            <VueDatePicker timezone="Europe/Moscow" format="dd.MM.yyyy HH:mm" v-model="form.scheduled_at"></VueDatePicker>

            <div class="flex items-center gap-4 self-center">
                <PrimaryButton :disabled="form.processing">Добавить</PrimaryButton>
                <Link :href="route('admin.schedule.index', {id })" as="button" class="max-w-32 p-2 border-gray-300 border rounded hover:bg-gray-300 transition">Назад</Link>
            </div>
        </form>
    </section>
</template>
