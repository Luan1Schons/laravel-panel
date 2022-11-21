<script>
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { useToast } from "vue-toastification";
import ChatMessages from '@/Components/ChatMessages.vue';
import ChatForm from '@/Components/ChatForm.vue';
import _ from 'lodash';

const toast = useToast();

export default {
    name: 'Dashboard',
    components: {
        AuthenticatedLayout,
        Head,
        ChatMessages,
        ChatForm
    },
    data() {
        return {
            messages: []
        }
    },
    created: function () {
        //'\\App\Events\\MessageSent'
        this.fetchMessages();
        this.chatRoom = window.Echo.channel('chat')
            .listen('.message-sent', (e) => {
                this.messages.push(e.message);
            })
            .listen('.message-delete', (e) => {
                if (e.id) {
                    this.messages = this.messages.filter(m => (m.id !== e.id));
                }
            });
    },
    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },
        eventMessage: function (event) {
            if (event.type === 'removed') {
                this.messages = this.messages.filter(m => (m.id !== event.data.id));
            } else if (event.type == 'reported') {

                //this.messages = this.messages.filter(m => (m.id !== event.data.id));
            }
        },
    }
};

</script>

<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="w-full">
            <div class="bg-gray-100 p-4">
                <p>Bem-Vindo(a) a área administrativa.</p>
                <br/>
                <p>Novas funcionalidades serão desenvolvidas em breve para maior flexibilidade.</p>
            </div>

            <div class="chat mt-5 mb-40">
                <div class="card">
                    <div class="flex justify-between items-center p-3">
                        <h3 class="text-2xl font-bold">Chat BlackHabbos</h3>
                        <h3>{{ $page.props.auth.roles.includes('admin') || $page.props.auth.roles.includes('mod') ?
                                'Logado como Staff' : '* A staff não se responsabiliza pelos links enviados no chat.'
                        }}</h3>
                    </div>
                    <div class="card-body p-0">
                        <ChatMessages :messages="messages" @eventMessage="eventMessage"></ChatMessages>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
