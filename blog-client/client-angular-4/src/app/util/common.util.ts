import {Headers, RequestOptions, Response} from "@angular/http";
import {Observable} from "rxjs";
import {location} from "ngx-bootstrap/utils/facade/browser";

export const pageTitle = 'Maria Vain';

export const apiPrefix = () => process.env.NODE_ENV === 'production'
    ? 'http://52.14.210.117:8080'
    : 'http://blog.loc';

export class CommonUtil {

    static handleError(error: Response) {
        if (error.status == 401 || (error.url && error.url.includes('api/login'))) {
            localStorage.removeItem("mv_token_odsfkgsmkn4nkwkjk2nn3");
            localStorage.removeItem("mv_admin");
            location.reload();
        }
        return Observable.throw(error || 'Server error');
    }

    static getContentTypeUrlEncoded(): RequestOptions {
        let headers = new Headers({
            'Content-Type': 'application/x-www-form-urlencoded',
        });
        return new RequestOptions({headers: headers});
    }

    static getContentTypeJson(): RequestOptions {
        let headers = new Headers({
            'Content-Type': 'application/json'
        });
        return new RequestOptions({headers: headers});
    }

    static getAuthorizationHeader() {
        let token = localStorage.getItem('mv_token_odsfkgsmkn4nkwkjk2nn3');
        let headers = new Headers({
            'Authorization': 'Bearer ' + token,
        });
        return new RequestOptions({headers: headers});
    }
}