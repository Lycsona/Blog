import {Component} from "@angular/core";

@Component({
    selector: 'app-footer',
    templateUrl: 'app.footer.component.html'
})
export class AppFooterComponent {

    private author: string;
    private year: number;


    constructor() {
        this.author = "Vain Maria";
        this.year = 2018;
    }
}
