import {Commodity} from '@/objects/economy/Commodity';

export class MarketCommodity {
    private _id!: number;
    private _commodity!: Commodity;
    private _sell!: number | null;
    private _buy!: number | null;

    get id(): number {
        return this._id;
    }

    get commodity(): Commodity {
        return this._commodity;
    }

    get sell(): number | null {
        return this._sell;
    }

    get buy(): number | null {
        return this._buy;
    }

    public static create(x: any): MarketCommodity {
        const mc = new MarketCommodity();

        mc._commodity = Commodity.create(x.commodity);
        mc._id = x.id;
        mc._sell = x.sell;
        mc._buy = x.buy;

        return mc;
    }
}
