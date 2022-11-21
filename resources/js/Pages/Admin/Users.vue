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
        usersData: Object,
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
                        <h3 class="text-md font-bold mb-2">Usuários</h3>
                        <table class="min-w-full">
                            <thead class="bg-black border-b">
                                <tr>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Usuário
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Email
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Papel
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Data Criação
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-white px-6 py-4 text-left">
                                        Ação
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-gray-100 border-b" v-for="user, key in usersData" :key="key">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{
                                            user.name
                                    }}</td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ user.email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                        <span v-for="role in user.roles" class="bg-black rounded-md text-white font-bold px-2 py-0.5">{{ role.name}}</span>
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ formatDate(user.created_at) }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        <button
                                            class="font-bold py-2 px-4 rounded mr-2"
                                            @click="banUser(user.id)" :disabled="!user.roles.find(r => r.name == 'user')" :class="!user.roles.find(r => r.name == 'user') ? 'bg-gray-200 text-black' : 'bg-black text-white'">Banir</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
