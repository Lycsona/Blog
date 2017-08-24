import {Component, Inject, OnInit} from "@angular/core";
import {AppArticleService} from "../service/app.article.service";
import {ActivatedRoute} from "@angular/router";
import {ArticleDto} from "../dto/ArticleDto";
import {DOCUMENT} from "@angular/platform-browser";
import {CommonUtil} from "../utils/common.util";

@Component({
    selector: 'article',
    templateUrl: './article.component.html',
})
export class ArticleComponent implements OnInit {

    public article: ArticleDto;
    public originalArticle: ArticleDto;

    constructor(private appArticleService: AppArticleService, private route: ActivatedRoute,
                @Inject(DOCUMENT) private document: any) {
        this.article = new ArticleDto();
        this.originalArticle = new ArticleDto();
    }

    public ngOnInit() {
        this.getArticle();
    }

    private getArticle() {
        new Promise((resolve, reject) => {
            this.route.params.subscribe(params => {
                params['id'] ? resolve(params['id']) : reject('No article found');
            });
        }).then((id) => {
            this.appArticleService.getArticleByUrlId(<string>id)
                .subscribe((res: any) => {
                    let jsonArticle = JSON.parse(res._body);
                    this.originalArticle = jsonArticle;

                    this.article.id = jsonArticle.id;
                    this.article.name = jsonArticle.name;
                    this.article.content = jsonArticle.content;
                    this.article.createdAt = jsonArticle.createdAt;
                    this.article.updatedAt = jsonArticle.updatedAt;
                    this.article.tags = jsonArticle.tags;

                }, CommonUtil.handleError)
        }).catch((error) => console.error(error));
    }
}
