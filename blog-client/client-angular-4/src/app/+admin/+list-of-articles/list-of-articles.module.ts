import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';

import {routes} from './list-of-articles.routes';

import {ListOfArticlesComponent} from "./list-of-articles.component";

@NgModule({
    declarations: [
        // Components / Directives/ Pipes
        ListOfArticlesComponent,
    ],
    imports: [
        CommonModule,
        FormsModule,
        RouterModule.forChild(routes),
    ],
})
export class ListOfArticlesModule {
    public static routes = routes;
}