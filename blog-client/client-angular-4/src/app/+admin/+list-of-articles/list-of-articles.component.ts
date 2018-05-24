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

    constructor(private appArticleService: AppArticleService, private meta: Meta) {
        this.meta.addTag({name: 'robots', content: 'noindex'});
        this.articles = [];
    }

    public ngOnInit() {
        this.getArticles();
    }

    private getArticles() {
        // this.appArticleService.getAllArticles()
        //     .subscribe((res: any) => {
        //         let jsonArray = JSON.parse(res._body);
        //         this.articles = [];
        //
        //         jsonArray.map(art => {
        //             let article = new ArticleDto();
        //             article.id = art.id;
        //             article.createAt = art.createAt;
        //             article.updatedAt = art.updatedAt;
        //             article.title = art.title;
        //             article.urlTitle = art.urlTitle;
        //             article.summary = art.summary;
        //             article.content = art.content;
        //             article.footer = art.footer;
        //             article.isSubArticle = art.subArticle;
        //             article.language = art.language;
        //
        //             this.articles.push(article);
        //         });
        //
        //     }, CommonUtil.handleError)
    }

    private deleteArticle(id: string) {
        // this.appArticleService.deleteArticleById(id)
        //     .subscribe((res: any) => {
        //     }, CommonUtil.handleError)
    }

    onDelete(id: string) {
        // this.deleteArticle(id);
    }
}
