<template>
    <div class="d-flex bottom-0 absolute w-full border-none" v-if="!$page.props.auth.user.banned">
        <input id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Digite a sua mensagem aqui" v-model="newMessage" @keyup.enter="sendMessage" autocomplete="">
        <span class="input-group-btn">
            <button class="w-full h-full px-2 bg-black" id="btn-chat" @click="sendMessage">
                Enviar
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                newMessage: ''
            }
        },
        methods: {
            sendMessage() {
                this.$emit('messagesent', {
                        user: this.user,
                        message: this.newMessage
                });

                this.newMessage = ''
            }
        }    
    }
</script>