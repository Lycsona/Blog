import {Component, Injectable, Input, Output, EventEmitter} from "@angular/core";


@Injectable()
export class AppSharedService {
    @Output() fire: EventEmitter<any> = new EventEmitter();

    constructor() {
    }

    change() {
        this.fire.emit(true);
    }

    getEmittedValue() {
        return this.fire;
    }
}