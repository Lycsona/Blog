import {Component, OnInit} from '@angular/core';

import {AppState} from '../app.service';
import {Title} from '@angular/platform-browser';
import {ArticleDto} from '../dto/ArticleDto';
import {AppArticleService} from '../service/app.article.service';
import {CommonUtil} from '../util/common.util';
import {AppPagerService} from "../service/app.pager.service";

@Component({
    selector: 'home',
    providers: [Title],
    styleUrls: ['./home.component.css'],
    templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {

    public articles: ArticleDto[];

    // pager object
    pager: any = {};

    // paged items
    pagedArticles: any[];

    constructor(public appArticleService: AppArticleService, public AppPagerService: AppPagerService,
                public appState: AppState, public title: Title) {
        this.articles = [];
    }

    public ngOnInit() {
        this.getAllArticles();
    }

    private getAllArticles() {
        this.appArticleService.getArticles()
            .subscribe((res: any) => {
                let jsonArray = JSON.parse(res._body);

                jsonArray.map((art) => {
                    let article = new ArticleDto();
                    article.id = art.id;
                    article.name = art.name;
                    article.content = art.content;
                    article.createdAt = art.createdAt;
                    article.updatedAt = art.updatedAt;
                    article.tags = art.tags;

                    this.articles.push(article);
                    this.setPage(1);
                });
            }, CommonUtil.handleError);
    }

    setPage(page: number) {
        if (page < 1 || page > this.pager.totalPages) {
            return;
        }

        // get pager object from service
        this.pager = this.AppPagerService.getPager(this.articles.length, page);

        // get current page of items
        this.pagedArticles = this.articles.slice(this.pager.startIndex, this.pager.endIndex + 1);
    }

}
