import {Injectable} from '@angular/core';
import {Http, Response} from '@angular/http';
import {Observable} from 'rxjs';
import {apiPrefix, CommonUtil} from '../util/common.util';

const PAGE_VIEW = apiPrefix().concat('/api/page-views');

@Injectable()
export class AppPageViewService {

    constructor(private http: Http) {
    }

    public incrementPageView(id: string): Observable<Response> {
        return this.http
            .post(PAGE_VIEW.concat('/').concat(id), null, CommonUtil.getContentTypeJson())
            .map((res: Response) => {
                return res;
            })
            .catch(CommonUtil.handleError);
    }
}