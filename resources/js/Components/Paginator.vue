<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
 current_page: Number,
 prev_page: URL,
 next_page: URL,
});

</script>

<template>
    <div class="join">
        <Link v-show="prev_page" :href="prev_page" class="join-item btn">«</Link>
        <Link class="join-item btn">{{ current_page }}</Link>
        <Link v-show="next_page" :href="next_page" class="join-item btn">»</Link>
    </div>
</template>