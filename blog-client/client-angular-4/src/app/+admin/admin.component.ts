import {Component, OnInit} from "@angular/core";
import {Title} from "./title";
import {Meta} from "@angular/platform-browser";
// import {AppCacheService} from "../service/app.cache.service";

@Component({
    selector: 'admin',
    templateUrl: './admin.component.html',
})
export class AdminComponent implements OnInit {

    constructor(private meta: Meta,
                // private appCacheService: AppCacheService
    ) {
        this.meta.addTag({name: 'robots', content: 'noindex'});
    }

    public ngOnInit() {
        if (!localStorage.getItem("mv_token_odsfkgsmkn4nkwkjk2nn3")) {
            this.router.navigate(['/login']);
        }
    }

    public clearAllCaches() {
        //  this.appCacheService.clearAllCaches().subscribe();
    }
}