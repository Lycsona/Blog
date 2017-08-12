export class ArticleDto {
    private _id?: number;
    private _name?: string;
    private _content?: string;

    constructor(id: number, name: string, content: string) {
        this._id = id;
        this._name = name;
        this._content = content;
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

    get content(): string {
        return this._content;
    }

    set content(value: string) {
        this._content = value;
    }

    public toJSON() {
        return {
            id: this._id,
            name: this._name,
            content: this._content
        };
    }
}