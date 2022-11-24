<script>
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { useToast } from "vue-toastification";
import _ from 'lodash';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { useForm } from '@inertiajs/inertia-vue3'
const toast = useToast();

export default {
    name: 'Criar Habbo',
    components: {
        AuthenticatedLayout,
        Head,
    },
    data() {
        return {
            editor: ClassicEditor,
            editorData: '<p>Digite aqui tudo sobre o hotel.</p>',
            editorConfig: {
                language: 'pt_BR',
            },
            habbo: useForm({
                image: null,
                name: null,
                description: null,
                domain: null,
                players: null,
                events_time: null,
                staff_vacancy: null,
            }),
        }
    },
    mounted() {
        toast.success("Portal carregado com sucesso...", {
            timeout: 2000
        });
    },
    methods: {
        storeHabbo: function () {
            this.habbo.post(route('admin.portal.habbo.store'), {
                habbo: this.habbo,
                onSuccess: () => {
                    toast.success("Habbo salvo com sucesso...", {
                        timeout: 2000
                    });
                },
                onError: (errors) => {
                    console.log(errors);
                    toast.error("Erro ao salvar o habbo...", {
                        timeout: 2000
                    });
                },
            });
        },
    }
} 
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="flex justify-end">
                <div class="mb-4 flex items-center gap-3">
                    <button @click.prevent="storeHabbo"
                        class="hover:shadow-form rounded-md bg-black py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Salvar
                    </button>
                </div>
            </div>
            <div class="mb-3 mt-3 bg-red-500 p-2 rounded-md">
            <p class="text-white">Todo hotel criado, será marcado como pendente. Uma ação manual é necessária para publicar o hotel.</p>
            </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="flex gap-2 items-stretch">
                <div class="col-6 md:col-md-8">
                    <!-- DIRECT CHAT -->
                    <div class="card direct-chat direct-chat-primary h-full">
                        <div class="card-header">
                            <h3 class="card-title">Criando Hotel</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="flex items-center justify-center p-12">
                                <!-- Author: FormBold Team -->
                                <!-- Learn More: https://formbold.com -->
                                <div class="mx-auto w-full max-w-[550px]">
                                    <div class="-mx-3 flex flex-wrap">
                                        <div class="w-full px-3 sm:w-1/2">
                                            <div class="mb-3">
                                                <label for="fName" class="mb-3 block text-base font-medium">
                                                    Nome
                                                </label>
                                                <input type="text" name="fName" id="fName" v-model="habbo.name"
                                                    placeholder="Nome do Habbo"
                                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                                <div v-if="habbo.errors.name" class="text-red-500">{{
                                                        habbo.errors.name
                                                }}</div>
                                            </div>

                                        </div>
                                        <div class="w-full px-3 sm:w-1/2">
                                            <div class="mb-3">
                                                <label for="lName" class="mb-3 block text-base font-medium">
                                                    Domínio
                                                </label>
                                                <input type="text" name="lName" id="lName" placeholder=""
                                                    v-model="habbo.domain"
                                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                                <div v-if="habbo.errors.domain" class="text-red-500">{{
                                                        habbo.errors.domain
                                                }}</div>
                                            </div>

                                        </div>

                                        <div class="w-full px-3">
                                            <div class="mb-3">
                                                <label for="lName" class="mb-3 block text-base font-medium">
                                                    Descrição
                                                </label>
                                                <ckeditor :editor="editor" v-model="habbo.description"
                                                    :config="editorConfig"></ckeditor>
                                                <div v-if="habbo.errors.description" class="text-red-500">{{
                                                        habbo.errors.description
                                                }}</div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="guest" class="mb-3 block text-base font-medium">
                                            Quantos jogadores?
                                        </label>
                                        <input type="number" name="guest" id="guest" placeholder="5" min="0"
                                            v-model="habbo.players"
                                            class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                        <div v-if="habbo.errors.players" class="text-red-500">{{
                                                habbo.errors.players
                                        }}</div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- /.card-body-->
                    </div>
                    <!--/.direct-chat -->

                </div>

                <div class="col-md-6">

                    <div class="card direct-chat direct-chat-primary h-full">
                        <div class="card-header">
                            <h3 class="card-title">Informações extras</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="flex items-center justify-center p-12">
                                <!-- Author: FormBold Team -->
                                <!-- Learn More: https://formbold.com -->
                                <div class="mx-auto w-full max-w-[550px]">
                                    <div class="-mx-3 flex flex-wrap">
                                        <div class="w-full px-3 sm:w-1/2">
                                            <div class="mb-3">
                                                <label for="date" class="mb-3 block text-base font-medium">
                                                    Inauguração
                                                </label>
                                                <input type="date" name="date" id="date"
                                                    v-model="habbo.inauguration_date"
                                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                                <div v-if="habbo.errors.inauguration_date" class="text-red-500">{{
                                                        habbo.errors.inauguration_date
                                                }}</div>
                                            </div>
                                        </div>
                                        <div class="w-full px-3 sm:w-1/2">
                                            <div class="mb-3">
                                                <label for="time" class="mb-3 block text-base font-medium">
                                                    Tempo Eventos:
                                                </label>
                                                <input type="time" name="time" id="time" v-model="habbo.events_time"
                                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                                <div v-if="habbo.errors.events_time" class="text-red-500">{{
                                                        habbo.errors.events_time
                                                }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="mb-3 block text-base font-medium">
                                            Vagas para Staff?
                                        </label>
                                        <div class="flex items-center space-x-6">
                                            <div class="flex items-center">
                                                <input type="radio" name="radio1" id="radioButton1" value="1"
                                                    class="h-5 w-5" :checked="habbo.staff_vacancy == 1"
                                                    v-model="habbo.staff_vacancy" />
                                                <label for="radioButton1" class="pl-3 text-base font-medium">
                                                    Sim
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" name="radio1" id="radioButton2" value="0"
                                                    class="h-5 w-5" :checked="habbo.staff_vacancy == 0"
                                                    v-model="habbo.staff_vacancy" />
                                                <label for="radioButton2" class="pl-3 text-base font-medium">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                        <div v-if="habbo.errors.staff_vacancy" class="text-red-500">{{
                                                habbo.errors.staff_vacancy
                                        }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="mb-3 block text-base font-medium">
                                            Status
                                        </label>
                                        <div class="flex items-center space-x-6">
                                            <div class="flex items-center">
                                                <input type="radio" name="status" value="1" id="radioButton3"
                                                    class="h-5 w-5" :checked="habbo.status == 1"
                                                    v-model="habbo.status" />
                                                <label for="radioButton1" class="pl-3 text-base font-medium">
                                                    Ativo
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" name="status" value="0" id="radioButton3"
                                                    class="h-5 w-5" :checked="habbo.status == 0"
                                                    v-model="habbo.status" />
                                                <label for="radioButton2" class="pl-3 text-base font-medium">
                                                    Inativo
                                                </label>
                                            </div>
                                        </div>
                                        <div v-if="habbo.errors.status" class="text-red-500">{{
                                                habbo.errors.status
                                        }}</div>
                                    </div>

                                    <div class="mb-6 pt-4">
                                        <label class="mb-2 block text-md font-semibold text-black">
                                            Adicionar Imagem
                                        </label>

                                        <div class="mb-8">
                                            <input type="file" name="file" id="file" class="sr-only" />
                                            <label for="file"
                                                class="relative flex min-h-[200px] items-center justify-center rounded-md border border-dashed border-[#e0e0e0] p-12 text-center">
                                                <div>
                                                    <span class="mb-2 block text-xl font-semibold text-black">
                                                        Arraste arquivos aqui
                                                    </span>
                                                    <span class="mb-2 block text-base font-medium text-[#6B7280]">
                                                        Ou
                                                    </span>
                                                    <span
                                                        class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-black">
                                                        Procure
                                                    </span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="mb-3 rounded-md bg-[#F5F7FB] py-4 px-8">
                                            <div class="flex items-center justify-between">
                                                <span class="truncate pr-3 text-base font-medium text-black">
                                                    banner-design.png
                                                </span>
                                                <button class="text-black">
                                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Table with habbo informations -->

            </div>
    </AuthenticatedLayout>
</template>
