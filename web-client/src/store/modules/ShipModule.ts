import {Action, Module} from 'vuex-module-decorators';
import {Ship} from '@/objects/entity/Ship';
import {VuexContainerModule} from '@/store/modules/VuexContainerModule';
import {MovementAPIController} from '@/services/api/ship/MovementAPIController';

@Module({namespaced: true})
class ShipModule extends VuexContainerModule {
    public ship!: Ship;

    protected movementApiController: MovementAPIController = this.get(MovementAPIController);

    @Action
    public async moveInDirection(direction: string): Promise<any> {
        const result = await this.movementApiController.moveInDirection(direction);
        console.log(result);
    }
}

export {ShipModule};
