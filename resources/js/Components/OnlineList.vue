<!-- File: ./resources/js/components/OnlineList.vue -->
<template>
    <div class="border-r-2 border-black bg-black p-3">

        <ul class="h-screen">
            <li href="#">
                <p class="p-2 font-bold">Disponíveis</p>
                <div class="mt-3">
                <ul v-for="user in users" :key="user.id" class="d-flex gap-2 justify-between items-center mb-2">
                    <div v-if="user.roles.find(role => role.name == 'admin')">
                        <div class="flex justify-center items-center gap-2 mb-2">
                        <div class="flex justify-center items-center bg-yellow w-7 h-7 rounded-full relative">
                            <img src="/img/crown.png" class="absolute -top-4 w-5 h-5"/>
                            <img class="avatar rounded-full h-5 w-5 object-cover" :src="user.avatar ? user.avatar : '/img/user.png'" :alt="user.name">
                        </div>
                        <p class="font-bold limit-name">{{ user.name }}</p>
                    </div>
                    </div>
                    <div v-if="user.roles.find(role => role.name == 'user')">

                    <div class="flex justify-center items-center gap-2 mb-2">
                        <div class="flex justify-center items-center bg-white w-7 h-7 rounded-full ">
                            <img class="avatar rounded-full h-5 w-5 object-cover" :src="user.avatar ? user.avatar : '/img/user.png'" :alt="user.name">
                        </div>
                        <p class="font-bold limit-name">{{ user.name }}</p>

                        <p class="text-red hover:cursor-pointer" @click="banUser(user.id)" v-if="$page.props.auth.roles.includes('admin') && user.id !== $page.props.auth.user.id || $page.props.auth.roles.includes('mod') && user.id !== $page.props.auth.user.id">
                        <svg width="24px" height="24px" viewBox="0 0 24 24"
                            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg"
                            version="1.1" xmlns:cc="http://creativecommons.org/ns#"
                            xmlns:dc="http://purl.org/dc/elements/1.1/">
                            <g transform="translate(0 -1028.4)">
                                <path
                                    d="m12 1031.4c-2.2482 0-4.3298 0.7-6 2-2.4327 1.8-4 4.7-4 8 0 5.5 4.4772 10 10 10 5.523 0 10-4.5 10-10 0-5.6-4.477-10-10-10zm0 3c3.866 0 7 3.1 7 7 0 1.4-0.426 2.7-1.156 3.8l-9.6878-9.7c1.1055-0.7 2.4198-1.1 3.8438-1.1zm-5.9375 3.3 9.6255 9.6c-1.073 0.7-2.331 1.1-3.688 1.1-3.866 0-7-3.2-7-7 0-1.4 0.3937-2.7 1.0625-3.7z"
                                    fill="#c0392b" />
                                <path
                                    d="m12 2c-2.2482 0-4.3298 0.7477-6 2-2.4327 1.8241-4 4.7254-4 8 0 5.523 4.4772 10 10 10 5.523 0 10-4.477 10-10 0-5.5228-4.477-10-10-10zm0 3c3.866 0 7 3.134 7 7 0 1.424-0.426 2.738-1.156 3.844l-9.6878-9.6878c1.1055-0.7305 2.4198-1.1562 3.8438-1.1562zm-5.9375 3.3125l9.6255 9.6255c-1.073 0.668-2.331 1.062-3.688 1.062-3.866 0-7-3.134-7-7 0-1.357 0.3937-2.6145 1.0625-3.6875z"
                                    transform="translate(0 1028.4)" fill="#e74c3c" />
                            </g>
                        </svg>
                    </p>
                    </div>

                </div>
                </ul>
            </div>
            </li>

        </ul>
    </div>
</template>

<script>

import { useToast } from "vue-toastification";
const toast = useToast();

export default {
    name: 'OnlineList',
    props: ['me'],
    data() {
        return {
            room: null,
            users: []
        }
    },
    mounted() {
        // Verify if user is banned
        axios.post(route('chat.bans'), {
            user_id: this.me.id
        }).then(response => {
            if (response.data.data) {
                console.log('oi');
                toast.error('Você foi banido do chat!, portanto não poderá enviar mensagens.', 5000);
                this.$page.props.auth.user.banned = true;
            }

            this.users.push(this.me)
            this.room = Echo.join('online')
                .here(users => { (this.users = users) })
                .joining(user => {
                    this.$emit('online', { event: 'join', object: user });
                    this.users.push(user)
                }, this)
                .leaving(user => {
                    this.$emit('online', { event: 'leave', object: user });
                    this.users = this.users.filter(u => (u.id !== user.id));
                }
                );

        });
    },
    methods: {
        banUser(id) {
            axios.post(route('chat.ban', { user_id: id }))
                .then(response => {
                    this.users = this.users.filter(u => (u.id !== id));
                    toast.success(response.data.status, { timeout: 2000 });
                })
                .catch(error => {
                    toast.success("Erro ao banir usuário.", { timeout: 2000 });
                });
        }
    }
}
</script>

<style scoped>
 .limit-name {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100px;
 }
</style>