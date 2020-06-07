import {Market} from '@/objects/economy/Market';

export class MarketplaceResponseData {
    constructor(
        protected _markets: Market[],
    ) {
    }


    get markets(): Market[] {
        return this._markets;
    }
}
