import {sharedProvide} from '@/sharedProvide';
import {MarketplaceResponseData} from '@/objects/response/MarketplaceResponseData';
import {Market} from '@/objects/economy/Market';

@sharedProvide(MarketplaceResponseFactory)
export class MarketplaceResponseFactory {
    public createResponse(data: any) {
        return new MarketplaceResponseData(data.markets.map((x: any) => Market.create(x)));
    }
}
