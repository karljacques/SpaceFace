import {Commodity} from '@/objects/economy/Commodity';

export default class StoredCommodity {
    private _quantity!: number;
    private _commodity!: Commodity;

    get quantity(): number {
        return this._quantity;
    }

    get commodity(): Commodity {
        return this._commodity;
    }

    public static create(data: any): StoredCommodity {
        const storedCommodity = new StoredCommodity();
        storedCommodity._quantity = data.quantity;
        storedCommodity._commodity = Commodity.create(data.commodity);

        return storedCommodity;
    }
}
