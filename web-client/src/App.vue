<template>
    <v-app id="inspire">
        <game v-if="isAuthenticated"/>
        <landing-page v-else/>
    </v-app>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {namespace} from 'vuex-class';
    import Game from '@/Game.vue';
    import LandingPage from '@/views/LandingPage.vue';

    const authentication = namespace('authentication');

    @Component({
        components: {LandingPage, Game}
    })
    export default class App extends Vue {
        @authentication.Getter
        protected isAuthenticated!: boolean;

        public async created() {
            this.$vuetify.theme.dark = true;
        }
    }
</script>
