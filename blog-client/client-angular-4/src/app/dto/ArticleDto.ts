import {TagDto} from "./TagDto";

export class ArticleDto {
    private _id?: number;
    private _name?: string;
    private _content?: string;
    private _image?: any;
    private _createdAt?: Date;
    private _updatedAt?: Date;
    private _tags?: TagDto[];

    constructor() {
        this._id = 0;
        this._name = '';
        this._content = '';
        this._image = '';
        this._createdAt = new Date;
        this._updatedAt = new Date;
        this._tags = [];
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

    get tags(): TagDto[] {
        return this._tags;
    }

    set tags(value: TagDto[]) {
        this._tags = value;
    }

    get image(): object {
        return this._image;
    }

    set image(value: object) {
        this._image = value;
    }

    public toJSON() {
        return {
            name: this._name,
            content: this._content,
            image: this._image,
            tags: this._tags
        };
    }
}
