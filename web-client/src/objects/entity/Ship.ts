import {Location} from '@/objects/entity/Location';

export class Ship {
    constructor(protected _location: Location) {
    }

    get location(): Location {
        return this._location;
    }

    set location(value: Location) {
        this._location = value;
    }
}
