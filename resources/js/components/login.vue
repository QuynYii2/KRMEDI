<template>


    <!-- Modal -->
    <div id="loginModal" aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" role="dialog"
         tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"></h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="text-center border border-light p-5" role="form">

                        <p class="h4 mb-4">Sign in</p>
                        <!-- Email -->
                        <input id="email" v-model="email" class="form-control mb-4" placeholder="E-mail" type="email">

                        <!-- Password -->
                        <input id="password" v-model="password" class="form-control mb-4" placeholder="Password"
                               type="password">

                        <div class="d-flex justify-content-around">
                            <div>
                                <!-- Remember me -->
                                <div class="custom-control">
                                    <input id="remember_me" v-model="remember_me" type="checkbox">
                                    <label for="defaultLoginFormRemember"> Remember me</label>
                                </div>
                            </div>
                            <div>
                                <!-- Forgot password -->
                                <a href="">Forgot password?</a>
                            </div>
                        </div>

                        <!-- Sign in button -->
                        <button :disabled="!isValidLogin" class="btn btn-info btn-block my-4" @click="attemptLogin()">
                            Sign in
                        </button>

                        <!-- Register -->
                        <p>Not a member?
                            <a href="">Register</a>
                        </p>

                        <!-- Social login -->
                        <p>or sign in with:</p>

                        <a class="mx-2" href="#" role="button"><i class="fab fa-facebook-f light-blue-text"></i></a>
                        <a class="mx-2" href="#" role="button"><i class="fab fa-twitter light-blue-text"></i></a>
                        <a class="mx-2" href="#" role="button"><i class="fab fa-linkedin-in light-blue-text"></i></a>
                        <a class="mx-2" href="#" role="button"><i class="fab fa-github light-blue-text"></i></a>

                    </form>
                    <!-- Default form login -->

                </div>
            </div>
        </div>
    </div>

</template>

<script>

import axios from "axios";

export default {
    data() {
        return {
            modalShow: false,
            email: '',
            password: '',
            remember_me: false,
        }
    },
    methods: {

        validateEmail(email) {
            if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) {
                return true;
            } else {
                return false;
            }
        },

        attemptLogin() {
            this.loading = true
            axios.post('/login',

                {
                    email: this.email, password: this.password, remember_me: this.remember_me
                }).then(function (response) {
                location.href = '/home';
                // window.location.href = '/home';
                console.log(response);
            }).catch(function (error) {
                alert("Incorrect credentails");


            });
        }


    },
    computed: {
        isValidLogin() {
            return this.validateEmail() && this.password
        }
    }
}
</script>

