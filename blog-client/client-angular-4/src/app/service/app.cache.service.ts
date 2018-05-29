import {Injectable} from '@angular/core';
import {Http, Response} from '@angular/http';
import {Observable} from 'rxjs';
import {apiPrefix, CommonUtil} from '../util/common.util';

const CACHE = apiPrefix.concat('/api/cache');

@Injectable()
export class AppCacheService {

    constructor(private http: Http) {
    }

    public clearAllCaches(): Observable<Response> {
        return this.http.post(`${CACHE}`.concat('/clear'), null, CommonUtil.getAuthorizationHeader())
            .map((res: Response) => {
                return res;
            })
            .catch(CommonUtil.handleError);
    }
}
