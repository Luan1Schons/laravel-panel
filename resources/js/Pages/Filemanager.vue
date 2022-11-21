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
            spinners: {
                instance: {
                    ligar: false,
                    desligar: false,
                }
            }
        }
    },
    props: {
        habboData: Array,
    },
    mounted() {

        this.habbo = this.habboData;
        // or with options
        toast.success("Gerenciador de arquivos carregado...", {
            timeout: 2000
        });
    },
};
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <div class="col-md-12">
            <iframe src="/file-manager" style="width: 100%; height: 700px; overflow: hidden; border: none;"></iframe>
        </div>

    </AuthenticatedLayout>
</template>
