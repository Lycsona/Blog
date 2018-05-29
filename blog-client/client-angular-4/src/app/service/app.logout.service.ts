import {Injectable} from '@angular/core';
import {Http, Response} from '@angular/http';
import {Observable} from 'rxjs';
import {apiPrefix, CommonUtil} from '../util/common.util';
import {Router} from "@angular/router";


const LOGOUT = apiPrefix.concat('/api/logout');

@Injectable()
export class AppLogoutService {

    constructor(private http: Http, private router: Router) {
    }

    public logout(): Observable<boolean> {

        return this.http
            .post(LOGOUT, '', CommonUtil.getContentTypeUrlEncoded())
            .map((res: Response) => {
                localStorage.removeItem("mv_token_odsfkgsmkn4nkwkjk2nn3");
                localStorage.setItem("mv_admin", 'yes');
                return res;
            })
            .catch(CommonUtil.handleError);
    }

}
