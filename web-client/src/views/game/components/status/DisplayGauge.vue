<template>
    <span :style="{color}">{{ this.current }}/{{ this.maximum }}</span>
</template>

<script lang="ts">
    import {VueContainer} from '@/VueContainer';
    import Component from 'vue-class-component';
    import {Prop} from 'vue-property-decorator';

    @Component
    export default class DisplayGauge extends VueContainer {
        @Prop() protected current!: number;
        @Prop() protected maximum!: number;

        get percentage(): number {
            return this.current / this.maximum;
        }

        get color(): string {
            if (this.percentage < 0.2) {
                return 'red';
            }

            if (this.percentage < 0.4) {
                return 'orange';
            }

            return 'green';
        }
    }
</script>

<style scoped>

</style>
