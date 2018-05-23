import {Headers, RequestOptions, Response} from "@angular/http";
import {Observable} from "rxjs";
import {Router} from "@angular/router";

export const apiPrefix = 'http://blog.loc';
export const pageTitle = 'Maria Vain';

export class CommonUtil {

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
        if (error.status == 401) {
            console.error('401 handle error');
            localStorage.removeItem("mv_token_odsfkgsmkn4nkwkjk2nn3");
        }
        if (error.url.includes('api/login')) {
            console.error('handle login error');
            Router.navigate(['/login']);
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
        });
        return new RequestOptions({headers: headers});
    }

    static getFileHeader() {
        let headers = new Headers();
        headers.append('Content-Type', 'multipart/form-data');
        headers.append('Accept', 'application/json');

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