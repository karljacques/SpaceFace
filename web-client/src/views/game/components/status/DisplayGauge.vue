<template>
    <span :style="{color}">{{ parseInt(this.current) }}/{{ this.maximum }}</span>
</template>

<script lang="ts">
    import Component from 'vue-class-component';
    import {Prop, Vue} from 'vue-property-decorator';

    @Component
    export default class DisplayGauge extends Vue {
        @Prop() protected current!: number;
        @Prop() protected maximum!: number;

        @Prop({default: false}) protected invert!: boolean;

        get percentage(): number {
            if (this.invert) {
                return 1 - (this.current / this.maximum);
            } else {
                return this.current / this.maximum;
            }
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
