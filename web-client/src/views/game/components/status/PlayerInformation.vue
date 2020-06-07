<template>
    <v-card>
        <v-card-text>
            Cash: {{ cash }}
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';


    @Component
    export default class PlayerInformation extends Vue {
        get cash() {
            return 0;
        }
    }
</script>

<style scoped>

</style>
