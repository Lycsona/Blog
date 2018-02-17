import {Component, OnInit} from '@angular/core';

import {AppState} from '../app.service';
import {Title} from '@angular/platform-browser';
import {ArticleDto} from '../dto/ArticleDto';
import {AppArticleService} from '../service/app.article.service';
import {CommonUtil} from '../util/common.util';

@Component({
    selector: 'home',
    providers: [Title],
    styleUrls: ['./home.component.css'],
    templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {

    public articles: ArticleDto[];

    pageNo: number = 0;
    pageSize: number = 5;
    pageTotal: number[];
    isFirst: boolean;
    isLast: boolean;

    constructor(public appArticleService: AppArticleService, public appState: AppState, public title: Title) {
        this.pageTotal = [];
        this.articles = [];
    }

    public ngOnInit() {
        this.getAllArticles();
    }

    private getAllArticles() {
        this.appArticleService.getArticles(this.pageNo, this.pageSize)
            .subscribe((res: any) => {
                let jsonArray = JSON.parse(res._body);
                this.pageTotal = new Array(jsonArray.totalPages);
                this.isFirst = jsonArray.firstPage;
                this.isLast = jsonArray.lastPage;
                this.articles = [];

                jsonArray.articles.map((art) => {
                    let article = new ArticleDto();
                    article.id = art.id;
                    article.name = art.name;
                    article.content = art.content;
                    article.createdAt = art.createdAt;
                    article.updatedAt = art.updatedAt;
                    article.tags = art.tags;
                    article.image = art.image;

                    this.articles.push(article);
                });
            }, CommonUtil.handleError);
    }

    public changePage(page) {
        this.pageNo = page;
        this.getAllArticles();
    }

    public nextPage() {
        if (this.pageNo + 1 !== this.pageTotal.length) {
            this.pageNo += 1;
            this.getAllArticles();
        }
    }

    public prevPage() {
        if (this.pageNo !== 0) {
            this.pageNo -= 1;
            this.getAllArticles();
        }
    }

}
