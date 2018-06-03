import {BrowserModule} from '@angular/platform-browser';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule} from '@angular/http';
import {
    ApplicationRef,
    NgModule
} from '@angular/core';

import {
    removeNgStyles,
    createNewHosts,
    createInputTransfer
} from '@angularclass/hmr';
import {
    RouterModule,
    PreloadAllModules
} from '@angular/router';

/*
 * Platform and Environment providers/directives/pipes
 */
import {ENV_PROVIDERS} from './environment';
import {ROUTES} from './app.routes';

import '../styles/styles.scss';
import '../styles/headings.css';

import {AppComponent} from './app.component';
import {APP_RESOLVER_PROVIDERS} from './app.resolver';
import {AppState, InternalStateType} from './app.service';
import {HomeComponent} from './home';
import {AboutComponent} from './about';
import {NoContentComponent} from './no-content';
import {AppArticleService} from './service/app.article.service';
import {AppPageViewService} from './service/app.page.view.service';
import {ArticleComponent} from "./article/article.component";
import {ListOfArticles} from "./list-of-article/list-of-articles.component";
import {AppFooterComponent} from "./common/footer/app.footer.component";
import {AppHeaderComponent} from "./common/header/app.header.component";
import {StompConfig, StompService} from '@stomp/ng2-stompjs';
import {AuthGuard} from './util/auth-guard';
import {LoginComponent} from "./login/login.component";
import {AppLoginService} from "./service/app.login.service";
import {AppLogoutService} from "./service/app.logout.service";
import {AppSharedService} from "./service/app.shared.service";
import {AppTagService} from "./service/app.tag.service";
import {Md5} from "ts-md5/dist/md5";
import {AppChangeHeaderImgService} from "./service/app.change.header.img.service";
import {AppCacheService} from "./service/app.cache.service";
import {TooltipModule} from 'ngx-bootstrap';

// Application wide providers
const APP_PROVIDERS = [
    ...APP_RESOLVER_PROVIDERS,
    AppState
];

const stompConfig: StompConfig = {
    // Which server?
    url: 'ws://127.0.0.1:15674/stomp/websocket',

    // Headers
    // Typical keys: login, passcode, host
    headers: {
        login: 'guest',
        passcode: 'guest'
    },

    // How often to heartbeat?
    // Interval in milliseconds, set to 0 to disable
    heartbeat_in: 0, // Typical value 0 - disabled
    heartbeat_out: 20000, // Typical value 20000 - every 20 seconds

    // Wait in milliseconds before attempting auto reconnect
    // Set to 0 to disable
    // Typical value 5000 (5 seconds)
    reconnect_delay: 5000,

    // Will log diagnostics on console
    debug: true
};

type StoreType = {
    state: InternalStateType,
    restoreInputValues: () => void,
    disposeOldHosts: () => void
};

/**
 * `AppModule` is the main entry point into Angular2's bootstraping process
 */
@NgModule({
    bootstrap: [AppComponent],
    declarations: [
        AppHeaderComponent,
        AppFooterComponent,
        AppComponent,
        ArticleComponent,
        ListOfArticles,
        AboutComponent,
        HomeComponent,
        NoContentComponent,
        LoginComponent
    ],
    /**
     * Import Angular's modules.
     */
    imports: [
        BrowserModule,
        FormsModule,
        ReactiveFormsModule,
        HttpModule,
        RouterModule.forRoot(ROUTES, {useHash: true, preloadingStrategy: PreloadAllModules}),
        TooltipModule.forRoot()
    ],
    /**
     * Expose our Services and Providers into Angular's dependency injection.
     */
    providers: [
        ENV_PROVIDERS,
        APP_PROVIDERS,
        AppArticleService,
        AppPageViewService,
        AppCacheService,
        Md5,
        AuthGuard,
        AppLoginService,
        AppLogoutService,
        AppSharedService,
        AppTagService,
        StompService,
        {
            provide: StompConfig,
            useValue: stompConfig
        }
    ]
})
export class AppModule {

    constructor(public appRef: ApplicationRef,
                public appState: AppState) {
    }

    public hmrOnInit(store: StoreType) {
        if (!store || !store.state) {
            return;
        }
        /**
         * Set state
         */
        this.appState._state = store.state;
        /**
         * Set input values
         */
        if ('restoreInputValues' in store) {
            let restoreInputValues = store.restoreInputValues;
            setTimeout(restoreInputValues);
        }

        this.appRef.tick();
        delete store.state;
        delete store.restoreInputValues;
    }

    public hmrOnDestroy(store: StoreType) {
        const cmpLocation = this.appRef.components.map((cmp) => cmp.location.nativeElement);
        /**
         * Save state
         */
        const state = this.appState._state;
        store.state = state;
        /**
         * Recreate root elements
         */
        store.disposeOldHosts = createNewHosts(cmpLocation);
        /**
         * Save input values
         */
        store.restoreInputValues = createInputTransfer();
        /**
         * Remove styles
         */
        removeNgStyles();
    }

    public hmrAfterDestroy(store: StoreType) {
        /**
         * Display new elements
         */
        store.disposeOldHosts();
        delete store.disposeOldHosts;
    }

}
