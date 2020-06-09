<template>
    <v-app id="inspire">
        <v-content>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {namespace} from 'vuex-class';
    import {UserCredentials} from '@/store/modules/AuthenticationModule';

    const ship = namespace('ship');
    const authentication = namespace('authentication');

    @Component({})
    export default class App extends Vue {
        @ship.Action
        protected refresh!: () => void;

        @authentication.Action
        protected authenticate!: (credentials: UserCredentials) => boolean;

        public async created() {
            await this.authenticate({
                username: 'TestUser',
                password: 'password'
            });


            this.refresh();

            this.$vuetify.theme.dark = true;
        }
    }
</script>
