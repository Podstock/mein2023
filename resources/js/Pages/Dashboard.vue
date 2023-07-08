<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Chat from "@/Components/Chat.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Chat />
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="border-t border-gray-300"></div>
        </div>
        <div class="px-12 mb-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mastodon - Social Media Posts
            </h2>
        </div>
        <iframe
            style="position: absolute; height: 100%; border: none"
            class="w-full"
            scrolling="yes"
            src="https://rstockm.github.io/mastowall/?hashtags=podstock,podstockde&server=https://mastodon.social"
        ></iframe>
    </AppLayout>
</template>
