export class Vector2 {
    constructor(protected _x: number, protected _y: number) {
    }

    get x(): number {
        return this._x;
    }

    set x(value: number) {
        this._x = value;
    }

    get y(): number {
        return this._y;
    }

    set y(value: number) {
        this._y = value;
    }

    public add(vector: Vector2): Vector2 {
        return new Vector2(this.x + vector.x, this.y + vector.y);

    }

    public subtract(vector: Vector2): Vector2 {
        return new Vector2(this.x - vector.x, this.y - vector.y);
    }

    public equals(vector: Vector2): boolean {
        return this.x === vector.x && this.y === vector.y;
    }

    public static create(position: any): Vector2 {
        return new Vector2(position.x, position.y);
    }
}
