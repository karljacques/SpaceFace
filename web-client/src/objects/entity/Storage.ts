import StoredCommodity from '@/objects/entity/StoredCommodity';

export default class Storage {
    private _id!: number;
    private _capacity!: number;
    private _usage!: number;

    private _storedCommodities!: StoredCommodity[];

    get id(): number {
        return this._id;
    }

    get capacity(): number {
        return this._capacity;
    }

    get usage(): number {
        return this._usage;
    }

    get storedCommodities(): StoredCommodity[] {
        return this._storedCommodities;
    }

    public static create(data: any): Storage {
        const storage = new Storage();

        storage._capacity = data.capacity;
        storage._usage = data.capacityUsage;
        storage._id = data.id;

        storage._storedCommodities = data.storedCommodities.map((x: any) => StoredCommodity.create(x));

        return storage;
    }

    public findCommodity(id: number): StoredCommodity | null {
        return this.storedCommodities.find((x: StoredCommodity) => x.commodity.id === id) ?? null;
    }
}
