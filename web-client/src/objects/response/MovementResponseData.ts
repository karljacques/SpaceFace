import {Ship} from '@/objects/entity/Ship';

export class MovementResponseData {
    constructor(protected _ship: Ship) {
    }


    get ship(): Ship {
        return this._ship;
    }
}
