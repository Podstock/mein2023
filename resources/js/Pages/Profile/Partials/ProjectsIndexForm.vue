<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3'
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const projects = ref();

async function new_project() {
    await axios.post('/projects', {});
    update();
}

async function destroy(project) {
    await axios.delete('/projects/' + project.id);
    update();
}

function uploaded(project) {
    save(project);
    update();
}

function updateProjectImage(project, photo)
{
    if (! photo) return;

    const reader = new FileReader();

    project.logo = photo

    reader.onload = (e) => {
        project.logo_preview = e.target.result;
    };

    reader.readAsDataURL(photo);

}

function save(project) {
    project.post('/projects/' + project.id, { preserveScroll: true });
}

function update() {
    axios.get('/projects').then(({ data }) => {
        projects.value = [];

        data.data.map((project, index) => {
            projects.value.push(useForm({
                _method: 'PUT',
                id: project.id,
                name: project.name,
                url: project.url,
                logo: project.logo,
                logo_preview: project.logo
            }));
        });
    });
}

onMounted(() => {
    update();
});
</script>

<template>
    <h3 class="text-lg font-medium text-gray-900">
        Deine Projekte
    </h3>
    <FormSection @submit.prevent="save(project)" v-for="(project, index) in projects" class="mb-6" key="project.id">
        <template #description v-if="index == 0">
            Aktualisiere deine Projekte
        </template>

        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Projekt Name" />
                <TextInput id="name" v-model="project.name" type="text" class="mt-1 block w-full" />
                <InputError :message="project.errors.name" class="mt-2" />
            </div>
            <!-- URL -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="url" value="Projekt URL" />
                <TextInput id="url" v-model="project.url" type="text" class="mt-1 block w-full"
                    placeholder="https://example.net" />
                <InputError :message="project.errors.url" class="mt-2" />
            </div>
            <!-- Logo -->
            <div class="col-span-6 sm:col-span-4">
                <img v-if="project.logo_preview" :src="project.logo_preview" class="w-24 h-24" />
                <input type="file" @input="updateProjectImage(project, $event.target.files[0])">
            </div>
        </template>

        <template #actions>
            <div class="flex justify-between w-full">
                <PrimaryButton type="button" @click="destroy(project)" class="bg-red-700 ">
                    Löschen
                </PrimaryButton>
                <div class="flex items-center">
                    <ActionMessage :on="project.recentlySuccessful" class="mr-3">
                        Gesichert.
                    </ActionMessage>
                    <PrimaryButton class="bg-lime-700 hover:bg-lime-800" :class="{ 'opacity-25': project.processing }" :disabled="project.processing">
                        Speichern
                    </PrimaryButton>
                </div>
            </div>
        </template>
    </FormSection>
    <div class="flex justify-end mt-6">
        <PrimaryButton @click="new_project()">
            Neues Projekt
        </PrimaryButton>
    </div>
</template>
