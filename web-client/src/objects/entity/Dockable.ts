import {Location} from '@/objects/entity/Location';

export class Dockable {
    private _location!: Location;

    public constructor(protected _id: number) {
    }

    get location(): Location {
        return this._location;
    }

    public static create(data: any): Dockable {
        const dockable = new Dockable(data.id);

        dockable._location = Location.create(data.location);

        return dockable;
    }


    get id(): number {
        return this._id;
    }
}
