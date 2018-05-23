import {CommonModule} from "@angular/common";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NgModule} from "@angular/core";
import {RouterModule} from "@angular/router";

import {routes} from "./create-article.routes";
import {CreateArticleComponent} from "./create-article.component";

import {ImageUploadModule} from "angular2-image-upload";
import {CKEditorModule} from "ng2-ckeditor";

@NgModule({
    declarations: [
        // Components / Directives/ Pipes
        CreateArticleComponent,
    ],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        CKEditorModule,
        ImageUploadModule.forRoot(),
        RouterModule.forChild(routes),
    ],
})
export class CreateArticleModule {
    public static routes = routes;
}