import {Location} from '@/objects/entity/Location';

export class Ship {
    private _maxFuel: number = 0;
    private _fuel: number = 0;

    private _maxPower: number = 0;
    private _power: number = 0;

    private _docked: boolean = false;

    constructor(protected _location: Location) {
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
