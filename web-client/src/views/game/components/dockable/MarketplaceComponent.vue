<template>
    <v-container>
        <v-row v-for="market in markets">
            <v-col>
                Market #
                <v-data-table :headers="headers" :items="getData(market)">

                </v-data-table>
            </v-col>
        </v-row>

    </v-container>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {container} from '@/container';
    import {HttpClient} from '@/services/connectivity/HttpClient';
    import {MarketplaceAPIController} from '@/services/api/economy/MarketplaceAPIController';
    import {Market} from '@/objects/economy/Market';
    import {MarketCommodity} from '@/objects/economy/MarketCommodity';

    @Component
    export default class MarketplaceComponent extends Vue {
        protected http: HttpClient = container.get(HttpClient);
        protected api: MarketplaceAPIController = container.get(MarketplaceAPIController);

        protected markets: Market[] = [];

        get headers() {
            return [
                {
                    text: 'Name',
                    value: 'name',
                },
                {
                    text: 'Price',
                    value: 'price'
                }
            ];
        }

        async created() {
            const marketData = await this.api.fetch();

            this.markets = marketData.data.markets;
        }

        protected getData(market: Market) {
            return market.marketCommodities.map((x: MarketCommodity) => ({
                name: x.commodity.name,
                price: x.buy
            }));
        }
    }
</script>

<style scoped>

</style>
