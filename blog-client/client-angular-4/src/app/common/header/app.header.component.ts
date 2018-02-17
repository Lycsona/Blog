import {Component, Injectable} from "@angular/core";
import {AuthService} from "../auth.service";
import {NavigationService} from "../navigation.service";

@Component({
    selector: 'app-header',
    templateUrl: 'app.header.component.html'
})
@Injectable()
export class AppHeaderComponent {
    private _headerImage: string;

    constructor() {
        this._headerImage = "";
        this.author = "Ostashevskaya Maria";
        this.year = 2018;
    }

    get headerImage(): string {
        return this._headerImage;
    }

    set headerImage(value: string) {
        this._headerImage = value;
    }
}
