<template>
    <v-data-table :headers="headers" :items="getData">
        <template v-slot:item.quantity="props">
            <v-text-field type="number" v-model.number="props.item.quantity"></v-text-field>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-btn @click="sell(item.id, item.quantity)" color="primary">Sell</v-btn>
        </template>
    </v-data-table>
</template>

<script lang="ts">

    import {Component, Prop, Vue} from 'vue-property-decorator';
    import {MarketCommodity} from '@/objects/economy/MarketCommodity';
    import {Ship} from '@/objects/entity/Ship';
    import {namespace} from 'vuex-class';
    import {container} from '@/container';
    import {MarketplaceAPIController} from '@/services/api/economy/MarketplaceAPIController';
    import {StatusResponseData} from '@/objects/response/StatusResponseData';

    const ship = namespace('ship');

    @Component
    export default class SellTable extends Vue {
        @Prop({required: true})
        protected commodities!: MarketCommodity[];

        @ship.Getter
        protected currentShip!: Ship;

        protected marketplaceApiController: MarketplaceAPIController = container.get(MarketplaceAPIController);

        @ship.Mutation
        protected setData!: (data: StatusResponseData) => void;

        get headers() {
            return [
                {
                    text: 'Name',
                    value: 'name',
                },
                {
                    text: 'Price',
                    value: 'price'
                },
                {
                    text: 'Available',
                    value: 'available'
                },
                {
                    text: 'Quantity',
                    value: 'quantity',
                    sortable: false
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ];
        }

        get getData() {
            return this.commodities.map((x: MarketCommodity) => {
                const available = this.currentShip.cargo.findCommodity(x.commodity.id)?.quantity ?? 0;

                return {
                    id: x.id,
                    name: x.commodity.name,
                    price: x.buy,
                    available,
                    quantity: available
                }
            });
        }

        protected async sell(itemId: number, quantity: number) {
            const marketCommodity = this.commodities.find((x: MarketCommodity) => {
                return x.id === itemId;
            }) ?? null;

            if (marketCommodity === null) {
                // This should never happen
                return;
            }

            const response = await this.marketplaceApiController.sell(marketCommodity, quantity);

            this.setData(response.data);
        }
    }
</script>

<style scoped>

</style>
