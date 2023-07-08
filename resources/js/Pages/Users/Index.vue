<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ScrollTop from '@/Components/Top.vue';

let props = defineProps({
    users: Object
});

const extractMastodon = (mastodon) => {
  const urlParts = mastodon.split("/");
  return urlParts[urlParts.length - 1];
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Teilnehmer*innen
            </h2>
        </template>

        <div class="max-w-7xl mx-auto pt-4 px-1 sm:px-4 lg:px-8">
            <div class="flex flex-wrap -mx-1 lg:-mx-4">
                <div v-for="user in users.data" class="my-1 px-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/6 lg:my-4 lg:px-4 mb-6"
                    :key="user.id">
                    <article :id="user.id" class="target:border-lime-600 target:border-4 overflow-hidden rounded-lg shadow-md h-full bg-white">
                        <img v-if="user.avatar" :src="user.avatar" class="block h-auto w-full" loading="lazy" />
                        <header class="flex items-center justify-between leading-tight px-2 md:px-4 py-2">
                            <h1 class="text-lg">
                                <span class="text-gray-900">{{ user.name }}</span>
                            </h1>
                        </header>
                        <div class="flex flex-col text-xs px-2 md:px-4 border-b border-gray-300 pb-2">
                            <div v-if="user.mastodon" class="flex">
                                <svg viewBox="0 0 16 16" width="16" height="16"><path fill="#828282" d="M 15.659 9.592 C 15.424 10.72 13.553 11.956 11.404 12.195 C 10.283 12.32 9.18 12.434 8.003 12.384 C 6.079 12.302 4.56 11.956 4.56 11.956 C 4.56 12.13 4.572 12.297 4.595 12.452 C 4.845 14.224 6.478 14.33 8.025 14.379 C 9.586 14.429 10.976 14.02 10.976 14.02 L 11.04 15.337 C 11.04 15.337 9.948 15.884 8.003 15.984 C 6.93 16.039 5.598 15.959 4.047 15.576 C 0.683 14.746 0.104 11.4 0.015 8.006 C -0.012 6.998 0.005 6.048 0.005 5.253 C 0.005 1.782 2.443 0.765 2.443 0.765 C 3.672 0.238 5.782 0.017 7.975 0 L 8.029 0 C 10.221 0.017 12.332 0.238 13.561 0.765 C 13.561 0.765 15.999 1.782 15.999 5.253 C 15.999 5.253 16.03 7.814 15.659 9.592 Z M 13.124 5.522 L 13.124 9.725 L 11.339 9.725 L 11.339 5.646 C 11.339 4.786 10.951 4.35 10.175 4.35 C 9.317 4.35 8.887 4.867 8.887 5.891 L 8.887 8.124 L 7.113 8.124 L 7.113 5.891 C 7.113 4.867 6.683 4.35 5.825 4.35 C 5.049 4.35 4.661 4.786 4.661 5.646 L 4.661 9.725 L 2.876 9.725 L 2.876 5.522 C 2.876 4.663 3.111 3.981 3.582 3.476 C 4.067 2.971 4.703 2.712 5.493 2.712 C 6.406 2.712 7.098 3.039 7.555 3.695 L 8 4.39 L 8.445 3.695 C 8.902 3.039 9.594 2.712 10.507 2.712 C 11.297 2.712 11.933 2.971 12.418 3.476 C 12.889 3.981 13.124 4.663 13.124 5.522 Z" style="stroke:none;stroke-miterlimit:10;fill-rule:evenodd;"/></svg>
                                <a :href="user.mastodon" target="_blank" class="ml-1 truncate hover:underline">
                                    {{ extractMastodon(user.mastodon) }}
                                </a>
                            </div>
                            <div v-if="user.sendegate" class="flex mt-1">
                                <img src="/sendegate.png" width="16" />
                                <a :href="'https://sendegate.de/u/' + user.sendegate" target="_blank" class="ml-1 truncate hover:underline">
                                    {{ user.sendegate }}
                                </a>
                            </div>
                        </div>
                        <div class>
                            <div v-if="user.search" class="p-2 md:px-4 border-b border-gray-300">
                                <span class="font-bold">Ich suche:</span>
                                {{ user.search }}
                            </div>
                            <div v-if="user.offer" class="p-2 md:px-4 border-b border-gray-300">
                                <span class="font-bold">Ich biete:</span>
                                {{ user.offer }}
                            </div>
                        </div>
                        <footer class="p-2 md:p-4">
                            <a v-for="project in user.projects"
                                class="flex items-center no-underline hover:underline text-black mb-1"
                                :href="project.url" target="_blank">
                                <img v-if="project.logo" :src="project.logo" class="block h-10 w-10" loading="lazy" />
                                <p class="ml-2 text-sm truncate">{{ project.name }}</p>
                            </a>
                        </footer>
                    </article>
                </div>
            </div>
        </div>
    <ScrollTop />
    </AppLayout>
</template>
