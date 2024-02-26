<template>
    <div class="chat-app">
        <div class="col-md-3">
            <contact-list :contacts="contacts" v-on:selected="startConversationWith"/>
        </div>

        <div class="col-md-9">
            <conversation :messages="messages" :selectedContact="selectedContact" :user="user"
                          v-on:send="saveNewMessage"/>
        </div>

        <!-- :contact="selectedContact" -->

    </div>
</template>

<script>
import Conversation from './Conversation';
import ContactList from './ContactList';

export default {
    components: {
        ContactList, Conversation
    },

    data: function () {
        return {
            messages: [],
            contacts: [],
            selectedContact: null,
        }
    }
    ,
    props: {

        user: {
            type: Object,
            required: true
        }
    },

    mounted() {

        Echo.channel(`messages.${this.user.id}`)
            .listen('NewMessage', (e) => {
                this.handleIncoming(e.message)
            });

        axios.get('/api/contact-list/' + this.user.id)
            .then(response => {
                this.contacts = response.data;
            })
            .catch(error => {
                console.log(error);
            })
    },
    methods: {
        startConversationWith(contact) {
            this.updateUnreadCount(contact, true);
            axios.get('/api/conversation/' + contact.id + '/' + this.user.id)
                .then(response => {
                    this.messages = response.data;
                    this.selectedContact = contact;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        saveNewMessage(msg) {
            this.messages.push(msg);
        },
        handleIncoming(message) {

            if (this.selectedContact && message.from == this.selectedContact.id) {
                this.saveNewMessage(message);
                return;
            }
            this.updateUnreadCount(message.from_contact, false);
        },
        updateUnreadCount(contact, reset) {
            this.contacts == this.contacts.map((single) => {
                if (single.id != contact.id) {
                    return single;
                }
                if (reset) {
                    single.unread = 0;
                } else {
                    single.unread += 1;
                }
                return single;

            })
        }
    }


}
</script>

<style lang="scss" scoped>
.chat-app {
    display: flex;
}
</style>
