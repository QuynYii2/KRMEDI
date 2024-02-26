<template>
    <div class="conversation">
        <h1> {{ selectedContact ? selectedContact.name : 'Select a Contact' }} </h1>
        <MessagesFeed :contact="selectedContact" :messages="messages"/>
        <MessageComposer v-on:send="sendMessage"/>
    </div>
</template>

<script>
import MessagesFeed from './MessagesFeed';
import MessageComposer from './MessageComposer';

export default {

    data: function () {
        return {}
    },

    props: {
        selectedContact: {
            type: Object,
            default: null
        },
        user: {
            type: Object,
            required: true
        },
        messages: {
            type: Array,
            required: true
        }
    },

    methods: {
        sendMessage(text) {
            if (!this.selectedContact) {
                return;
            }
            axios.post('/api/conversation/send', {
                sender_id: this.user.id,
                receiver_id: this.selectedContact.id,
                text: text
            }).then((response) => {
                this.$emit('send', response.data)
            })
                .catch(error => {
                    console.log(error);
                })

        }
    },

    components: {MessagesFeed, MessageComposer}
}
</script>

<style lang="scss" scoped>
.conversation {
    flex: 5;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    h1 {
        font-size: 20px;
        padding: 10px;
        margin: 0;
        border-bottom: 1px dashed lightgray;
    }
}
</style>
