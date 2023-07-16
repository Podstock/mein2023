<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CustomButton from "@/Components/CustomButton.vue";
import { ref, onMounted } from "vue";
import videojs from "video.js";
import "video.js/dist/video-js.css";

const video = ref(true);
const room = ref("aussen");
const player = ref();
const videoPlayer = ref();

function innen() {
    room.value = "innen";
    refresh_sources();
}
function aussen() {
    room.value = "aussen";
    refresh_sources();
}

function refresh_sources() {
    if (video) {
        player.value.src({
            src: "https://live.podstock.de/hls/" + room.value + ".m3u8",
            type: "application/x-mpegURL",
        });
        player.value.play();
    } else {
        player.value.src({
            src:
                "https://stream-master.studio-link.de/podstock2023" +
                room.value +
                ".mp3",
            type: "audio/mp3",
        });
        player.value.play();
    }
}

onMounted(() => {
    player.value = videojs(
        videoPlayer.value,
        {
            liveui: true,
            fluid: true,
            aspectRatio: "16:9",
        },
        function onPlayerReady() {
            console.log("onPlayerReady", this);
        }
    );
    refresh_sources();
});
</script>

<template>
    <AppLayout title="Live">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Live
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
                            @click="aussen()"
                            :class="{
                                'bg-lime-700 text-white hover:bg-lime-600':
                                    room == 'aussen',
                            }"
                        >
                            Außenbühne
                        </CustomButton>
                        <CustomButton
                            @click="innen()"
                            :class="{
                                'bg-lime-700 text-white hover:bg-lime-600':
                                    room == 'innen',
                            }"
                        >
                            Innenbühne
                        </CustomButton>
                    </div>
                    <div>
                        <CustomButton
                            @click="video = true"
                            :class="{
                                'bg-lime-700 text-white hover:bg-lime-600':
                                    video,
                            }"
                        >
                            Video
                        </CustomButton>
                        <CustomButton
                            @click="video = false"
                            :class="{
                                'bg-lime-700 text-white hover:bg-lime-600':
                                    !video,
                            }"
                        >
                            Audio
                        </CustomButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
