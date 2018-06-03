export class TagDto {

    private _id?: number;
    private _createdAt?: Date;
    private _updatedAt?: Date;
    private _name?: string;

    constructor() {
        this._id = 0;
        this._createdAt = new Date;
        this._updatedAt = new Date;
        this._name = "";
    }

    get id(): number {
        return this._id;
    }

    set id(value: number) {
        this._id = value;
    }

    get createdAt(): Date {
        return this._createdAt;
    }

    set createdAt(value: Date) {
        this._createdAt = value;
    }

    get updatedAt(): Date {
        return this._updatedAt;
    }

    set updatedAt(value: Date) {
        this._updatedAt = value;
    }

    get name(): string {
        return this._name;
    }

    set name(value: string) {
        this._name = value;
    }

    public toJSON() {
        return {
            id: this._id,
            name: this._name
        };
    }
}
