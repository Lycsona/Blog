import {CanActivate, Router} from "@angular/router";
import {Injectable} from "@angular/core";

@Injectable()
export class AuthGuard implements CanActivate {

    public isAuthenticated: boolean;

    constructor(private router: Router) {
        this.isAuthenticated = false;
    }


    canActivate() {
        if (localStorage.getItem('mv_admin')) {
            return true;
        }

        this.router.navigate(['/login']);
        return false;
    }
}