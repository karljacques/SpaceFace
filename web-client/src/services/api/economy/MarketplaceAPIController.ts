import {AbstractAPIController} from '@/services/api/AbstractAPIController';
import {sharedProvide} from '@/sharedProvide';
import {inject} from 'inversify';
import {MarketplaceResponseFactory} from '@/services/factory/MarketplaceResponseFactory';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {MarketplaceResponseData} from '@/objects/response/MarketplaceResponseData';

@sharedProvide(MarketplaceAPIController)
export class MarketplaceAPIController extends AbstractAPIController {
    @inject(MarketplaceResponseFactory)
    protected responseFactory!: MarketplaceResponseFactory;

    public async fetch(): Promise<CommandResponse<MarketplaceResponseData>> {
        const uri = '/economy/markets';

        const response = await this.http.get(uri);

        return new CommandResponse<MarketplaceResponseData>(
            response.data.success,
            [],
            this.responseFactory.createResponse(response.data.data),
        );
    }

}
