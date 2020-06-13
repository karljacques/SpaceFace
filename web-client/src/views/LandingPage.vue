<template>
    <v-container>
        <v-row>
            <v-col>
                <h1 class="display-3">Space<b style="color: #ecec49;">Face</b></h1>
            </v-col>
        </v-row>
        <v-row>

            <v-col cols="8">
                SpaceFace splash screen
            </v-col>
            <v-col cols="4">
                <login-form/>
            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts">
    import {Component, Vue} from "vue-property-decorator";
    import LoginForm from '@/views/LoginForm.vue';

    @Component({
        components: {LoginForm}
    })
    export default class LandingPage extends Vue {

    }
</script>

<style scoped>

</style>
