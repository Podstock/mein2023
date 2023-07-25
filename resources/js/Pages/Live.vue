<script setup>
import AppLayout from "@/Layouts/AppLayoutGuest.vue";
import CustomButton from "@/Components/CustomButton.vue";
import { ref, onMounted } from "vue";
import videojs from "video.js";
import "video.js/dist/video-js.css";

const video = ref(true);
const room = ref("hls/aussen");
let player;
const videoPlayer = ref();

function room_switch(value) {
    room.value = value;
    refresh_sources();
}

function refresh_sources() {
    if (video.value) {
        player.src({
            src: "https://live.podstock.de/" + room.value + ".m3u8",
            type: "application/x-mpegURL",
        });
    } else {
        player.src({
            src:
                "https://stream-master.studio-link.de/podstock2023" +
                room.value +
                ".mp3",
            type: "audio/mp3",
        });
    }
}

onMounted(() => {
    player = videojs(videoPlayer.value, {
        liveui: true,
        fluid: true,
        aspectRatio: "16:9",
    });
    refresh_sources();
});
</script>

<template>
    <AppLayout title="Live">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Live - Podstock
            </h2>
        </template>

        <div class="py-12">
            <div class="pb-8 mb-4 border-b lg:w-2/3 mx-auto">
                <video
                    ref="videoPlayer"
                    class="video-js vjs-default-skin"
                    controls
                    preload="auto"
                    poster="/images/video/preview_livestream.png"
                    data-setup="{}"
                >
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and
                        consider upgrading to a web browser that
                        <a
                            href="https://videojs.com/html5-video-support/"
                            target="_blank"
                            >supports HTML5 video</a
                        >
                    </p>
                </video>
                <div class="flex justify-between items-center mx-auto mt-4">
                    <div>
                        <CustomButton
                            @click="room_switch('hls/aussen')"
                            :class="{
                                'bg-lime-700 text-white hover:bg-lime-600':
                                    room == 'hls/aussen',
                            }"
                        >
                            Außenbühne
                        </CustomButton>
                        <CustomButton
                            @click="room_switch('hls/innen')"
                            :class="{
                                'bg-lime-700 text-white hover:bg-lime-600':
                                    room == 'hls/innen',
                            }"
                        >
                            Innenbühne
                        </CustomButton>
                    </div>
                </div>
                <h2 class="border-t mt-4 py-4 font-bold">Re-Live</h2>
                <CustomButton
                    @click="room_switch('hls_opening/aussen')"
                    :class="{
                        'bg-lime-700 text-white hover:bg-lime-600':
                            room == 'hls_opening/aussen',
                    }"
                >
                    Opening
                </CustomButton>

                <CustomButton
                    @click="room_switch('hls_slam/aussen')"
                    :class="{
                        'bg-lime-700 text-white hover:bg-lime-600':
                            room == 'hls_slam/aussen',
                    }"
                >
                    Podetry Slam
                </CustomButton>
                <CustomButton
                    @click="room_switch('hls/aussen')"
                    :class="{
                        'bg-lime-700 text-white hover:bg-lime-600':
                            room == 'hls/aussen',
                    }"
                >
                    Closing
                </CustomButton>
            </div>
        </div>
    </AppLayout>
</template>
