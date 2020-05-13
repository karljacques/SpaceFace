import {Action, Module, Mutation} from 'vuex-module-decorators';
import {Ship} from '@/objects/entity/Ship';
import {VuexContainerModule} from '@/store/modules/VuexContainerModule';
import {MovementAPIController} from '@/services/api/ship/MovementAPIController';
import {StatusAPIController} from '@/services/api/ship/StatusAPIController';
import {Sector} from '@/objects/entity/Sector';

@Module({namespaced: true})
class ShipModule extends VuexContainerModule {
    protected ship: Ship | null = null;
    protected sectors: Sector[] = [];

    protected movementApiController: MovementAPIController = this.get(MovementAPIController);
    protected statusApiController: StatusAPIController = this.get(StatusAPIController);

    get shipLoaded(): boolean {
        return this.ship !== null;
    }

    get currentShip(): Ship {
        if (!this.ship) {
            throw new Error('LogicException - ship not set');
        }

        return this.ship;
    }

    get nearbySectors(): Sector[] {
        return this.sectors;
    }

    @Mutation
    public setShip(ship: Ship): void {
        this.ship = ship;
    }

    @Mutation
    public setSectors(sectors: Sector[]): void {
        this.sectors = sectors;
    }

    @Action
    public async moveInDirection(direction: string): Promise<void> {
        const result = await this.movementApiController.moveInDirection(direction);

        if (result.success) {
            this.context.commit('setShip', result.data.ship);
            this.context.commit('setSectors', result.data.sectors);
        }
    }

    @Action
    public async refresh(): Promise<void> {
        const result = await this.statusApiController.refresh();

        if (result.success) {
            this.context.commit('setShip', result.data.ship);
            this.context.commit('setSectors', result.data.sectors);
        }
    }
}

export {ShipModule};
