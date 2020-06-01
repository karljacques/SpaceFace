export class Commodity {
    public constructor(
        protected _id: number,
        protected _name: string,
        protected _size: number,
        protected _weight: number) {

    }

    get id(): number {
        return this._id;
    }

    get name(): string {
        return this._name;
    }

    get size(): number {
        return this._size;
    }

    get weight(): number {
        return this._weight;
    }

    public static create(commodity: any): Commodity {
        return new Commodity(
            commodity.id,
            commodity.name,
            commodity.size,
            commodity.weight,
        );
    }
}
