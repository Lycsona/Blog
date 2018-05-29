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

  public createTag(name: string): Observable<Response> {
    return this.http.post(TAG, {name: name}, CommonUtil.getAuthorizationHeader())
      .map((res: Response) => {
        return res;
      })
      .catch(CommonUtil.handleError);
  }

  public deleteTag(id: string): Observable<Response> {
    return this.http
      .delete(TAG.concat('/').concat(id), CommonUtil.getAuthorizationHeader())
      .map((res: Response) => {
        return res;
      })
      .catch(CommonUtil.handleError);
  }
}
