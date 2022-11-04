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
            containers: []
        }
    },
    mounted() {
        // or with options
        toast.success("Painel carregado com sucesso...", {
            timeout: 2000
        });
        this.getContainers();
    },
    methods: {
        ligarInstancia: _.debounce(function (event) {
            event.target.disabled = true;
            axios.get(route('habbo.actions.containers.start'))
                .then(response => {
                    console.log(response.data);
                    if (response.data.status == 0) {
                        event.target.disabled = false;
                        toast.error(response.data.message, {
                            timeout: 2000
                        });
                    } else {
                        console.log(response.data);
                        event.target.disabled = false;
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
        desligarInstancia: _.debounce(function (event) {
            event.target.disabled = true;
            axios.get(route('habbo.actions.containers.stop'))
                .then(response => {
                    console.log(response.data);
                    if (response.data.status == 0) {
                        event.target.disabled = false;
                        toast.error(response.data.message, {
                            timeout: 2000
                        });
                    } else {
                        event.target.disabled = false;
                        toast.success(response.data.message, {
                            timeout: 2000
                        });
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
            axios.get(route('habbo.actions.emulador.start'))
                .then(response => {

                    if (response.data.status == 0) {
                        event.target.disabled = false;
                        toast.error(response.data.message, {
                            timeout: 2000
                        });
                    } else {
                        event.target.disabled = false;
                        console.log(response.data);
                        toast.success(response.data.message, {
                            timeout: 2000
                        });
                    }

                    this.getContainers()
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
            axios.get(route('habbo.actions.emulador.stop'))
                .then(response => {
                    if (response.data.status == 0) {
                        event.target.disabled = false;
                        toast.error(response.data.message, {
                            timeout: 2000
                        });
                    } else {
                        console.log(response.data);
                        event.target.disabled = false;
                        toast.success(response.data.message, {
                            timeout: 2000
                        });
                    }

                    this.getContainers()

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
                        this.containers = containers;
                    } else {
                        this.container = [];
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
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
                                <h3 class="card-title">Emulador</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-2">
                                <div class="bg-gray-100 rounded-md">
                                    <div class="d-flex justify-end">
                                        <div class="p-3">
                                            <button class="btn bg-white m-2">Reiniciar</button>
                                            <button class="btn bg-white m-2" @click="ligarEmulador">Ligar</button>
                                            <button class="btn bg-white m-2" @click="desligarEmulador">Desligar</button>
                                            <button class="btn bg-white m-2">Recompilar</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-900">
                                    <div class="row p-2">

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body-->
                        </div>
                        <!--/.direct-chat -->
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <p>Serviços Rodando</p>
                                    </div>
                                    <div class="card-body p-0">

                                        <div class="bg-gray-100">
                                            <div class="row p-2">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-between items-center">
                                                        <div class="p-2">
                                                            <p>Instância</p>
                                                            <small>Instância é um pacote de serviço que quando
                                                                desligado, todos os serviços são desligados.</small>
                                                        </div>
                                                        <div class="p-2">
                                                            <button class="btn bg-white m-2"
                                                                @click="ligarInstancia">Ligar</button>
                                                            <button class="btn bg-white m-2"
                                                                @click="desligarInstancia">Desligar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="containers">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">IMAGEM</th>
                                                        <th scope="col">TEMPO</th>
                                                        <th scope="col">STATUS</th>
                                                        <th scope="col">VOLUME</th>
                                                        <th scope="col">AÇÃO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="container, key in containers" :key="key">
                                                        <th scope="row">{{ key }}</th>
                                                        <td>{{ container.Names }}</td>
                                                        <td>{{ container.RunningFor }}</td>
                                                        <td><span v-if="container.State == 'running'"
                                                                class="bg-green text-white rounded-xl px-2">Ligado</span><span
                                                                v-else>Desligado</span></td>
                                                        <td><span class="bg-blue-500 text-white rounded-xl px-2">{{
                                                                container.Size
                                                        }}</span>
                                                        </td>
                                                        <td><button class="btn bg-red-500 m-2 text-white"
                                                                @click="desligarInstancia">Desligar</button> <button
                                                                class="btn bg-yellow-500 m-2 text-white"
                                                                @click="desligarInstancia">Reinstalar</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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

                        <!-- TO DO List -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ion ion-clipboard mr-1"></i>
                                    Novidades
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul class="todo-list" data-widget="todo-list">
                                    <li>
                                        <!-- drag handle -->
                                        <span class="handle">
                                            <i class="fas fa-ellipsis-v"></i>
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                        <!-- checkbox -->
                                        <div class="icheck-primary d-inline ml-2">
                                            <input type="checkbox" value="" name="todo1" id="todoCheck1">
                                            <label for="todoCheck1"></label>
                                        </div>
                                        <!-- todo text -->
                                        <span class="text">Monitoramento Grafana</span>
                                        <!-- Emphasis label -->
                                        <small class="badge badge-danger"><i class="far fa-clock"></i> 2
                                            mins</small>
                                        <!-- General tools such as edit or delete-->
                                        <div class="tools">
                                            <i class="fas fa-edit"></i>
                                            <i class="fas fa-trash-o"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            </section>
            <!-- /.Left col -->
        </div>
    </AuthenticatedLayout>
</template>
