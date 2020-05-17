import {Location} from '@/objects/entity/Location';

export class Dockable {
    private _location!: Location;

    public constructor(protected id: number) {
    }

    get location(): Location {
        return this._location;
    }

    public static create(data: any): Dockable {
        const dockable = new Dockable(data.id);

        dockable._location = Location.create(data.location);

        return dockable;
    }
}
