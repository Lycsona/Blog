import {Component, Inject, OnInit} from "@angular/core";
import {AppArticleService} from "../service/app.article.service";
import {ActivatedRoute} from "@angular/router";
import {ArticleDto} from "../dto/ArticleDto";
import {DOCUMENT} from "@angular/platform-browser";
import {CommonUtil} from "../util/common.util";
import {Message} from '@stomp/stompjs';
import {StompService} from '@stomp/ng2-stompjs';

@Component({
    selector: 'article',
    templateUrl: './article.component.html',
})
export class ArticleComponent implements OnInit {

    public article: ArticleDto;
    public originalArticle: ArticleDto;
    stomp_subscription: any;

    constructor(private appArticleService: AppArticleService, private route: ActivatedRoute,
                @Inject(DOCUMENT) private document: any, private _stompService: StompService) {
        this.article = new ArticleDto();
        this.originalArticle = new ArticleDto();
    }

    public ngOnInit() {
        this.getArticle();

        // this.stomp_subscription.map((message: Message) => {
        //
        //     return message.body;
        // }).publish((msg_body: string) => {
        //     console.log(`Received: ${msg_body}`);
        // });
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
                    this.article.image = jsonArticle.image;

                    this.stomp_subscription = this._stompService.publish('/queue/page-views',
                        <string> jsonArticle.id);

                }, CommonUtil.handleError)
        }).catch((error) => console.error(error));
    }
}
