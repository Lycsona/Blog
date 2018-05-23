import {Injectable} from '@angular/core';
import {Http, Response, RequestOptions} from '@angular/http';
import {Observable} from 'rxjs';
import {apiPrefix, CommonUtil} from '../util/common.util';
import {TagDto} from "../dto/TagDto";

const TAG = apiPrefix.concat('/api/tags');

@Injectable()
export class AppTagService {

    constructor(private http: Http) {
    }

    public getAllTags(): Observable<Response> {
        let headers = CommonUtil.getAuthorizationHeader();
        return this.http
            .get(TAG, headers)
            .map((res: Response) => {
                return res;
            })
            .catch(CommonUtil.handleError);
    }
}