<script setup>
import Modal from '@/Components/Modal.vue';
import { computed, ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
const emit = defineEmits(['close']);

const props = defineProps({
    department: Object,
    open:Boolean
});

const form = useForm({
    parent_department_id: null
})

const submit = () => {
    form.put(route('department.linkWithDepartment',{"department":props.department.id,"parentDepartment":form.parent_department_id}), {
        onSuccess: () => {
            form.reset();
            emit('close');
        },
    });
};

const departments = computed(()=> usePage().props.departments || []);

</script>
<template>
<Modal :show="open" @close="emit('close')" :maxWidth="sm">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Link With Another Department
        </h2>
        <form @submit.prevent="submit">
            <div class="mt-2">
                <select class="select select-primary w-full max-w-xs" v-model="form.parent_department_id">
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
