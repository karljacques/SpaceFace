import {Action, Module, Mutation} from 'vuex-module-decorators';
import {Ship} from '@/objects/entity/Ship';
import {VuexContainerModule} from '@/store/modules/VuexContainerModule';
import {MovementAPIController} from '@/services/api/ship/MovementAPIController';
import {StatusAPIController} from '@/services/api/ship/StatusAPIController';
import {Sector} from '@/objects/entity/Sector';
import {JumpNode} from '@/objects/entity/JumpNode';
import {JumpAPIController} from '@/services/api/ship/JumpAPIController';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {Dockable} from '@/objects/entity/Dockable';

@Module({namespaced: true})
class ShipModule extends VuexContainerModule {
    protected ship: Ship | null = null;
    protected sectors: Sector[] = [];
    protected jumpNodes: JumpNode[] = [];
    protected dockables: Dockable[] = [];

    protected movementApiController: MovementAPIController = this.get(MovementAPIController);
    protected statusApiController: StatusAPIController = this.get(StatusAPIController);
    protected jumpApiController: JumpAPIController = this.get(JumpAPIController);


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

    get nearbyJumpNodes(): JumpNode[] {
        return this.jumpNodes;
    }

    get nearbyDockables(): Dockable[] {
        return this.dockables;
    }

    @Mutation
    public setShip(ship: Ship): void {
        this.ship = ship;
    }

    @Mutation
    public setSectors(sectors: Sector[]): void {
        this.sectors = sectors;
    }

    @Mutation
    public setJumpNodes(jumpNodes: JumpNode[]): void {
        this.jumpNodes = jumpNodes;
    }

    @Mutation
    public setData(data: StatusResponseData): void {
        this.ship = data.ship;
        this.jumpNodes = data.jumpNodes;
        this.sectors = data.sectors;
        this.dockables = data.dockables;
    }

    @Action
    public async moveInDirection(direction: string): Promise<void> {
        const result = await this.movementApiController.moveInDirection(direction);

        if (result.success) {
            this.context.commit('setData', result.data);
        }
    }

    @Action
    public async jump(jumpNode: JumpNode): Promise<void> {
        const result = await this.jumpApiController.jump(jumpNode);

        if (result.success) {
            this.context.commit('setData', result.data);
        }
    }

    @Action
    public async refresh(): Promise<void> {
        const result = await this.statusApiController.refresh();

        if (result.success) {
            this.context.commit('setData', result.data);
        }
    }
}

export {ShipModule};
