import {Routes} from "@angular/router";
import {HomeComponent} from "./home";
import {AboutComponent} from "./about";
import {NoContentComponent} from "./no-content";
import {ArticleComponent} from "./article/article.component";
import {ListOfArticles} from "./list-of-article/list-of-articles.component";
import {AuthGuard} from "./util/auth-guard";
import {LoginComponent} from "./login/login.component";
import {AdminComponent} from "./+admin/admin.component";

export const ROUTES: Routes = [
    {path: '', component: HomeComponent},
    {path: 'home', component: HomeComponent},
    {path: 'about', component: AboutComponent},
    {path: 'article/:id', component: ArticleComponent},
    {path: 'list-of-articles/tag/:tag-id', component: ListOfArticles},
    {path: 'login', component: LoginComponent},
    {path: 'admin', loadChildren: './+admin#AdminModule', canActivate: [AuthGuard]},
    {path: '**', component: NoContentComponent},
];
