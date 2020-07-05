import {Location} from '@/objects/entity/Location';
import Storage from '@/objects/entity/Storage';

export class Ship {
    private _maxFuel: number = 0;
    private _fuel: number = 0;

    private _maxPower: number = 0;
    private _power: number = 0;

    private _docked: boolean = false;
    protected _location!: Location;

    private _cargo!: Storage;

    get cargo(): Storage {
        return this._cargo;
    }

    public static create(data: any): Ship {
        const ship = new Ship();

        ship.location = Location.create(data.location);
        ship._fuel = data.fuel;
        ship._maxFuel = data.maxFuel;

        ship.power = data.power;
        ship.maxPower = data.maxPower;

        ship.docked = data.docked;

        ship._cargo = Storage.create(data.cargo);

        return ship;
    }

    get location(): Location {
        return this._location;
    }

    set location(value: Location) {
        this._location = value;
    }

    get fuel(): number {
        return this._fuel;
    }

    set fuel(value: number) {
        this._fuel = value;
    }

    get maxFuel(): number {
        return this._maxFuel;
    }

    set maxFuel(value: number) {
        this._maxFuel = value;
    }


    get docked(): boolean {
        return this._docked;
    }

    set docked(value: boolean) {
        this._docked = value;
    }


    get maxPower(): number {
        return this._maxPower;
    }

    set maxPower(value: number) {
        this._maxPower = value;
    }

    get power(): number {
        return this._power;
    }

    set power(value: number) {
        this._power = value;
    }
}
