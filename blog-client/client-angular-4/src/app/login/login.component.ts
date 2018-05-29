import {Component, OnInit} from "@angular/core";
import {AppLoginService} from "../service/app.login.service";
import {CommonUtil} from "../util/common.util";
import {Router} from "@angular/router";
import * as jwtDecode from 'jwt-decode';
import {AppSharedService} from '../service/app.shared.service';
import {Theme} from "typedoc/dist/lib/output/theme";

@Component({
    selector: 'login',
    templateUrl: './login.component.html',

})
export class LoginComponent implements OnInit {

    private login: string;
    private password: string;

    constructor(private appLoginService: AppLoginService,
                private appSharedService: AppSharedService,
                private router: Router) {
    }

    public ngOnInit() {
    }

    public onChange(e, type) {

    }

    public changeLoginButton() {
        this.appSharedService.change();
    }

    public onSubmit() {
        this.appLoginService.login(this.login, this.password)
            .subscribe((res: any) => {
                let jsonLogin = JSON.parse(res._body);

                let token = jsonLogin.token;
                let decodedToken = jwtDecode(token);

                if (decodedToken.roles.includes('ROLE_ADMIN')) {
                    localStorage.setItem("mv_token_odsfkgsmkn4nkwkjk2nn3", token);
                    localStorage.setItem("mv_admin", 'yes');
                    this.changeLoginButton();
                    this.router.navigate(['/admin']);
                }else{
                    localStorage.removeItem("mv_admin");
                    this.router.navigate(['/home']);
                }
            }, CommonUtil.handleError)
    }
}
