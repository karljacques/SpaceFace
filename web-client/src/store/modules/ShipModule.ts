import {Action, Module, Mutation} from 'vuex-module-decorators';
import {Ship} from '@/objects/entity/Ship';
import {VuexContainerModule} from '@/store/modules/VuexContainerModule';
import {MovementAPIController} from '@/services/api/ship/MovementAPIController';
import {Location} from '@/objects/entity/Location';

@Module({namespaced: true})
class ShipModule extends VuexContainerModule {
    protected ship: Ship | null = null;

    protected movementApiController: MovementAPIController = this.get(MovementAPIController);

    get shipLoaded(): boolean {
        return this.ship !== null;
    }

    get currentLocation(): Location {
        return this.ship.location;
    }

    @Mutation
    public setShip(ship: Ship): void {
        this.ship = ship;
    }

    @Action
    public async moveInDirection(direction: string): Promise<any> {
        const result = await this.movementApiController.moveInDirection(direction);

        if (result.success) {
            this.context.commit('setShip', result.data.ship);
        }
    }
}

export {ShipModule};
