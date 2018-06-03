import {Injectable} from '@angular/core';
import {Http, Response} from '@angular/http';
import {Observable} from 'rxjs';
import {apiPrefix, CommonUtil} from '../util/common.util';
import {Router} from "@angular/router";


const LOGIN = apiPrefix().concat('/api/login_check');

@Injectable()
export class AppLoginService {

    constructor(private http: Http, private router: Router) {
    }

    public login(login: string, password: string): Observable<boolean> {
        const body = new URLSearchParams();
        body.set('_username', login);
        body.set('_password', password);

        return this.http
            .post(LOGIN, body.toString(), CommonUtil.getContentTypeUrlEncoded())
            .map((res: Response) => {
                return res;
            })
            .catch((error) => {
                localStorage.removeItem("mv_token_odsfkgsmkn4nkwkjk2nn3");

                if (error.status == 401) {
                    this.router.navigate(['/login']);
                }
                return Observable.throw(error)
            })
    }

}