<script>
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { useToast } from "vue-toastification";
import { useForm } from '@inertiajs/inertia-vue3'
import _ from 'lodash';

const toast = useToast();

export default {
    name: 'Dashboard',
    components: {
        AuthenticatedLayout,
        Head,
    },
    props: {
        reportData: Object,
        banData: Object,
    },
    data() {
        return {
            reportDataForm: useForm({
                reportId: null,
                userId: null,
            }),
            banUserForm: useForm({
                userId: null,
            })
        }
    },
    methods: {
        async deleteReport(reportId) {
            this.reportDataForm.reportId = reportId;
            this.reportDataForm.post(route('admin.portal.remove.chat.report'), {
                preserveScroll: true,
                onSuccess: () => {
                    return toast.success('Denúncia deletada com sucesso.');
                },
                onError: () => {
                    return toast.error('Erro ao deletar denúncia.')
                }
            })
        },
        async removeReport(userId) {
            this.reportDataForm.reportId = reportId;
            this.reportDataForm.post(route('admin.portal.remove.chat.report'), {
                preserveScroll: true,
                onSuccess: () => {
                    return toast.success('Denúncia deletada com sucesso.');
                },
                onError: () => {
                    return toast.error('Erro ao deletar denúncia.')
                }
            })
        },
        async banUser(userId) {
            this.banUserForm.userId = userId;
            this.banUserForm.post(route('admin.portal.chat.ban'), {
                preserveScroll: true,
                onSuccess: () => {
                    return toast.success('Usuário banido com sucesso');
                },
                onError: () => {
                    return toast.error('Erro ao banir usuário.')
                }
            });
        },
        async unbanUser(userId) {
            this.banUserForm.userId = userId;
            this.banUserForm.post(route('admin.portal.chat.unban'), {
                preserveScroll: true,
                onSuccess: () => {
                    return toast.success('Usuário desbanido com sucesso');
                },
                onError: () => {
                    return toast.error('Erro ao desbanir usuário.')
                }
            });
        },
        formatDate: function (date) {
            return moment(date).format('MM/DD/YYYY H:MM')
        }
    }
};

</script>

<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <h3 class="text-md font-bold mb-2">Mensagens reportadas</h3>
                        <table class="min-w-full">
                            <thead class="bg-black border-b">
                                <tr>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Usuário Reportado
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Mensagem
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Data
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Quem reportou
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Motivo
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Ação
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-gray-100 border-b" v-for="report, key in reportData" :key="key">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{
                                            report.user_reported.name
                                    }}</td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ report.message.message }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ formatDate(report.created_at) }}
                                    </td>
                                    <td class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap font-bold">
                                        {{ report.user.name }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ report.motive }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        <button
                                            class="bg-black hover:bg-gray-900 text-white font-bold py-2 px-4 rounded mr-2"
                                            @click="banUser(report.user_reported_id)">Banir</button>
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            @click="deleteReport(report.id)">Deletar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col my-5">
            <div class="overflow-x-auto">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <h3 class="text-md font-bold mb-2">Usuários banidos</h3>
                        <table class="min-w-full">
                            <thead class="bg-black border-b">
                                <tr>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Usuário
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Banido Por
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Data
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-gray-100 border-b" v-for="ban,key in banData" :key="key">
                                    <td class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap font-bold">
                                        {{ ban.banned_user.name }}
                                    </td>
                                    <td class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap font-bold">
                                        {{ ban.user.name }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ formatDate(ban.created_at) }}
                                    </td>
                                    <td class="flex justify-end items-center p-3">
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" @click="unbanUser(ban.user_id)">Desbanir</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<!-- Main modal -->
    
    </AuthenticatedLayout>
</template>
