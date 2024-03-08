<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const onSuccess = ref(false);
const onError = ref(false);

const emit = defineEmits(['linkSubDepartment','linkWithUser']);

const props = defineProps({
    user: Object,
    edition: {
        type:Boolean,
        default:false
    }
});

const form = useForm({
    name: props.user.name,
    email: props.user.email
});

const submit = () =>{
    form.put(route('user.update',[props.user.id]),{
        onSuccess: () => {
            onSuccess.value = true;
            setTimeout(()=> onSuccess.value = false,2000);
        },
        onError: () => {
            onError.value = true;
            setTimeout(()=> onError.value = false,2000);
        }
    });
}


</script>
<template>
<div class="card w-auto bg-base-100 shadow-xl motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
    <Link :href="route('user.show', [user.id])">
        <figure><img :src="`https://picsum.photos/id/${user.id}/380/360`" alt="Shoes" /></figure>
    </Link>
    <div class="card-body">
            <h2 v-if="!edition" class="card-title">{{user.name}}</h2>
            <form @submit.prevent="submit" v-else>
                <div class="grid grid-cols-1 gap-2">
                    <label class="input input-bordered flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" /></svg>
                        <input type="text" class="grow" placeholder="Name" v-model="form.name"/>
                        <span v-show="onError" class="label-text-alt text-red-500">{{ form.errors.name }}</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" /><path d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" /></svg>
                        <input type="email" class="grow" placeholder="Email" v-model="form.email"/>
                        <span v-show="onError" class="label-text-alt text-red-500">{{ form.errors.email }}</span>
                    </label>
                    <button class="mx-2 btn btn-success" :class="{ 'opacity-25': form.processing }" type="submit">
                        Save
                    </button>
                </div>
             </form>
             <ul class="card-actions">
                <div class="grid grid-rows-1">
                    <div :class="[edition && 'tooltip']" data-tip="Link Department">
                        <button :class="[!edition && 'btn-disabled']"  class="btn btn-block" @click="emit('linkSubDepartment')">
                            Departments:
                            <div class="badge badge-info">{{user?.departments_count}}</div>
                        </button>
                    </div>
                </div>
            </ul>
    </div>
</div>
</template>