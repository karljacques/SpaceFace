import {MarketCommodity} from '@/objects/economy/MarketCommodity';

export class Market {
    protected marketCommodities: MarketCommodity[] = [];

    public static create(): Market {
        const market = new Market();

        market.marketCommodities = [];

        return market;
    }
}
