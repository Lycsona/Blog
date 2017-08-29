import {ChangeDetectionStrategy, ChangeDetectorRef, Component, OnInit} from "@angular/core";
import {Title} from "@angular/platform-browser";
import {AppArticleService} from "../service/app.article.service";
import {ArticleDto} from "../dto/ArticleDto";
import {CommonUtil, pageTitle} from "../util/common.util";
import {ActivatedRoute} from "@angular/router";

@Component({
    selector: 'list-of-articles',
    providers: [Title],
    templateUrl: './list-of-articles.component.html',
    changeDetection: ChangeDetectionStrategy.OnPush
})
export class ListOfArticles implements OnInit {

    articles: any[];
    tagUrl: string;

    constructor(public appArticleService: AppArticleService, public title: Title, private route: ActivatedRoute,
                private _changeDetectionRef: ChangeDetectorRef) {
        this.articles = [];
        this.title.setTitle(pageTitle);
        this.tagUrl = '';
    }

    public ngOnInit() {
        this.getArticlesByTag();
    }

    private getArticlesByTag() {
        new Promise((resolve, reject) => {
            this.getUrlParam(resolve, reject);
        }).then((id) => {
            this.appArticleService.getArticlesByTag(<string>id)
                .subscribe((res: any) => {
                    let jsonArray = JSON.parse(res._body);
                    this.articles = [];
                    jsonArray.map(art => {
                        let article = new ArticleDto();
                        article.id = art.id;
                        article.name = art.name;
                        article.content = art.content;
                        article.createdAt = art.createdAt;
                        article.updatedAt = art.updatedAt;
                        article.tags = art.tags;
                        this.articles.push({
                            art: article
                        });
                    });

                    this._changeDetectionRef.detectChanges();
                }, CommonUtil.handleError)
        })
    }

    private getUrlParam(resolve, reject) {
        this.route.params.subscribe(params => {
            this.tagUrl = params['tag-id'];
            params['tag-id'] ? resolve(params['tag-id']) : reject('No tag found');
        });
    }

    refresh() {
        this.getArticlesByTag(); //FIXME refreshing data performed only after second mouse click
    }
}
