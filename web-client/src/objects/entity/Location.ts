import {Vector2} from '@/objects/entity/Vector2';
import {System} from '@/objects/entity/System';


export class Location {
    constructor(protected _system: System, protected _position: Vector2) {
    }

    get system(): System {
        return this._system;
    }

    set system(value: System) {
        this._system = value;
    }

    get position(): Vector2 {
        return this._position;
    }

    set position(value: Vector2) {
        this._position = value;
    }

    public static create(data: any): Location {
        const system = System.create(data.system);
        const vector = Vector2.create(data.position);

        return new Location(system, vector);
    }
}
