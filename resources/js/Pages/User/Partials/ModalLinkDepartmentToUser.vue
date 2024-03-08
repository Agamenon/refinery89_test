<script setup>
import Modal from '@/Components/Modal.vue';
import { computed, ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
const emit = defineEmits(['close']);

const props = defineProps({
    user: Object,
    open:Boolean
});


const form = useForm({
    department_id: null
});

const departments = computed(() => usePage().props.departments);

const submit = () => {
    form.put(route('department.linkWithUser',{"department":form.department_id,"user":props.user.id}), {
    });
};

</script>
<template>
<Modal :show="open" @close="emit('close')">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Link With A Department
        </h2>
        <form @submit.prevent="submit">
            <div class="mt-2">
                <select class="select select-primary w-full max-w-xs" v-model="form.department_id">
                    <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.name }}</option>
                </select>
                <button class="mx-2 btn btn-success" :class="{ 'opacity-25': form.processing }" type="submit">
                    Link
                </button>
            </div>
        </form>
    </div>
</Modal>
</template>
