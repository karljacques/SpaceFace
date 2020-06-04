import {Location} from '@/objects/entity/Location';

export class Sector {
    public constructor(protected _type: number, protected _location: Location) {
    }


    get type(): number {
        return this._type;
    }

    get location(): Location {
        return this._location;
    }
}
