import {Component, OnInit} from "@angular/core";
import {AppArticleService} from "../../service/app.article.service";
import {ArticleDto} from "../../dto/ArticleDto";
import {CommonUtil} from "../../util/common.util";
import {Meta} from "@angular/platform-browser";

@Component({
    selector: 'list-of-articles',
    templateUrl: './list-of-articles.component.html',
})
export class ListOfArticlesComponent implements OnInit {

    private articles: ArticleDto[];
    pageNo: number = 0;
    pageSize: number = 5;
    pageTotal: number[];
    isFirst: boolean;
    isLast: boolean;

    constructor(private appArticleService: AppArticleService, private meta: Meta) {
        this.meta.addTag({name: 'robots', content: 'noindex'});
        this.articles = [];
        this.pageTotal = [];
    }

    public ngOnInit() {
        this.getArticles();
    }

    private getArticles() {
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

    private deleteArticle(id) {
        this.appArticleService.deleteArticleById(id)
            .subscribe((res: any) => {
            }, CommonUtil.handleError)
    }

    onDelete(id: string) {
        this.deleteArticle(id);
    }
}
