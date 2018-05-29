import {CommonModule} from "@angular/common";
import {FormsModule} from "@angular/forms";
import {NgModule} from "@angular/core";
import {RouterModule} from "@angular/router";

import {routes} from "./manage-tags.routes";
import {ManageTagsComponent} from "./manage-tags.component";

@NgModule({
  declarations: [
    // Components / Directives/ Pipes
    ManageTagsComponent,
  ],
  imports: [
    CommonModule,
    FormsModule,
    RouterModule.forChild(routes),
  ],
})
export class ManageTagsModule {
  public static routes = routes;
}
