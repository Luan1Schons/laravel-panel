<script>
import AuthenticatedLayout from '@/Layouts/Portal/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { useToast } from "vue-toastification";
import _ from 'lodash';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { useForm } from '@inertiajs/inertia-vue3'
const toast = useToast();

export default {
    name: 'Dashboard',
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
            editHabbo: false,
            habbo: useForm({
                image: null,
                name: null,
                description: null,
                domain: null,
                players: null,
                events_time: null,
                staff_vacancy: null,
            }),
            habboList: {},
        }
    },
    props: {
        habboData: Object,
    },
    mounted() {
        this.habboList = this.habboData;
        toast.success("Portal carregado com sucesso...", {
            timeout: 2000
        });
    },
    methods: {
        storeHabbo: function () {
            this.habbo.post(route('portal.habbo.store'), {
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
        updateHabbo: function () {
            this.habbo.post(route('portal.habbo.update'), {
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
        editHabboAction: function () {
            this.editHabbo = true;
            this.habbo = useForm(this.habboData.data[0]);
            console.log(this.habbo)
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

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->

            <section class="connectedSortable w-screen">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <!-- DIRECT CHAT -->
                        <div class="card direct-chat direct-chat-primary">
                            <div class="card-header">
                                <h3 class="card-title">Cadastrar Novo Hotel</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="flex items-center justify-center p-12" v-if="!habbo || editHabbo == true">
                                    <!-- Author: FormBold Team -->
                                    <!-- Learn More: https://formbold.com -->
                                    <div class="mx-auto w-full max-w-[550px]">
                                        <form action="https://formbold.com/s/FORM_ID" method="POST">
                                            <div class="-mx-3 flex flex-wrap">
                                                <div class="w-full px-3 sm:w-1/2">
                                                    <div class="mb-5">
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
                                                    <div class="mb-5">
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
                                                    <div class="mb-5">
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


                                            <div class="mb-5">
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

                                            <div class="-mx-3 flex flex-wrap">
                                                <div class="w-full px-3 sm:w-1/2">
                                                    <div class="mb-5">
                                                        <label for="date" class="mb-3 block text-base font-medium">
                                                            Data de Inauguração
                                                        </label>
                                                        <input type="date" name="date" id="date"
                                                            v-model="habbo.inauguration_date"
                                                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                                        <div v-if="habbo.errors.inauguration_date" class="text-red-500">
                                                            {{
                                                                    habbo.errors.inauguration_date
                                                            }}</div>
                                                    </div>
                                                </div>
                                                <div class="w-full px-3 sm:w-1/2">
                                                    <div class="mb-5">
                                                        <label for="time" class="mb-3 block text-base font-medium">
                                                            Eventos em quanto tempo?
                                                        </label>
                                                        <input type="time" name="time" id="time"
                                                            v-model="habbo.events_time"
                                                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                                        <div v-if="habbo.errors.events_time" class="text-red-500">{{
                                                                habbo.errors.events_time
                                                        }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-5">
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



                                            <div class="mb-6 pt-4">
                                                <label class="mb-5 block text-xl font-semibold text-black">
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
                                                            <span
                                                                class="mb-2 block text-base font-medium text-[#6B7280]">
                                                                Ou
                                                            </span>
                                                            <span
                                                                class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-black">
                                                                Procure
                                                            </span>
                                                        </div>
                                                    </label>
                                                </div>

                                                <div class="mb-5 rounded-md bg-[#F5F7FB] py-4 px-8">
                                                    <div class="flex items-center justify-between">
                                                        <span class="truncate pr-3 text-base font-medium text-black">
                                                            banner-design.png
                                                        </span>
                                                        <button class="text-[#07074D]">
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

                                            <div class="mt-5">
                                                <button @click.prevent="storeHabbo" v-if="editHabbo == false"
                                                    class="hover:shadow-form rounded-md bg-blue-500 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                                                    Criar
                                                </button>
                                                <button @click.prevent="updateHabbo" v-else
                                                    class="hover:shadow-form rounded-md bg-blue-500 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                                                    Salvar
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div v-else class="p-2">
                                    Você já cadastrou um hotel.
                                </div>
                            </div>

                            <!-- /.card-body-->
                        </div>
                        <!--/.direct-chat -->

                        <!-- Table with habbo informations -->
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <p>Hoteis cadastrados</p>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">NOME</th>
                                                    <th scope="col">CLIQUES</th>
                                                    <th scope="col">BOOSTS</th>
                                                    <th scope="col">AÇÃO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="habbo, key in habboData.data" :key="key">
                                                    <th>{{ habbo.name }}</th>
                                                    <th>{{ habbo.likes }}</th>
                                                    <th>{{ habbo.boosts }}</th>
                                                    <th><button class="bg-blue-500 px-2 rounded-md text-white"
                                                            @click="editHabboAction">EDITAR</button></th>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </section>
            <!-- /.Left col -->
        </div>
    </AuthenticatedLayout>
</template>
