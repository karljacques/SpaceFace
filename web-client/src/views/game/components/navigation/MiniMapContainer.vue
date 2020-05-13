<template>
    <v-card width="230">
        <v-card-text>
            <table style="border-collapse: collapse;">
                <tbody>
                <tr v-for="row in rows">
                    <td :style="{'background-color': getSectorColor(sector)}"
                        style="border: 1px solid white; width:45px; height:45px;"
                        v-for="sector in row">

                    </td>
                </tr>
                </tbody>
            </table>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import Component from 'vue-class-component';
    import {Vue} from 'vue-property-decorator';
    import {namespace} from 'vuex-class';
    import {Sector} from '@/objects/entity/Sector';
    import {Ship} from '@/objects/entity/Ship';
    import {Vector2} from '@/objects/entity/Vector2';
    import {Location} from '@/objects/entity/Location';

    const ship = namespace('ship');

    @Component({})
    export default class MiniMapContainer extends Vue {

        protected mapSize: number = 2;

        @ship.Getter
        protected nearbySectors!: Sector[];

        @ship.Getter
        protected currentShip!: Ship;

        get position(): Vector2 {
            return this.currentShip.location.position;
        }

        get rows(): Array<Array<Sector | null>> {

            const grid: Array<Array<Sector | null>> = [];

            for (let relativeY = 0; relativeY < (this.mapSize * 2) + 1; relativeY++) {
                grid[(this.mapSize * 2) - relativeY] = [];
                for (let relativeX = 0; relativeX < (this.mapSize * 2) + 1; relativeX++) {
                    const x = relativeX + this.position.x - this.mapSize;
                    const y = relativeY + this.position.y - this.mapSize;

                    const location = this.createLocationFromCoordinates(x, y);
                    grid[(this.mapSize * 2) - relativeY][relativeX] = this.sectorAtLocation(location);
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

        protected getSectorColor(sector: Sector | null): string {
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
    }
</script>

<style scoped>

</style>
