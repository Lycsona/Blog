import {Component, OnInit, Injectable} from "@angular/core";
import {AuthService} from "../auth.service";
import {NavigationService} from "../navigation.service";
import {AppLogoutService} from "../../service/app.logout.service";
import {CommonUtil} from "../../util/common.util";
import {Router} from "@angular/router";
import {AppSharedService} from '../../service/app.shared.service';


@Component({
    selector: 'app-header',
    templateUrl: 'app.header.component.html'
})
@Injectable()
export class AppHeaderComponent {
    private _headerImage: string;
    public token: boolean;

    constructor(private appLogoutService: AppLogoutService,
                private appSharedService: AppSharedService,
                private router: Router) {
        this._headerImage = "";
        this.author = "Vain Maria";
        this.year = 2018;
        this.token = !!localStorage.getItem('mv_token_odsfkgsmkn4nkwkjk2nn3');
    }

    ngOnInit() {
        this.appSharedService.getEmittedValue()
            .subscribe(item => this.token = !!(localStorage.getItem('mv_token_odsfkgsmkn4nkwkjk2nn3')));
    }

    get headerImage(): string {
        return this._headerImage;
    }

    set headerImage(value: string) {
        this._headerImage = value;
    }

    public logout() {
        this.appLogoutService.logout()
            .subscribe((res: any) => {
                this.token = false;
                this.router.navigate(['/home']);
            }, CommonUtil.handleError)
    }
}
