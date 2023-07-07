<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, router, Link } from '@inertiajs/vue3'


let props = defineProps({
    boardentries: Object,
});

const form = useForm({
    content: "",
});

let deleteEntry = (id) => {
    router.delete("/boardentries/" + id, {
        onBefore: () => confirm('Möchtest du den Eintrag wirklich löschen?'),
        preserveScroll: true,
    });

}

</script>

<template>
    <AppLayout title="Pinnwand">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pinnwand
            </h2>
        </template>

        <div class="max-w-7xl mx-auto pt-4 px-1 sm:px-4 lg:px-8">

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div v-for="entry in boardentries.data" :key="entry.id"
                    class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex space-x-3">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" :src="entry.avatar" alt="" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div v-html="entry.content" class="prose text-sm font-medium text-gray-900">
                        </div>
                        <div class="mt-2 flex justify-between items-baseline">
                        <p class="text-sm text-gray-500 truncate">
                            <Link :href="'/users/#' + entry.user_id" class="font-bold text-gray-900">{{ entry.name }}
                            </Link>
                        </p>
                        <a href="#" @click="answerEntry(entry.id)"
                            class="hidden text-base text-lime-800 hover:text-lime-900">Antworten
                        </a>
                        </div>
                    </div>
                    <div>
                        <a v-if="entry.user_id == $page.props.auth.user.id" href="#" @click="deleteEntry(entry.id)"
                            class="text-red-700 hover:text-red-900">Löschen
                        </a>
                    </div>
                </div>
            </div>

            <form @submit.prevent="form.post('/boardentries', { onSuccess: () => form.reset() })"
                class="mt-8 sm:w-1/2 mx-auto">
                <div class="text-gray-700">Ich suche/biete:</div>

                <div class="mt-2">
                    <div id="tabs-1-panel-1" class="p-0.5 -m-0.5 rounded-lg" aria-labelledby="tabs-1-tab-1"
                        role="tabpanel" tabindex="0">
                        <label for="comment" class="sr-only">Comment</label>
                        <div>
                            <textarea v-model="form.content" rows="5" name="comment" id="comment"
                                class="shadow-sm focus:ring-lime-500 focus:border-lime-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Schreibe was an die Pinnwand..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-2 flex justify-end">
                    <button :disabled="form.processing" type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-lime-700 hover:bg-lime-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500">Anheften</button>
                </div>
            </form>

        </div>
    </AppLayout>
</template>
