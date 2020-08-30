<template>
    <v-card width="230">
        <v-card-text>
            <ul class="hex-grid__list">
                <template v-for="row in rows">
                    <li class="hex-grid__item" v-for="location in row">
                        <div :style="{'background-color': getSectorColor(location)}"
                             class="hex-grid__content sector-cell">
                            {{ getSectorLetter(location) }}
                        </div>
                    </li>
                </template>
            </ul>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import Component from 'vue-class-component';
    import {Vue} from 'vue-property-decorator';
    import {namespace} from 'vuex-class';
    import {Sector} from '@/objects/entity/Sector';
    import {JumpNode} from '@/objects/entity/JumpNode';
    import {Ship} from '@/objects/entity/Ship';
    import {Vector2} from '@/objects/entity/Vector2';
    import {Location} from '@/objects/entity/Location';


    const ship = namespace('ship');

    @Component({})
    export default class MiniMapHexContainer extends Vue {

        protected mapSize: number = 2;

        @ship.Getter
        protected nearbySectors!: Sector[];

        @ship.Getter
        protected nearbyJumpNodes!: JumpNode[];

        @ship.Getter
        protected nearbyDockables!: JumpNode[];

        @ship.Getter
        protected currentShip!: Ship;

        get position(): Vector2 {
            return this.currentShip.location.position;
        }

        get rows(): Array<Array<Location>> {

            const grid: Array<Array<Location>> = [];

            for (let relativeY = 0; relativeY < (this.mapSize * 2) + 1; relativeY++) {
                grid[(this.mapSize * 2) - relativeY] = [];
                for (let relativeX = 0; relativeX < (this.mapSize * 2) + 1; relativeX++) {
                    const x = relativeX + this.position.x - this.mapSize;
                    const y = relativeY + this.position.y - this.mapSize;

                    grid[(this.mapSize * 2) - relativeY][relativeX] = this.createLocationFromCoordinates(x, y);
                }
            }
            return grid;
        }

        protected sectorAtLocation(location: Location): Sector | null {
            return this.nearbySectors.find((sector: Sector) => sector.location.equals(location)) ?? null;
        }

        protected createLocationFromCoordinates(x: number, y: number): Location {
            return new Location(this.currentShip.location.system, new Vector2(x, y));
        }

        protected getSectorColor(location: Location): string {
            if (location.position.x < 1 || location.position.y < 1) {
                return '#1d1d1d';
            }

            const sector = this.sectorAtLocation(location);

            if (sector === null) {
                return 'black';
            }

            switch (sector.type) {
                case 1:
                    return '#ff1571';
                case 2:
                    return '#0472cb';
                case 3:
                    return '#be0000';
            }

            return 'orange';
        }

        protected getSectorLetter(location: Location): string {
            let str = '';

            if (this.nearbyJumpNodes.find((x: JumpNode) => x.location.equals(location))) {
                str += 'N';
            }

            if (this.nearbyDockables.find((x: JumpNode) => x.location.equals(location))) {
                str += 'S';
            }
            return str;
        }
    }
</script>

<style lang="scss" scoped>

    .sector-cell {
        width: 45px;
        height: 45px;
        text-align: center;
        font-weight: bold;
        font-size: 20px;
    }

    $block: '.hex-grid';

    @mixin grid-item($amount) {
        @for $i from 1 through $amount {
            &:nth-of-type(#{$amount}n + #{$i}) {
                grid-column: #{$i + $i - 1} / span 3;
                @if $i % 2 == 0 {
                    grid-row: calc(var(--counter) + var(--counter) - 1) / span 2;
                }
            }
        }

        @for $i from 1 through 20 {
            &:nth-of-type(n + #{$i * $amount + 1}) {
                --counter: #{$i + 1};
            }
        }
    }

    #{$block} {
        display: flex;
        justify-content: center;

        &__list {
            --amount: 5;
            position: relative;
            padding: 0;
            margin: 0;
            list-style-type: none;
            display: grid;
            grid-template-columns: repeat(var(--amount), 1fr 2fr) 1fr;
            grid-gap: 0.2em 0.5rem;
        }

        &__item {
            position: relative;
            grid-column: 1 / span 3;
            grid-row: calc(var(--counter) + var(--counter)) / span 2;
            filter: drop-shadow(0 0 10px rgba(#444, .08));
            height: 0;
            padding-bottom: 90%;
        }

        &__content {
            position: absolute;
            height: 100%;
            width: 100%;
            font-size: 1.125rem;
            clip-path: polygon(75% 0, 100% 50%, 75% 100%, 25% 100%, 0 50%, 25% 0);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            text-align: center;
            transition: transform .24s ease-out;
        }
    }

    #{$block} {
        &__list {
            --amount: 5;
            --counter: 1;
        }

        &__item {
            @include grid-item(5);
        }
    }

</style>
