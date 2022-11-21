<template>
    <div class="p-0">

        <!-- Reportar mensagem -->
        <div class="overflow-y-auto h-96" v-if="reportMessageData">
            <div class="header flex justify-between p-2 bg-black">
                <h4 class="text-start font-bold">Reportar mensagem</h4>
                <div class="bg-white rounded-full w-5 h-5 d-flex justify-center items-center"
                    @click="reportMessageData = null">
                    <p class="hover:cursor-pointer font-bold text-black text-sm">
                        X
                    </p>
                </div>
            </div>

            <div class="bg-gray-50">
                <div class="flex justify-between p-2">
                    <div class="flex">
                        <p class="text-sm font-bold">Usuário: {{ reportMessageData.user.name }}</p>
                    </div>
                    <p class="text-sm font-bold">{{ formatDate(reportMessageData.created_at) }}</p>
                </div>
                <div class="p-2">
                    <p class="text-sm font-bold">Mensagem:</p>
                    <p class="text-sm" v-html="reportMessageData.message"></p>
                </div>

                <div class="p-2">
                    <p class="text-sm">Descreva aqui o motivo do seu report. Lembre-se que os Moderadores irão receber
                        seu pedido, então nos descreva de forma detalhada o motivo pelo qual a mensagem deve ser
                        apagada.
                    </p>

                    <div class="flex justify-center gap-2">

                        <textarea v-model="reportMessageFormData.motive" class="
        form-control
        block
        w-full
        text-base
        font-normal
        bg-gray-100 
        bg-clip-padding
        rounded
        transition
        ease-in-out
        m-0
        focus:text-black focus:bg-white focus:border-black focus:outline-none" id="exampleFormControlTextarea1"
                            rows="3" placeholder=""></textarea>

                        <button class="bg-black text-white font-bold rounded-sm px-2" @click="reportMessageForm"><i
                                class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="$page.props.auth.user" class="flex">
            <div class="col-md-3 p-0">
                <div class="sticky  max-h-96 overflow-y-auto">
                    <OnlineList :me="$page.props.auth.user" @online="onlineEvents"></OnlineList>
                </div>
                <div class="flex justify-center p-2">
                    <p class="text-sm"><span class="h-5 w-5 rounded-full bg-black text-sm text-white p-1 mr-2">BC</span>V1.0</p>
                </div>
            </div>
            <div class="col-md-9 p-0 bg-gray-100">
                <ul class="chat max-h-96 overflow-y-auto divide-y divide-slate-200">
                    <li class="left clearfix py-2 px-2" v-for="message, key in messages" :key="key">
                        <div v-if="!message.type">

                            <div class="chat-body clearfix p-1">
                                <div class="header flex justify-start items-center gap-2">
                                    <div class="w-6/12 flex justify-start gap-2 items-center">

                                        <div
                                            class="bg-gray-200 w-7 h-7 rounded-full d-flex justify-center items-center">
                                            <img class="w-5 h-5 rounded-full object-cover"
                                                :src="message.user.avatar ? message.user.avatar : '/img/user.png'" />
                                        </div>

                                        <strong class="primary-font">
                                            {{ message.user.name }}
                                        </strong>

                                    </div>

                                    <div class="w-6/12">

                                        <div class="flex justify-between items-center">
                                            <div class="w-8/12">
                                                <p class="float-right text-sm text-gray-300">{{
                                                        formatDate(message.created_at)
                                                }}</p>
                                            </div>

                                            <div class="w-4/12 flex justify-end gap-2" :id="'report-icon-' + message.id">
                                                <div @click="reportMessage(message)"
                                                    class="rounded-full w-5 h-5 d-flex justify-center items-center hover:cursor-pointer"
                                                    :class="message.report.length > 3 ? 'bg-red-700' : 'bg-black'">
                                                    <p class="text-sm font-bold text-white">!</p>
                                                </div>

                                                <div class="bg-black rounded-full w-5 h-5 d-flex justify-center items-center hover:cursor-pointer" v-if="this.$page.props.auth.user.roles.find(role => role.name == 'admin') || this.$page.props.auth.user.roles.find(role => role.name == 'mod')" @click="removeMessage(message)">
                                                    <p class="font-bold text-white text-sm">
                                                        X
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <p>
                                    {{ message.message }}
                                </p>
                            </div>
                        </div>
                        <div v-else-if="message.type == 'online'">
                            <div class="bg-green-200 p-2 mb-2">
                                <p class="flex justify-start items-center gap-2">
                                <div class="bg-green-300 w-7 h-7 rounded-full d-flex justify-center items-center">
                                    <img class="w-5 h-5 rounded-full object-cover"
                                        :src="message.user.avatar ? message.user.avatar : '/img/user.png'" />
                                </div>
                                {{ message.data }}
                                </p>
                            </div>
                        </div>
                        <div v-else-if="message.type == 'offline'">
                            <div class="bg-red-200 p-2 text-white">
                                <p class="flex justify-start items-center gap-2">
                                <div class="bg-red-300 w-7 h-7 rounded-full d-flex justify-center items-center">
                                    <img class="w-5 h-5 rounded-full object-cover"
                                        :src="message.user.avatar ? message.user.avatar : '/img/user.png'" />
                                </div>
                                {{ message.data }}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="mt-10">
                    <ChatForm @messagesent="addMessage" />
                </div>
            </div>
        </div>

        <div v-else class="p-2">
            <p class="bg-red-200 p-2">É preciso estar logado para enviar mensagens.</p>
            <a href="/register" class="bg-black text-white p-2 mt-2 float-right mb-2">Registre-se</a>
        </div>



    </div>
</template>

<script>

import OnlineList from '@/Components/OnlineList.vue';
import ChatForm from '@/Components/ChatForm.vue';
import { useToast } from "vue-toastification";
const toast = useToast();

export default {
    data() {
        return {
            reportMessageData: null,
            reportMessageFormData: {
                motive: null,
            },
            messagesData: {},
        }
    },
    components: {
        OnlineList,
        ChatForm,
    },
    props: {
        messages: {
            type: Array,
            required: true
        }
    },
    methods: {
        reportMessageForm: function () {
            let formData = {
                motive: this.reportMessageFormData.motive,
                message_id: this.reportMessageData.id,
                user_reported_id: this.reportMessageData.user.id,
            };

            axios.post(route('chat.messages.report'), formData)
                .then((response) => {
                    if (response.data.code == 201) {

                        let dataReport = {
                            type: 'reported',
                            data: {
                                motive: this.reportMessageFormData.motive,
                                message_id: this.reportMessageData.id,
                                user_reported_id: this.reportMessageData.user.id,
                                respose: response.data
                            }
                        };

                        this.$emit('eventMessage', dataReport);
                        document.getElementById('report-icon-' + this.reportMessageData.id).innerHTML = '<div class="bg-red-700 rounded-full w-5 h-5 d-flex justify-center items-center"><p class="text-sm hover:cursor-pointer font-bold text-white">!</p></div>';

                        toast.success('Mensagem reportada com sucesso!', 5000);
                    } else {
                        toast.error('Erro ao reportar mensagem!', 5000);
                    }
                    this.reportMessageData = null;
                }).catch((error) => {
                    toast.error('Erro ao reportar mensagem!', 5000);
                });
        },
        reportMessage: function (message) {

            if (message.report.length > 3) {
                return toast.error('Mensagem já reportada!', 5000);
            }
            let flagAlreadyReported = false;
            message.report.filter((report) => {
                if (report.user_reported_id == this.$page.props.auth.user.id) {
                    toast.error('Você já reportou essa mensagem!', 5000);
                    flagAlreadyReported = true;
                }
            });
            if (!flagAlreadyReported) {
                this.reportMessageData = message;
            }
        },
        addMessage(message) {
            axios.post('/messages', message).then(response => 
            {
                if (response.data.code == 201) {
                    console.log('Message sent');
                } else {
                    return toast.error(response.data.status, 5000);
                }
                //return toast.response.data.message;
            }).catch(error => {
                console.log(error);
            });
        },
        removeMessage(data) {
            //this.messages.push(message);
            axios.post('/messages/remove', { id: data.id }).then(response => {
                this.$emit('eventMessage', { type: 'removed', data: data });
            });
        },
        onlineEvents: function (event) {
            if (event.event === 'join') {
                this.messages.push({ type: 'online', data: event.object.name + ' entrou no chat.', user: event.object });
            } else if (event.event === 'leave') {
                this.messages.push({ type: 'offline', data: event.object.name + ' saiu do chat.', user: event.object });
            }
        },
        formatDate: function (date) {
            return moment(date).format('MM/DD/YYYY H:MM')
        }
    },
};

</script>

<style scoped>
.chat-bg {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}
</style>