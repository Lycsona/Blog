import {Injectable} from '@angular/core';
import {Http, Response} from '@angular/http';
import {Observable} from 'rxjs';
import {CommonUtil} from '../util/common.util';

const CACHE = CommonUtil.getApiAddress().concat('/cache');

@Injectable()
export class AppCacheService {

    constructor(private http: Http) {
    }

    public clearAllCaches(): Observable<Response> {
        return this.http.post(`${CACHE}/clear`, null, CommonUtil.getContentTypeJson())
            .map((res: Response) => {
                return res;
            })
            .catch(CommonUtil.handleError);
    }
}