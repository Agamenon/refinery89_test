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
    user_id: null
});

const users = computed(() => usePage().props.users);

const submit = () => {
    form.put(route('department.linkWithUser',{"department":props.department.id,"user":form.user_id}), {
    });
};

</script>
<template>
<Modal :show="open" @close="emit('close')">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Link With A User
        </h2>
        <form @submit.prevent="submit">
            <div class="mt-2">
                <select class="select select-primary w-full max-w-xs" v-model="form.user_id">
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select>
                <button class="mx-2 btn btn-success" :class="{ 'opacity-25': form.processing }" type="submit">
                    Link
                </button>
            </div>
        </form>
    </div>
</Modal>
</template>
