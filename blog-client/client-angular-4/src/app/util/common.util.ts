import {Headers, RequestOptions, Response} from "@angular/http";
import {Observable} from "rxjs";
import {Router} from "@angular/router";

export const apiPrefix = 'http://blog.loc';
export const pageTitle = 'Maria Vain';

export class CommonUtil {
    private static router: Router;

    constructor(private router: Router) {
    }

    static redirectTo(route) {
        this.router.navigate([route]);
    }

    public static getApiAddress(): string {
        const hostname = location.hostname;
        const port = ':3000'; //    TODO find a way
        const protocol = location.protocol;
        return protocol + '//' + hostname + port + '/api';
    }

    static extractData(res: Response, defaultValue: any = {}) {
        let body = res.json();
        return body || defaultValue;
    }

    static handleError(error: Response) {
        // in a real world app, we may send the server to some remote logging infrastructure
        // instead of just logging it to the console
        console.error(error);
        if (error.status == 401 || (error.url && error.url.includes('api/login'))) {
            localStorage.removeItem("mv_token_odsfkgsmkn4nkwkjk2nn3");
            localStorage.setItem("mv_admin", false);
        }
        // return Observable.throw(error.json().error || 'Server error');
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
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token,
        });
        return new RequestOptions({headers: headers});
    }

    static getFileHeader() {
        let token = localStorage.getItem('mv_token_odsfkgsmkn4nkwkjk2nn3');
        let headers = new Headers({
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'multipart/form-data'
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
