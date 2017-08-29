import {Injectable} from '@angular/core';
import {Http, Response} from '@angular/http';
import {Observable} from 'rxjs';
import {apiPrefix, CommonUtil} from '../utils/common.util';

const ARTICLE = apiPrefix.concat('/api/articles');

@Injectable()
export class AppArticleService {

    constructor(private http: Http) {
    }

    public getArticles(): Observable<Response> {
        return this.http
            .get(ARTICLE, CommonUtil.getContentTypeJson())
            .map((res: Response) => {
                return res;
            })
            .catch(CommonUtil.handleError);
    }

    public getArticleByUrlId(id: string): Observable<Response> {
        return this.http
            .get(ARTICLE.concat('/').concat(id), null)
            .map((res: Response) => {
                return res;
            })
            .catch(CommonUtil.handleError);
    }

    public getArticlesByTag(id: string): Observable<Response> {
        return this.http
            .get(`${ARTICLE}/tag/${id}`, null)
            .map((res: Response) => {
                return res;
            })
            .catch(CommonUtil.handleError);
    }
}
