import {CommonModule} from "@angular/common";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NgModule} from "@angular/core";
import {RouterModule} from "@angular/router";

import {routes} from "./admin.routes";
import {AdminComponent} from "./admin.component";


@NgModule({
    declarations: [
        // Components / Directives/ Pipes
        AdminComponent,
    ],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        RouterModule.forChild(routes),
    ],
})
export class AdminModule {
    public static routes = routes;
}