import {MarketCommodity} from '@/objects/economy/MarketCommodity';

export class Market {
    private _marketCommodities: MarketCommodity[] = [];

    get marketCommodities(): MarketCommodity[] {
        return this._marketCommodities;
    }

    public static create(data: any): Market {
        const market = new Market();

        market._marketCommodities = data.marketCommodities.map((x: any) => MarketCommodity.create(x));

        return market;
    }
}
