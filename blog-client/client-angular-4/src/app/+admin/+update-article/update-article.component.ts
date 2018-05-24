
import {ChangeDetectorRef, Component, OnInit} from "@angular/core";
import {ArticleDto} from "../../dto/ArticleDto";
import {AppArticleService} from "../../service/app.article.service";
import {CommonUtil} from "../../util/common.util";
import {ActivatedRoute, Router} from "@angular/router";
import {TagDto} from "../../dto/TagDto";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
// import {AppTagsService} from "../../service/app.tags.service";
import {Meta} from "@angular/platform-browser";

@Component({
    selector: 'update-article',
    templateUrl: './update-article.component.html',
})
export class UpdateArticleComponent implements OnInit {

    private model: ArticleDto;
    private tags: TagDto[];
    private selectedTags: TagDto[];
    private imgUploadUrl: string;
    private patternNoSpace = /^\S*$/;
    formErrors: any;
    updateArticleForm: FormGroup;

    constructor(private appArticleService: AppArticleService, private route: ActivatedRoute,
                private _changeDetectionRef: ChangeDetectorRef, private fb: FormBuilder,
                private router: Router, private meta: Meta) {
        this.meta.addTag({name: 'robots', content: 'noindex'});
        this.model = new ArticleDto();
        this.tags = [];
        this.selectedTags = [];
        this.imgUploadUrl = "";
    }

    readonly validationMessages = {
        'title': {
            'required': 'Required',
            'minlength': 'Min 2 chars',
            'maxlength': 'Max 64 chars',
        },
        'urlTitle': {
            'required': 'Required',
            'minlength': 'Min 2 chars',
            'maxlength': 'Max 128 chars',
            'pattern': 'Spaces are not allowed',
        },
        'summary': {
            'required': 'Required',
            'minlength': 'Min 2 chars',
            'maxlength': 'Max 1024 chars',
        },
        'content': {
            'required': 'Required',
        },
        'footer': {
            'required': 'Required',
            'minlength': 'Min 2 chars',
            'maxlength': 'Max 1024 chars',
        }
    };

    public ngOnInit() {
        this.getAllTags();
        this.getArticle();
        this.buildForm();
    }

    private getArticle() {
        return new Promise((resolve, reject) => {
            this.route.params.subscribe(params => {
                console.log(params['title']);
                params['title'] ? resolve(params['title']) : reject("No article found");
            });
        }).then(title => {
            this.appArticleService.getArticleByUrlTitle(<string>title)
                .subscribe((res: any) => {
                    let jsonArray = JSON.parse(res._body);
                    this.model.id = jsonArray.id;
                    this.model.createAt = jsonArray.createAt;
                    this.model.updatedAt = jsonArray.updatedAt;
                    this.model.title = jsonArray.title;
                    this.model.urlTitle = jsonArray.urlTitle;
                    this.model.summary = jsonArray.summary;
                    this.model.content = jsonArray.content;
                    this.model.footer = jsonArray.footer;
                    this.model.tags = jsonArray.tags;

                    this.model.language = jsonArray.language;
                    this.model.translation = jsonArray.translation;

                    this._changeDetectionRef.detectChanges();
                    this.imgUploadUrl = CommonUtil.getApiAddress().concat(`/api/article/upload-header-image/${this.model.id}`);
                }, CommonUtil.handleError)
        }).catch(error => console.error(error));
    }

    private buildForm(): void {
        this.formErrors = {
            'title': '',
            'summary': '',
            'content': '',
            'footer': '',
            'urlTitle': '',
        };

        this.updateArticleForm = this.fb.group({
            'title': [this.model.title,
                [
                    Validators.required,
                    Validators.minLength(2),
                    Validators.maxLength(64)
                ]
            ],
            'urlTitle': [this.model.urlTitle,
                [
                    Validators.required,
                    Validators.minLength(2),
                    Validators.maxLength(128)
                ]
            ],
            'summary': [this.model.summary,
                [
                    Validators.required,
                    Validators.minLength(2),
                    Validators.maxLength(1024)
                ]
            ],
            'content': [this.model.content,
                [
                    Validators.required,
                ]
            ],
            'footer': [this.model.footer,
                [
                    Validators.required,
                    Validators.minLength(2),
                    Validators.maxLength(1024)
                ]
            ],
        });

        this.updateArticleForm.valueChanges
            .subscribe(data => this.onValueChanged(data));

        this.onValueChanged();
    }

    private onValueChanged(data?: any) {
        if (!this.updateArticleForm) {
            return;
        }
        const form = this.updateArticleForm;

        for (const field in this.formErrors) {
            // clear previous error message (if any)
            this.formErrors[field] = '';
            const control = form.get(field);
            if (control && (control.dirty) && !control.valid) {
                const messages = this.validationMessages[field];
                for (const key in control.errors) {
                    if (!(<string>this.formErrors[field]).includes(messages[key])) {
                        this.formErrors[field] += messages[key] + ' ';
                    }
                }
            }
        }
    }

    // private getAllTags() {
    //     this.appTagsService.getAllTags()
    //         .subscribe((res: any) => {
    //             let jsonArray = JSON.parse(res._body);
    //             this.tags = [];
    //             jsonArray.map(tag => {
    //                 let t = new TagDto();
    //                 t.id = tag.id;
    //                 t.createAt = tag.createAt;
    //                 t.updatedAt = tag.updatedAt;
    //                 t.tagTitle = tag.tagTitle;
    //                 this.tags.push(t);
    //             });
    //
    //         }, CommonUtil.handleError)
    // }

    public onSubmit() {
        this.model.tags = this.selectedTags;
        this.appArticleService.updateArticle(this.model)
            .subscribe((res: any) => {
                this.router.navigate(['/']);
            }, CommonUtil.handleError)
    }

    public disableSendButton(e) {

    }
}