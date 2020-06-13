<template>
    <v-card class="elevation-12">
        <v-card-text>
            <v-form @keyup.native.enter="login" @submit="login">
                <v-text-field
                        label="Login"
                        name="login"
                        prepend-icon="mdi-account"
                        type="text"
                        v-model="username"
                        @enter
                ></v-text-field>

                <v-text-field
                        id="password"
                        label="Password"
                        name="password"
                        prepend-icon="mdi-lock"
                        type="password"
                        v-model="password"
                ></v-text-field>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" type="submit">Login</v-btn>
        </v-card-actions>
    </v-card>

</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {UserCredentials} from '@/store/modules/AuthenticationModule';
    import {namespace} from 'vuex-class';

    const authentication = namespace('authentication');

    @Component
    export default class LoginForm extends Vue {
        @authentication.Action
        protected authenticate!: (credentials: UserCredentials) => boolean;

        protected username: string = '';
        protected password: string = '';

        protected login(): void {
            const credentials: UserCredentials = {
                username: this.username,
                password: this.password
            };

            this.authenticate(credentials);
        }
    }
</script>

<style scoped>

</style>
