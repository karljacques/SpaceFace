<template>
    <v-container>
        <v-row v-for="market in markets">
            <v-col>
                Market #
                <sell-table :bought-commodities="boughtCommodities(market)"/>
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
    import SellTable from '@/views/game/components/dockable/Marketplace/SellTable.vue';

    @Component({
        components: {SellTable}
    })
    export default class MarketplaceComponent extends Vue {
        protected http: HttpClient = container.get(HttpClient);
        protected api: MarketplaceAPIController = container.get(MarketplaceAPIController);

        protected markets: Market[] = [];

        async created() {
            const marketData = await this.api.fetch();

            this.markets = marketData.data.markets;
        }

        protected boughtCommodities(market: Market): MarketCommodity[] {
            return market.marketCommodities.filter((commodity: MarketCommodity) => {
                return null !== commodity.buy;
            });
        }

    }
</script>

<style scoped>

</style>
