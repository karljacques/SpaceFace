import {Ship} from '@/objects/entity/Ship';

export class StatusResponseData {
    constructor(protected _ship: Ship) {
    }

    get ship(): Ship {
        return this._ship;
    }
}
