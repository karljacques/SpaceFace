import {Location} from '@/objects/entity/Location';

export class JumpNode {
    private _exitLocation: Location | null = null;

    public constructor(protected _id: number, protected _location: Location) {
    }

    get id(): number {
        return this._id;
    }

    set id(value: number) {
        this._id = value;
    }

    get location(): Location {
        return this._location;
    }

    set location(value: Location) {
        this._location = value;
    }

    get exitLocation(): Location | null {
        return this._exitLocation;
    }

    set exitLocation(value: Location | null) {
        this._exitLocation = value;
    }
}
