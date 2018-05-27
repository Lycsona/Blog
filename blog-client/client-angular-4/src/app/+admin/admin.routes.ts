import {AdminComponent} from "./admin.component";

export const routes = [
    {
        path: '', children: [
        {path: '', component: AdminComponent},
        {path: 'create-article', loadChildren: './+create-article#CreateArticleModule'},
        {path: 'update-article/id/:id', loadChildren: './+update-article#UpdateArticleModule'},
        {path: 'update-article/:title', loadChildren: './+update-article#UpdateArticleModule'},
        {path: 'list-of-articles', loadChildren: './+list-of-articles#ListOfArticlesModule'},
    ]
    },
];