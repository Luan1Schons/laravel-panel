<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { useToast } from "vue-toastification";
import _ from 'lodash';

const toast = useToast();

export default {
    name: 'Dashboard',
    components: {
        AuthenticatedLayout,
        Head,
    },
    data() {
        return {
            containers: [],
            emulatorLog: '',
            habbo: {},
            metrics: [],
        }
    },
    props: {
        habboData: Object,
    },
    mounted() {

        this.habbo = this.habboData;
        // or with options
        toast.success("Painel carregado com sucesso...", {
            timeout: 2000
        });
        this.getContainers();
        this.getEmulatorLogs();
    },
    methods: {
        ligarInstancia: _.debounce(function (event) {
            this.spinnerButtonLoading(event);
            axios.get(route('habbo.actions.containers.start'))
                .then(response => {
                    if (response.data.status == 0) {
                        event.target.disabled = false;
                        this.spinnerButtonRemoveLoading(event);
                        toast.error(response.data.message, {
                            timeout: 2000
                        });
                    } else {
                        event.target.disabled = false;
                        this.spinnerButtonRemoveLoading(event);
                        toast.success(response.data.message, {
                            timeout: 2000
                        });

                    }

                    this.getContainers();
                })
                .catch(error => {
                    console.log(error);
                    toast.error('Erro ao ligar as instâncias.', {
                        timeout: 2000
                    });
                });
        }, 1000),
        spinnerButtonLoading: function (event) {
            event.target.disabled = true;
            let spinner = event.target.getElementsByClassName('spinner-border')[0];
            if (spinner !== "undefined") {
                spinner.style.removeProperty('display');
            }
        },
        spinnerButtonRemoveLoading: function (event) {
            event.target.disabled = true;
            let spinner = event.target.getElementsByClassName('spinner-border')[0];
            if (spinner !== "undefined") {
                spinner.style.display = "none";
            }
        },
        desligarInstancia: _.debounce(function (event) {
            this.spinnerButtonLoading(event);
            axios.get(route('habbo.actions.containers.stop'))
                .then(response => {
                    console.log(response.data);
                    if (response.data.status == 0) {
                        event.target.disabled = false;
                        this.spinnerButtonRemoveLoading(event);
                        toast.error(response.data.message, {
                            timeout: 2000
                        });
                        this.emulatorLog = "";
                    } else {
                        event.target.disabled = false;
                        this.spinnerButtonRemoveLoading(event);
                        toast.success(response.data.message, {
                            timeout: 2000
                        });
                        this.emulatorLog = "";
                    }

                    this.getContainers()
                })
                .catch(error => {
                    console.log(error);
                    toast.error('Erro ao desligar as instâncias.', {
                        timeout: 2000
                    });
                });
        }, 1000),
        ligarEmulador: _.debounce(function (event) {
            event.target.disabled = true;
            this.spinnerButtonLoading(event);
            axios.get(route('habbo.actions.emulador.start'))
                .then(response => {

                    if (response.data.status == 0) {
                        event.target.disabled = false;
                        this.spinnerButtonRemoveLoading(event);
                        toast.error(response.data.message, {
                            timeout: 2000
                        });
                    } else {
                        event.target.disabled = false;
                        this.habbo.emulator_status = 'online';
                        this.spinnerButtonRemoveLoading(event);
                        toast.success(response.data.message, {
                            timeout: 2000
                        });
                    }

                    this.getContainers();
                    this.getEmulatorLogs();
                })
                .catch(error => {
                    console.log(error);
                    event.target.disabled = false;
                    toast.error('Erro ao ligar o emulador', {
                        timeout: 2000
                    });
                });
        }, 1000),
        desligarEmulador: _.debounce(function (event) {
            event.target.disabled = true;
            this.spinnerButtonLoading(event);
            axios.get(route('habbo.actions.emulador.stop'))
                .then(response => {
                    if (response.data.status == 0) {
                        event.target.disabled = false;
                        this.spinnerButtonRemoveLoading(event);
                        toast.error(response.data.message, {
                            timeout: 2000
                        });
                    } else {
                        event.target.disabled = false;
                        this.spinnerButtonRemoveLoading(event);
                        this.emulatorLog = "";
                        this.habbo.emulator_status = 'offline';
                        toast.success(response.data.message, {
                            timeout: 2000
                        });
                    }

                    this.getContainers()
                    this.getEmulatorLogs();

                })
                .catch(error => {
                    console.log(error);
                    event.target.disabled = false;
                    toast.error('Erro ao ligar o emulador', {
                        timeout: 2000
                    });
                });
        }, 1000),
        reiniciarEmulador: _.debounce(function (event) {
            event.target.disabled = true;
            this.spinnerButtonLoading(event);
            axios.get(route('habbo.actions.emulador.restart'))
                .then(response => {
                    if (response.data.status == 0) {
                        event.target.disabled = false;
                        this.spinnerButtonRemoveLoading(event);
                        this.habbo.emulator_status = 'offline';
                        this.emulatorLog = "";
                        toast.error(response.data.message, {
                            timeout: 2000
                        });
                    } else {
                        event.target.disabled = false;
                        this.spinnerButtonRemoveLoading(event);
                        this.emulatorLog = "";
                        this.habbo.emulator_status = 'online';
                        toast.success(response.data.message, {
                            timeout: 2000
                        });
                    }

                    this.getContainers();
                    this.getEmulatorLogs();
                })
                .catch(error => {
                    console.log(error);
                    event.target.disabled = false;
                    toast.error('Erro ao ligar o emulador', {
                        timeout: 2000
                    });
                });
        }, 1000),
        getContainers: function () {
            axios.get(route('habbo.actions.containers.list'))
                .then(response => {
                    let containers = [];
                    if (response.data.status == 1) {
                        $.each(response.data.message, function (index, value) {
                            containers.push(JSON.parse(value))
                        });

                        $.each(containers, function (index, value) {

                            axios.get(route('habbo.actions.containers.metrics', { id: value.ID }))
                                .then(response => {
                                    if (response.data.status == 1) {
                                        let metrics = JSON.parse(response.data.message);
                                        document.getElementById('cpu-metric-' + metrics.ID).innerHTML = metrics.CPUPerc;
                                        document.getElementById('ram-metric-' + metrics.ID).innerHTML = metrics.MemUsage;
                                        console.log(metrics);
                                    }
                                })
                                .catch(error => {
                                    console.log(error);
                                });


                        });
                        this.containers = containers;
                    } else {
                        this.container = [];
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getEmulatorLogs: function () {
            axios.get(route('habbo.actions.emulador.log'))
                .then(response => {
                    console.log(response.data);
                    if (response.data.status == 1) {
                        this.emulatorLog = response.data.message
                    }
                })
                .catch(error => {
                    console.log('error', error);
                });

        },
    }
};
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-blue-500 h-32 d-flex justify-between items-center">
                    <div class="inner">
                        <h3 class="text-white">ONLINE</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-cloud text-white"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-blue-500 h-32 d-flex justify-between items-center">
                    <div class="inner">
                        <h3 class="text-white">USUÁRIOS</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-contact text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-blue-500 h-32 d-flex justify-between items-center">
                    <div class="inner">
                        <h3 class="text-white">PLANO</h3>
                        <p class="text-white">30 DIAS RESTANTES</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-blue-500 h-32 d-flex justify-between items-center">
                    <div class="inner">
                        <h3 class="text-white">VERSÃO</h3>
                        <p class="text-white">VERSÃO ESTÁVEL 1.0</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-favorite text-white"></i>
                    </div>

                </div>
            </div>

        </div>
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
                                <h3 class="card-title">Console</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="d-flex justify-left items-center bg-gray-800 sticky w-full h-full">
                                    <div class="w-4/12 bg-gray-700 h-24">
                                        <div class="h-full w-full d-flex justify-center items-center">
                                            <h1 class="text-2xl text-white font-bold">ARCTURUS</h1>
                                        </div>
                                    </div>
                                    <div class="w-8/12 h-24">
                                        <div class="d-flex justify-end">
                                            <div class="p-3" v-if="habbo">
                                                <button class="btn bg-white m-2" @click="reiniciarEmulador"
                                                    :disabled="habbo.emulator_status == 'offline'">
                                                    <div class="spinner-border text-primary h-5 w-5 mr-2"
                                                        style="display: none;">
                                                    </div>Reiniciar
                                                </button>
                                                <button class="btn bg-white m-2" @click="ligarEmulador"
                                                    :disabled="habbo.emulator_status == 'online'">
                                                    <div class="spinner-border text-primary h-5 w-5 mr-2"
                                                        style="display: none;">
                                                    </div>Ligar
                                                </button>
                                                <button class="btn bg-white m-2" @click="desligarEmulador"
                                                    :disabled="habbo.emulator_status == 'offline'">
                                                    <div class="spinner-border text-primary h-5 w-5 mr-2"
                                                        style="display: none;">
                                                    </div>Desligar
                                                </button>
                                                <!-- <button class="btn bg-white m-2">Recompilar</button> -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-900 border-b-2 rounded-b-3xl">
                                    <div class="row">
                                        <div class="w-full max-h-96 h-96 overflow-y-auto">
                                            <div class="h-full text-white">
                                                <div v-if="habbo.emulator_status == 'online'" class="pl-2 relative">


                                                    <p class="text-xs text-white p-2" v-html="emulatorLog">
                                                    </p>
                                                </div>

                                                <div v-else class="d-flex justify-center items-center h-full w-full">
                                                    <h3 class="text-3xl text-white opacity-50">EMULADOR
                                                        DESLIGADO</h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="card-footer">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">RCON</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Comando"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            -->
                            <!-- /.card-body-->
                        </div>
                        <!--/.direct-chat -->

                        <!-- Table with habbo informations -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informações</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">NOME</th>
                                            <th scope="col">PLANO</th>
                                            <th scope="col">DATABASE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>{{ habbo.name }}</th>
                                            <th>Básico</th>
                                            <th>{{ habbo.mysql_database }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <p>Serviços Rodando</p>
                                    </div>
                                    <div class="card-body p-0">

                                        <div class="bg-white">
                                            <div class="row p-2">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-between items-center">

                                                        <div class="p-2 w-6/12">
                                                            <p>Instância</p>
                                                            <small>Instância é um pacote de serviço que quando
                                                                desligado, todos os serviços são desligados.</small>
                                                        </div>

                                                        <div class="p-2 w-6/12">
                                                            <div class="d-flex justify-end">
                                                                <button
                                                                    class="btn bg-blue-500 text-white m-2 d-flex justify-between items-center"
                                                                    @click="ligarInstancia">
                                                                    <div class="spinner-border text-primary h-5 w-5 mr-2"
                                                                        style="display: none;">
                                                                    </div> Ligar
                                                                </button>
                                                                <button
                                                                    class="btn bg-red-500 text-white m-2 d-flex justify-between items-center"
                                                                    @click="desligarInstancia">
                                                                    <div class="spinner-border text-primary h-5 w-5 mr-2"
                                                                        style="display: none;">
                                                                    </div>
                                                                    Desligar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="containers">
                                            <div class="bg-gray-200">
                                                <div class="flex gap-2 justify-center items-center">
                                                    <div class="p-2 w-6/12">
                                                        <p>Informações gráficas:</p>
                                                    </div>
                                                    <div class="p-2 w-6/12">
                                                        <div class="d-flex justify-end gap-2">
                                                    <div class="cpu flex gap-2 justify-start items-center">
                                                        <div class="rounded-full h-5 w-5 bg-green-200"></div> Volume (Disco)
                                                    </div>
                                                    <div class="ram flex gap-2 justify-start items-center">
                                                        <div class="rounded-full h-5 w-5 bg-yellow-200"></div> CPU
                                                    </div>
                                                    <div class="cpu flex gap-2 justify-start items-center">
                                                        <div class="rounded-full h-5 w-5 bg-red-200"></div> RAM
                                                    </div>
                                                </div>
                                                </div>
                                                </div>
                                                <div class="row p-2">
                                                        <div class="card col-12 col-sm-12 col-md-4 col-lg-6 col-xl-2 h-2/5 m-3" v-for="container, key in containers" :key="key">
                                                        <div class="image flex justify-center items-center p-2">
                                                            <div class="rounded-full w-24 h-24 bg-blue-500 d-flex justify-center items-center">
                                                                <i class="fa fa-server text-2xl text-white" aria-hidden="true"></i>
                                                            </div>
                                                        </div>

                                                        <span class="text-center text-sm mb-2 max-w-prose ...">{{container.Image.substring(0,10)}}...</span>
                                                        
                                                        <span v-if="container.State == 'running'"
                                                                class="bg-green text-white px-2 text-center">Ligado</span>
                                                                
                                                                <span class="bg-red text-white px-2 text-center"
                                                                v-else>Desligado</span>

                                                        <div class="mt-2">
                                                            <div class="bg-green-200 rounded-xl px-2 text-black mb-2 text-sm text-center">
                                                            <span>{{
                                                                container.Size
                                                        }}</span>
                                                        </div>
                                                            <div class="bg-yellow-200 rounded-xl px-2 text-black mb-2 text-sm text-center">
                                                                <span :id="'cpu-metric-' + container.ID">
                                                                    <div class="spinner-border spinner-border-sm text-gray-900 " role="status"></div></span>
                                                            </div>
                                                            <div class="bg-red-200 rounded-xl px-2 text-black mb-2 text-sm text-center">
                                                                <span :id="'ram-metric-' + container.ID"><div class="spinner-border spinner-border-sm text-gray-900" role="status"></div></span>
                                                            </div>
                                                            <div class="d-flex justify-center items-center"
                                                                v-if="container.Names == 'nitro'">
                                                                <button class="text-blue-500 ml-2" @click="ligarContainer(container.Names)"><i
                                                                        class="fa fa-arrow-up"
                                                                        aria-hidden="true"></i></button>
                                                                <button class="text-yellow-500 ml-2" @click="ligarContainer(container.Names)"><i
                                                                        class="fa fa-cog"
                                                                        aria-hidden="true"></i></button>
                                                                <button class="text-red-500 ml-2" @click="desligarContainer(container.Names)"><i
                                                                        class="fa fa-arrow-down"
                                                                        aria-hidden="true"></i></button>
                                                            </div> 

                                                            <div class="d-flex justify-center items-center"
                                                                v-else>
                                                                <button class="text-gray-400 ml-2"
                                                                    disabled><i
                                                                        class="fa fa-arrow-up"
                                                                        aria-hidden="true"></i></button>
                                                                <button class="text-gray-400 ml-2"
                                                                    disabled><i
                                                                        class="fa fa-cog"
                                                                        aria-hidden="true"></i></button>
                                                                <button class="text-gray-400 ml-2"
                                                                    disabled><i
                                                                        class="fa fa-arrow-down"
                                                                        aria-hidden="true"></i></button>
                                                            </div> 

                                                        </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <div v-else>
                                            <div class="card-body">
                                                <div class="alert alert-warning text-white">Nenhum serviço ligado
                                                </div>
                                            </div>

                                        </div>
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
