import {Ship} from '@/objects/entity/Ship';
import {Sector} from '@/objects/entity/Sector';
import {JumpNode} from '@/objects/entity/JumpNode';
import {Dockable} from '@/objects/entity/Dockable';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {MovementAPIController} from '@/services/api/ship/MovementAPIController';
import {StatusAPIController} from '@/services/api/ship/StatusAPIController';
import {container} from '@/container';

const movementApiController: MovementAPIController = container.get(MovementAPIController);
const statusApiController: StatusAPIController = container.get(StatusAPIController);

export interface ShipModuleState {
    ship: Ship | null;
    sectors: Sector[];
    jumpNodes: JumpNode[];
    dockables: Dockable[];

    cooldown: boolean;
}

export default {
    namespaced: true,
    state: {
        ship: null,
        sectors: [],
        jumpNodes: [],
        dockables: [],

        cooldown: false,
    } as ShipModuleState,
    getters: {
        shipLoaded: (state: ShipModuleState): boolean => {
            return state.ship !== null;
        },
        isCooldownActive: (state: ShipModuleState): boolean => {
            return state.cooldown;
        },
        currentShip: (state: ShipModuleState): Ship => {
            if (state.ship === null) {
                throw new Error('LogicException - ship is not yet loaded');
            }

            return state.ship;
        },
        nearbySectors: (state: ShipModuleState): Sector[] => {
            return state.sectors;
        },
        nearbyJumpNodes: (state: ShipModuleState): JumpNode[] => {
            return state.jumpNodes;
        },
        nearbyDockables: (state: ShipModuleState): Dockable[] => {
            return state.dockables;
        },
    },
    mutations: {
        setData: (state: ShipModuleState, data: StatusResponseData): void => {
            state.ship = data.ship;
            state.jumpNodes = data.jumpNodes;
            state.sectors = data.sectors;
            state.dockables = data.dockables;
        },
        setPower: (state: ShipModuleState, power: number): void => {
            if (state.ship) {
                state.ship.power = power;
            }
        },
        setCooldown: (state: ShipModuleState, active: boolean): void => {
            state.cooldown = active;
        },
    },
    actions: {
        moveInDirection: async (context: any, direction: string): Promise<void> => {
            const result = await movementApiController.move(direction);

            if (result.success) {
                context.commit('setData', result.data);
                context.commit('setCooldown', true);
            }
        },
        jump: async (context: any, jumpNode: JumpNode): Promise<void> => {
            const result = await movementApiController.jump(jumpNode);

            if (result.success) {
                context.commit('setData', result.data);
                context.commit('setCooldown', true);
            }
        },
        dock: async (context: any, dockable: Dockable): Promise<void> => {
            const result = await movementApiController.dock(dockable);

            if (result.success) {
                context.commit('setData', result.data);
                context.commit('setCooldown', true);
            }
        },
        undock: async (context: any): Promise<void> => {
            const result = await movementApiController.undock();

            if (result.success) {
                context.commit('setData', result.data);
                context.commit('setCooldown', true);
            }
        },
        refresh: async (context: any): Promise<void> => {
            const result = await statusApiController.refresh();

            if (result.success) {
                context.commit('setData', result.data);
            }
        },
    },
};
