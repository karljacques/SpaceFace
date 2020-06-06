import {AbstractAPIController} from '@/services/api/AbstractAPIController';
import {sharedProvide} from '@/sharedProvide';
import {inject} from 'inversify';
import {MarketplaceResponseFactory} from '@/services/factory/MarketplaceResponseFactory';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {MarketplaceResponseData} from '@/objects/response/MarketplaceResponseData';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {MarketCommodity} from '@/objects/economy/MarketCommodity';
import {StatusResponseFactory} from '@/services/factory/StatusResponseFactory';

@sharedProvide(MarketplaceAPIController)
export class MarketplaceAPIController extends AbstractAPIController {
    @inject(MarketplaceResponseFactory)
    protected responseFactory!: MarketplaceResponseFactory;

    @inject(StatusResponseFactory)
    protected statusResponseFactory!: StatusResponseFactory;

    public async fetch(): Promise<CommandResponse<MarketplaceResponseData>> {
        const uri = '/economy/markets';

        const response = await this.http.get(uri);

        return new CommandResponse<MarketplaceResponseData>(
            response.data.success,
            [],
            this.responseFactory.createResponse(response.data.data),
        );
    }

    public async sell(
        marketCommodity: MarketCommodity,
        quantity: number,
    ): Promise<CommandResponse<StatusResponseData>> {
        const uri = '/economy/market/sell';

        const data = {
            market_commodity_id: marketCommodity.id,
            price: marketCommodity.buy,
            quantity,
        };

        const response = await this.http.post(uri, data);

        return new CommandResponse<StatusResponseData>(
            response.data.success,
            [],
            this.statusResponseFactory.createStatusResponse(response.data.data),
        );
    }

    public async buy(
        marketCommodity: MarketCommodity,
        quantity: number,
    ): Promise<CommandResponse<StatusResponseData>> {
        const uri = '/economy/market/purchase';

        const data = {
            market_commodity_id: marketCommodity.id,
            price: marketCommodity.sell,
            quantity,
        };

        const response = await this.http.post(uri, data);

        return new CommandResponse<StatusResponseData>(
            response.data.success,
            [],
            this.statusResponseFactory.createStatusResponse(response.data.data),
        );
    }

}
