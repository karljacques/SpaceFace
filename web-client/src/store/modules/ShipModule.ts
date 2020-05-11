import {Action, Module, Mutation} from 'vuex-module-decorators';
import {Ship} from '@/objects/entity/Ship';
import {VuexContainerModule} from '@/store/modules/VuexContainerModule';
import {MovementAPIController} from '@/services/api/ship/MovementAPIController';

@Module({namespaced: true})
class ShipModule extends VuexContainerModule {
    public ship: Ship = new Ship();

    protected movementApiController: MovementAPIController = this.get(MovementAPIController);

    @Mutation
    public setLocation(systemId: number, x: number, y: number): void {
        this.ship.systemId = systemId;
        this.ship.x = x;
        this.ship.y = y;
    }

    @Action
    public async moveInDirection(direction: string): Promise<any> {
        const result = await this.movementApiController.moveInDirection(direction);
        console.log(result);
    }
}

export {ShipModule};
