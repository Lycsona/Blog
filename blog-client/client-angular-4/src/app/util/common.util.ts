import {Headers, RequestOptions, Response} from "@angular/http";
import {Observable} from "rxjs";

export const apiPrefix = 'http://blog.loc';
export const pageTitle = 'Maria Vain';

export class CommonUtil {

    static extractData(res: Response, defaultValue: any = {}) {
        let body = res.json();
        return body || defaultValue;
    }

    static handleError(error: Response) {
        // in a real world app, we may send the server to some remote logging infrastructure
        // instead of just logging it to the console
        console.error(error);
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
}