<template>
    <div class="contact-list">
        <ul>
            <li v-for="contact in sortedContacts" :key="contact.id" :class="{'selected' : contact == selected}"
                @click="selectContact(contact)">
                <div class="avatar">
                    <img :alt="contact.name" :src="contact.profile_image">
                </div>
                <div class="contact">
                    <p class="name">{{ contact.name }}</p>
                    <p class="email">{{ contact.email }}</p>
                </div>
                <span v-if="contact.unread" class="unread">
                    {{ contact.unread }}
                </span>
                <!-- <p v-else>Not running</p> -->
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            selected: this.contacts.length ? this.contacts[0] : null
        }
    },
    props: {
        contacts: {
            type: Array,
            default: []
        },
    },
    methods: {
        selectContact(contact) {
            this.selected = contact;
            this.$emit('selected', contact)
        }
    },
    computed: {
        sortedContacts() {
            return _.sortBy(this.contacts, [(contact) => {
                if (contact == this.selected) {
                    return Infinity;
                }
                return contact.unread;
            }]).reverse();
        }
    }
}
</script>

<style lang="scss" scoped>
.contact-list {
    flex: 2;
    margin-left: -16px;
    max-height: 400px;
    overflow-y: scroll;
    border-left: 1px solid #a6a6a6;

    ul {
        list-style-type: none;
        padding-left: 0;

        li {
            display: flex;
            padding: 2px;
            border-bottom: 1px solid #aaaaaa;
            height: 80px;
            position: relative;
            cursor: pointer;

            &.selected {
                background: #dfdfdf;;
            }

            span.unread {
                background: #82e0a8;
                color: white;
                position: absolute;
                right: 11px;
                top: 20px;
                display: flex;
                font-weight: 700;
                min-width: 20px;
                justify-content: center;
                align-items: center;
                line-height: 20px;
                font-size: 12px;
                padding: 0 4px;
                border-radius: 50%;
            }

            .avatar {
                flex: 1;
                display: flex;
                align-items: center;

                img {
                    width: 35px;
                    border-radius: 50%;
                    margin: 0 auto;
                }
            }

            .contact {
                flex: 3;
                font-size: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;

                p {
                    margin: 0;

                    &.name {
                        font-weight: bold;
                    }
                }
            }


        }
    }
}
</style>
