<script>
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { useToast } from "vue-toastification";
const toast = useToast();

export default {
    name: 'Portal',
    components: {
        Head,
        Link,
        useForm,
        AuthenticatedLayout
    },
    data() {
        return {
            modalHabbo: false,
            habbos: {},
            tabListHabbo: 0,
            pagination: {
                habbos: '1',
            }
        }
    },
    created: function () {
        this.fetchHabbos();
    },
    methods: {
        fetchHabbos(filter = 'boosts') {
            axios.get(route('portal.habbos.list', { filter: filter })).then(response => {
                this.habbos = response.data;
            }).catch(error => {
                console.log(error);
            });
        },
        changeTab(tab) {
            this.tabListHabbo = tab;
            if (tab == 0) {
                this.fetchHabbos('boosts');
            } else if (tab == 1) {
                this.fetchHabbos('favorites');
            } else if (tab == 2) {
                this.fetchHabbos('all');
            }else if (tab == 3) {
                this.fetchHabbos('inactive');
            }
        },
        paginate(url, label) {
            this.pagination.habbos = label;
            axios.get(url).then(response => {
                this.habbos = response.data;
            }).catch(error => {
                console.log(error);
            });
        },
        openModalHabbo(habbo) {
            this.modalHabbo = habbo;
        },

    }
}
</script>

<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="forum h-full">

            <div class="flex justify-between items-center rounded-t-2xl pt-2">

                <div
                    class="flex items-center justify-center bg-black gap-0.5 l rounded-tl-md rounded-tr-md ml-4 px-0.5 pt-0.5">

                    <div class="p-2 hover:cursor-pointer rounded-tl-md"
                        :class="tabListHabbo == 0 ? 'bg-gray-300' : 'bg-gray-50 hover:bg-gray-200'"
                        @click="changeTab(0)">
                        <h4 class="text-black text-2xl font-bold text-left">TOP HABBOS</h4>
                    </div>

                    <div class="p-2 hover:cursor-pointer"
                        :class="tabListHabbo == 1 ? 'bg-gray-300' : 'bg-gray-50 hover:bg-gray-200'"
                        @click="changeTab(1)">
                        <h4 class="text-black  text-2xl font-bold text-left">MAIS VOTADOS</h4>
                    </div>

                    <div class="p-2 hover:cursor-pointer"
                        :class="tabListHabbo == 2 ? 'bg-gray-300' : 'bg-gray-50 hover:bg-gray-200'"
                        @click="changeTab(2)">
                        <h4 class="text-black  text-2xl font-bold text-left">MAIS RECOMENDADOS</h4>
                    </div>

                    <div class="p-2 hover:cursor-pointer rounded-tr-md"
                        :class="tabListHabbo == 3 ? 'bg-gray-300' : 'bg-gray-50 hover:bg-gray-200'"
                        @click="changeTab(3)">
                        <h4 class="text-black  text-2xl font-bold text-left">INATIVOS</h4>
                    </div>

                </div>

                <a href="#" class="text-black font-bold hover:text-black" title="Impulsione o servidor"
                    v-if="tabListHabbo == 0">Impulsos</a>

            </div>
            <div class="" v-if="tabListHabbo == 0">
                <div class="card shadow-md"
                    :class="key == 0 ? 'bg-yellow-300' : '' && pagination.habbos == '1' || key == 1 ? 'bg-gray-300' : '' && pagination.habbos == '1' || key == 2 ? 'bg-amber-600' : '' && pagination.habbos == '1'"
                    v-for="habbo, key in habbos.data" :key="key">
                    <div class="flex justify-between">
                        <div class="w-4/12 p-1">
                        </div>
                        <div class="w-8/12">
                            <div class="flex justify-end text-lg items-center">
                                <p class="text-lg font-bold">{{ habbo.boosts }}</p>
                                <p class="fill-black w-8 h-8 -rotate-90">
                                    <svg data-name="Layer 1" id="Layer_1" viewBox="0 0 100 100"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <title />
                                        <polygon points="47.5 20 47.5 35 62.5 50 47.5 65 47.5 80 77.5 50 47.5 20" />
                                        <polygon points="22.5 20 22.5 35 37.5 50 22.5 65 22.5 80 52.5 50 22.5 20" />
                                    </svg>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body flex justify-start items-center" id="boosts">
                        <div class="w-2/12">
                            <div class="bg-white/50 rounded-full w-36 h-36 flex justify-center items-center relative">

                                <img :src="key == 0 ? '/img/medalha-de-ouro.png' : '' || key == 1 ? '/img/medalha-de-prata.png' : '' || key == 2 ? '/img/medalha-de-bronze.png' : ''"
                                    class="absolute w-16 -top-3 left-0" />

                                <img class="rounded-full object-cover w-32 h-32"
                                    src="https://s2.glbimg.com/nPiZW5gMk6-1XA5KNMxJtzlPI2c=/0x0:1368x768/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_08fbf48bc0524877943fe86e43087e7a/internal_photos/bs/2019/m/C/FA2uWlSTmcoVNsvgofhA/sdfdg.png" />
                            </div>
                        </div>
                        <div class="w-6/12 block justify-start items-center">
                            <p class="text-xl font-bold ml-4 text-black mb-2">{{ habbo.name }}</p>
                            <p class="text-lg font-normal ml-4 text-black">
                            <div class="flex justify-start items-center gap-2 text-sm mb-2">
                                VAGAS STAFF: <span class="font-bold rounded-md">{{ habbo.staff_vacancy == 'yes' ?
                                        'SIM' : 'NÃO'
                                }}</span>
                            </div>
                            <div class="flex justify-start items-center gap-2 text-sm mb-2">
                                EVENTOS A CADA: <span class="font-bold rounded-md">{{ habbo.events_time }}
                                    Minutos</span>
                            </div>
                            </p>
                        </div>
                        <div class="w-4/12 flex justify-center items-center">

                            <div class="flex justify-center items-center gap-2">

                                <button class="bg-black text-white font-bold px-4 py-2 rounded-full"
                                    @click="openModalHabbo(habbo)">Sobre</button>

                                <Link :href="route('admin.portal.edit.habbo', { id: habbo.id})"
                                    class="bg-black text-white font-bold px-4 py-2 rounded-full">Editar</Link>

                                <br>

                                <p
                                    class="text-center ml-3 flex justify-center gap-1 hover:cursor-pointer hover:text-gray-700 hover:fill-gray-700">
                                    <svg class="h-5 w-5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 525.153 525.153" style="enable-background:new 0 0 525.153 525.153;"
                                        xml:space="preserve">
                                        <g>
                                            <path d="M262.576,414.028l162.272,97.963L381.786,327.4l143.367-124.199l-188.77-15.995L262.576,13.162L188.77,187.206L0,203.201
L143.367,327.4l-43.062,184.591L262.576,414.028z" />
                                        </g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                    </svg>
                                    <span class="text-bold text-black">{{ habbo.favorites }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="" v-if="tabListHabbo == 1">
                <div class="card shadow-md"
                    :class="key == 0 ? 'bg-yellow-300' : '' && pagination.habbos == '1' || key == 1 ? 'bg-gray-300' : '' && pagination.habbos == '1' || key == 2 ? 'bg-amber-600' : '' && pagination.habbos == '1'"
                    v-for="habbo, key in habbos.data" :key="key">
                    <div class="card-body flex justify-start items-center" id="boosts">
                        <div class="w-2/12">
                            <div class="bg-white/50 rounded-full w-36 h-36 flex justify-center items-center relative">

                                <img :src="key == 0 ? '/img/medalha-de-ouro.png' : '' || key == 1 ? '/img/medalha-de-prata.png' : '' || key == 2 ? '/img/medalha-de-bronze.png' : ''"
                                    class="absolute w-16 -top-3 left-0" />

                                <img class="rounded-full object-cover w-32 h-32"
                                    src="https://s2.glbimg.com/nPiZW5gMk6-1XA5KNMxJtzlPI2c=/0x0:1368x768/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_08fbf48bc0524877943fe86e43087e7a/internal_photos/bs/2019/m/C/FA2uWlSTmcoVNsvgofhA/sdfdg.png" />
                            </div>
                        </div>
                        <div class="w-6/12 block justify-start items-center">
                            <p class="text-xl font-bold ml-4 text-black mb-2">{{ habbo.name }}</p>
                            <p class="text-lg font-normal ml-4 text-black">
                            <div class="flex justify-start items-center gap-2 text-sm mb-2">
                                VAGAS STAFF: <span class="font-bold rounded-md">{{ habbo.staff_vacancy == 'yes' ?
                                        'SIM' : 'NÃO'
                                }}</span>
                            </div>
                            <div class="flex justify-start items-center gap-2 text-sm mb-2">
                                EVENTOS A CADA: <span class="font-bold rounded-md">{{ habbo.events_time }}
                                    Minutos</span>
                            </div>
                            </p>
                        </div>
                        <div class="w-4/12 flex justify-center items-center">

                            <div class="flex justify-center items-center gap-2">

                                <button class="bg-black text-white font-bold px-4 py-2 rounded-full"
                                    @click="openModalHabbo(habbo)">Sobre</button>

                                    <Link :href="route('admin.portal.edit.habbo', { id: habbo.id})"
                                    class="bg-black text-white font-bold px-4 py-2 rounded-full">Editar</Link>
                                <br>

                                <p class="text-center ml-3 flex justify-center gap-1 hover:cursor-pointer hover:text-gray-700 hover:fill-gray-700"
                                    @click="favoriteHabbo(habbo.id)">
                                    <svg class="h-5 w-5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 525.153 525.153" style="enable-background:new 0 0 525.153 525.153;"
                                        xml:space="preserve">
                                        <g>
                                            <path d="M262.576,414.028l162.272,97.963L381.786,327.4l143.367-124.199l-188.77-15.995L262.576,13.162L188.77,187.206L0,203.201
L143.367,327.4l-43.062,184.591L262.576,414.028z" />
                                        </g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                    </svg>
                                    <span class="text-bold text-black">{{ habbo.favorites }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="" v-if="tabListHabbo == 2">
                <div class="card shadow-md"
                    :class="key == 0 ? 'bg-yellow-300' : '' && pagination.habbos == '1' || key == 1 ? 'bg-gray-300' : '' && pagination.habbos == '1' || key == 2 ? 'bg-amber-600' : '' && pagination.habbos == '1'"
                    v-for="habbo, key in habbos.data" :key="key">
                    <div class="card-body flex justify-start items-center" id="boosts">
                        <div class="w-2/12">
                            <div class="bg-white/50 rounded-full w-36 h-36 flex justify-center items-center relative">

                                <img :src="key == 0 ? '/img/medalha-de-ouro.png' : '' || key == 1 ? '/img/medalha-de-prata.png' : '' || key == 2 ? '/img/medalha-de-bronze.png' : ''"
                                    class="absolute w-16 -top-3 left-0" />

                                <img class="rounded-full object-cover w-32 h-32"
                                    src="https://s2.glbimg.com/nPiZW5gMk6-1XA5KNMxJtzlPI2c=/0x0:1368x768/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_08fbf48bc0524877943fe86e43087e7a/internal_photos/bs/2019/m/C/FA2uWlSTmcoVNsvgofhA/sdfdg.png" />
                            </div>
                        </div>
                        <div class="w-6/12 block justify-start items-center">
                            <p class="text-xl font-bold ml-4 text-black mb-2">{{ habbo.name }}</p>
                            <p class="text-lg font-normal ml-4 text-black">
                            <div class="flex justify-start items-center gap-2 text-sm mb-2">
                                VAGAS STAFF: <span class="font-bold rounded-md">{{ habbo.staff_vacancy == 'yes' ?
                                        'SIM' : 'NÃO'
                                }}</span>
                            </div>
                            <div class="flex justify-start items-center gap-2 text-sm mb-2">
                                EVENTOS A CADA: <span class="font-bold rounded-md">{{ habbo.events_time }}
                                    Minutos</span>
                            </div>
                            </p>
                        </div>
                        <div class="w-4/12 flex justify-center items-center">

                            <div class="flex justify-center items-center gap-2">

                                <button class="bg-black text-white font-bold px-4 py-2 rounded-full"
                                    @click="openModalHabbo(habbo)">Sobre</button>

                                    <Link :href="route('admin.portal.edit.habbo', { id: habbo.id})"
                                    class="bg-black text-white font-bold px-4 py-2 rounded-full">Editar</Link>
                                <br>

                                <p class="text-center ml-3 flex justify-center gap-1 hover:cursor-pointer hover:text-gray-700 hover:fill-gray-700"
                                    @click="favoriteHabbo(habbo.id)">
                                    <svg class="h-5 w-5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 525.153 525.153" style="enable-background:new 0 0 525.153 525.153;"
                                        xml:space="preserve">
                                        <g>
                                            <path d="M262.576,414.028l162.272,97.963L381.786,327.4l143.367-124.199l-188.77-15.995L262.576,13.162L188.77,187.206L0,203.201
L143.367,327.4l-43.062,184.591L262.576,414.028z" />
                                        </g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                    </svg>
                                    <span class="text-bold text-black">{{ habbo.favorites }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="" v-if="tabListHabbo == 3">
                <div class="card shadow-md"
                    v-for="habbo, key in habbos.data" :key="key">
                    <div class="card-body flex justify-start items-center" id="boosts">
                        <div class="w-2/12">
                            <div class="bg-white/50 rounded-full w-36 h-36 flex justify-center items-center relative">

                                <img :src="key == 0 ? '/img/medalha-de-ouro.png' : '' || key == 1 ? '/img/medalha-de-prata.png' : '' || key == 2 ? '/img/medalha-de-bronze.png' : ''"
                                    class="absolute w-16 -top-3 left-0" />

                                <img class="rounded-full object-cover w-32 h-32"
                                    src="https://s2.glbimg.com/nPiZW5gMk6-1XA5KNMxJtzlPI2c=/0x0:1368x768/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_08fbf48bc0524877943fe86e43087e7a/internal_photos/bs/2019/m/C/FA2uWlSTmcoVNsvgofhA/sdfdg.png" />
                            </div>
                        </div>
                        <div class="w-6/12 block justify-start items-center">
                            <p class="text-xl font-bold ml-4 text-black mb-2">{{ habbo.name }}</p>
                            <p class="text-lg font-normal ml-4 text-black">
                            <div class="flex justify-start items-center gap-2 text-sm mb-2">
                                VAGAS STAFF: <span class="font-bold rounded-md">{{ habbo.staff_vacancy == 'yes' ?
                                        'SIM' : 'NÃO'
                                }}</span>
                            </div>
                            <div class="flex justify-start items-center gap-2 text-sm mb-2">
                                EVENTOS A CADA: <span class="font-bold rounded-md">{{ habbo.events_time }}
                                    Minutos</span>
                            </div>
                            </p>
                        </div>
                        <div class="w-4/12 flex justify-center items-center">

                            <div class="flex justify-center items-center gap-2">

                                <button class="bg-black text-white font-bold px-4 py-2 rounded-full"
                                    @click="openModalHabbo(habbo)">Sobre</button>

                                    <Link :href="route('admin.portal.edit.habbo', { id: habbo.id})"
                                    class="bg-black text-white font-bold px-4 py-2 rounded-full">Editar</Link>
                                <br>

                                <p class="text-center ml-3 flex justify-center gap-1 hover:cursor-pointer hover:text-gray-700 hover:fill-gray-700"
                                    @click="favoriteHabbo(habbo.id)">
                                    <svg class="h-5 w-5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 525.153 525.153" style="enable-background:new 0 0 525.153 525.153;"
                                        xml:space="preserve">
                                        <g>
                                            <path d="M262.576,414.028l162.272,97.963L381.786,327.4l143.367-124.199l-188.77-15.995L262.576,13.162L188.77,187.206L0,203.201
L143.367,327.4l-43.062,184.591L262.576,414.028z" />
                                        </g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                        <g></g>
                                    </svg>
                                    <span class="text-bold text-black">{{ habbo.favorites }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="bg-white flex justify-end items-center gap-2 p-2 mb-8">
                <!-- 
                CREATE PAGINATION LINKS
            -->
                <button @click="paginate(page.url, page.label)"
                    class="bg-black text-white w-11 text-center rounded-sm font-bold"
                    v-for="page, key in habbos.links"><span> {{ page.label }}</span></button>
            </div>
        <!-- Main modal -->
        <div v-if="modalHabbo" id="defaultModal" tabindex="-1" aria-hidden="true"
            class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full flex justify-center items-center">
            
            <div class="w-full h-full bg-black opacity-50 p-0 absolute">
            </div>

            <div class="relative w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Informações sobre o hotel
                        </h3>
                        <button @click="modalHabbo = false" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="defaultModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="header">
                        <img src="https://www.gameranks.net/wp-content/uploads/2017/08/Habbo-Screenshots-5.jpg"
                            alt="hotel" class="w-full h-36 object-cover">
                    </div>
                    <div class="p-6 space-y-6">
                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                            v-html="modalHabbo.description">
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex justify-center items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                        <a :href="'https://' + modalHabbo.domain" target="_blank" data-modal-toggle="defaultModal"
                            class="text-white bg-black-700 bg-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-black dark:hover:bg-black dark:focus:ring-black">Quero
                            jogar!</a>
                        <button @click="modalHabbo = false" data-modal-toggle="defaultModal" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Procurar
                            outro</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </AuthenticatedLayout>
</template>
