<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ScrollTop from '@/Components/Top.vue';

import { onMounted } from 'vue';

onMounted(() => {
    let pretalx = document.createElement('script');
    pretalx.setAttribute('src', "https://pretalx.c3voc.de/subscribe11/schedule/widget/v2.de.js");
    document.head.appendChild(pretalx);
});

</script>

<template>
    <AppLayout title="Fahrplan">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fahrplan
            </h2>
        </template>

        <div class="py-4">
            <pretalx-schedule event-url="https://pretalx.c3voc.de/subscribe11/" locale="de"
                style="--pretalx-clr-primary: #3aa57c"></pretalx-schedule>
        </div>
        <ScrollTop />
    </AppLayout>
</template>
