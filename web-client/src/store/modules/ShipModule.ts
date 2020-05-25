import {Action, Module, Mutation} from 'vuex-module-decorators';
import {Ship} from '@/objects/entity/Ship';
import {VuexContainerModule} from '@/store/modules/VuexContainerModule';
import {MovementAPIController} from '@/services/api/ship/MovementAPIController';
import {StatusAPIController} from '@/services/api/ship/StatusAPIController';
import {Sector} from '@/objects/entity/Sector';
import {JumpNode} from '@/objects/entity/JumpNode';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {Dockable} from '@/objects/entity/Dockable';

@Module({namespaced: true})
class ShipModule extends VuexContainerModule {
    protected ship: Ship | null = null;
    protected sectors: Sector[] = [];
    protected jumpNodes: JumpNode[] = [];
    protected dockables: Dockable[] = [];

    protected cooldown: boolean = false;

    protected movementApiController: MovementAPIController = this.get(MovementAPIController);
    protected statusApiController: StatusAPIController = this.get(StatusAPIController);

    get shipLoaded(): boolean {
        return this.ship !== null;
    }

    get isCooldownActive(): boolean {
        return this.cooldown;
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
    public setData(data: StatusResponseData): void {
        this.ship = data.ship;
        this.jumpNodes = data.jumpNodes;
        this.sectors = data.sectors;
        this.dockables = data.dockables;
    }

    @Mutation
    public setPower(power: number): void {
        if (this.ship) {
            this.ship.power = power;
        }
    }

    @Mutation
    public setCooldown(active: boolean): void {
        this.cooldown = active;
    }

    @Action
    public async moveInDirection(direction: string): Promise<void> {
        const result = await this.movementApiController.move(direction);

        if (result.success) {
            this.context.commit('setData', result.data);
            this.context.commit('setCooldown', true);
        }
    }

    @Action
    public async jump(jumpNode: JumpNode): Promise<void> {
        const result = await this.movementApiController.jump(jumpNode);

        if (result.success) {
            this.context.commit('setData', result.data);
            this.context.commit('setCooldown', true);

        }
    }

    @Action
    public async dock(dockable: Dockable): Promise<void> {
        const result = await this.movementApiController.dock(dockable);

        if (result.success) {
            this.context.commit('setData', result.data);
            this.context.commit('setCooldown', true);
        }
    }

    @Action
    public async undock(): Promise<void> {
        const result = await this.movementApiController.undock();

        if (result.success) {
            this.context.commit('setData', result.data);
            this.context.commit('setCooldown', true);
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
