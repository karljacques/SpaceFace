import {Ship} from '@/objects/entity/Ship';
import {Sector} from '@/objects/entity/Sector';

export class StatusResponseData {
    constructor(protected _ship: Ship, protected _sectors: Sector[]) {
    }

    get ship(): Ship {
        return this._ship;
    }

    get sectors(): Sector[] {
        return this._sectors;
    }
}
