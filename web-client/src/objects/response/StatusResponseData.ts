import {Ship} from '@/objects/entity/Ship';
import {Sector} from '@/objects/entity/Sector';
import {JumpNode} from '@/objects/entity/JumpNode';
import {Dockable} from '@/objects/entity/Dockable';

export class StatusResponseData {
    constructor(
        protected _ship: Ship,
        protected _sectors: Sector[],
        protected _jumpNodes: JumpNode[],
        protected _dockables: Dockable[],
    ) {
    }

    get ship(): Ship {
        return this._ship;
    }

    get sectors(): Sector[] {
        return this._sectors;
    }

    get jumpNodes(): JumpNode[] {
        return this._jumpNodes;
    }

    get dockables(): Dockable[] {
        return this._dockables;
    }
}
