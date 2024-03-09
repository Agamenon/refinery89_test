<script setup>
import { ref } from "vue";

const emit = defineEmits(['searching']);

const query = ref('');
const search = () => {
    emit('searching',query)
}
</script>
<template>
<div class="join">
    <div>
        <div>
            <input class="input input-bordered join-item" placeholder="Search" v-model="query" @keyup.enter="search"/>
        </div>
    </div>
    <div class="indicator">
        <button class="btn join-item" @click="search">Search</button>
    </div>
</div>
</template>
