import {Injectable} from '@angular/core';
import {Http, Response} from '@angular/http';
import {Observable} from 'rxjs';
import {apiPrefix, CommonUtil} from '../util/common.util';
import {ArticleDto} from "../dto/ArticleDto";

const ARTICLE = apiPrefix.concat('/api/articles');

@Injectable()
export class AppArticleService {

    constructor(private http: Http) {
    }

    public getArticles(page: number, size: number): Observable<Response> {
        return this.http
            .get(ARTICLE
                .concat('/page/')
                .concat(String(page))
                .concat('/size/')
                .concat(String(size)), null)
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

    public saveArticle(article: ArticleDto): Observable<Response> {
        let headers = CommonUtil.getAuthorizationHeader();

        return this.http
            .post(`${ARTICLE}`, article.toJSON(), headers)
            .map((res: Response) => {
                return res;
            })
            .catch(CommonUtil.handleError);
    }
}
