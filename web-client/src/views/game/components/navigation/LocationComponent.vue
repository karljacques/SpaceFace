<template>
    <div>
        System: {{ location.system.designation }} ({{ location.system.name }})<br>
        X: {{ location.position.x }}<br>
        Y: {{ location.position.y }}<br>
    </div>
</template>

<script lang="ts">
    import {Prop, Vue} from 'vue-property-decorator';
    import Component from 'vue-class-component';
    import {Location} from '@/objects/entity/Location';

    @Component
    export default class LocationComponent extends Vue {
        @Prop({})
        protected location!: Location;

    }
</script>

<style scoped>

</style>
