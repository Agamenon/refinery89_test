<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const onSuccess = ref(false);
const onError = ref(false);

const emit = defineEmits(['linkSubDepartment','linkWithUser']);

const props = defineProps({
    department: Object,
    edition: {
        type:Boolean,
        default:false
    }
});

const form = useForm({
    name: props.department.name,
});

const submit = () =>{
    form.put(route('department.update',[props.department.id]),{
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
    <Link :href="route('department.show', [department.id])">
        <figure><img :src="`https://via.assets.so/furniture.png?id=${department.id}&q=95&w=280&h=280&fit=fill`" alt="Shoes" /></figure>
    </Link>
    <div class="card-body">
            <h2 v-if="!edition" class="card-title">{{department.name}}</h2>
            <form @submit.prevent="submit" v-else>
                <div class="m-2">
                    <input type="text" placeholder="Department Name" class="input input-bordered input-md w-full max-w-xs" v-model="form.name" />
                    <span v-show="onError" class="text-red-500">{{ form.errors.name }}</span>
                    <span v-show="onSuccess" class="text-green-500">successfully updated</span>
                </div>
                <div class="grid grid-cols-1">
                    <button class="btn btn-block btn-secondary" :class="{ 'opacity-25': form.processing }" type="submit">
                        Update
                    </button>
                </div>
             </form>
             <ul class="card-actions grid grid-rows-3">
                <div class="grid grid-cols-2 gap-1">
                    <div :class="[edition && 'tooltip']" data-tip="Link User">
                        <button  :class="[!edition && 'btn-disabled']" class="btn btn-block" @click="emit('linkWithUser')">
                            Users:
                            <div class="badge badge-info">{{department?.users_count}}</div>
                        </button>
                    </div>
                    <button :class="[!edition && 'btn-disabled']" class="btn">
                        Sub:
                        <div class="badge">{{department.child_departments_count}}</div>
                    </button>
                </div>
                <div :class="[edition && 'tooltip']" data-tip="Change Parent">
                    <button  :class="[!edition && 'btn-disabled']" class="btn btn-block" @click="emit('linkSubDepartment')" title="Change">
                        Parent:
                        <div class="badge badge-secondary">{{department?.parent_department?.name ?? "Unlinked"}}</div>
                    </button>
                </div>
            </ul>
    </div>
</div>
</template>