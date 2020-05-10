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

    @Component({})
    export default class App extends Vue {
        public created() {
            this.$vuetify.theme.dark = true
        }
    }
</script>
