export class System {


    constructor(protected _id: number,
                protected _name: string,
                protected _designation: string) {
    }

    get id(): number {
        return this._id;
    }

    set id(value: number) {
        this._id = value;
    }

    get name(): string {
        return this._name;
    }

    set name(value: string) {
        this._name = value;
    }

    get designation(): string {
        return this._designation;
    }

    set designation(value: string) {
        this._designation = value;
    }

    public static create(system: any) {
        return new System(system.id, system.name, system.designation);
    }

}
