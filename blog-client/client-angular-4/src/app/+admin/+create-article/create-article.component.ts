import {Component, OnInit, ElementRef, ViewChild} from "@angular/core";
import {ArticleDto} from "../../dto/ArticleDto";
import {AppArticleService} from "../../service/app.article.service";
import {CommonUtil} from "../../util/common.util";
import {TagDto} from "../../dto/TagDto";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {Meta} from "@angular/platform-browser";
import {AppTagService} from "../../service/app.tag.service";

@Component({
    selector: 'create-article',
    templateUrl: './create-article.component.html',
})
export class CreateArticleComponent implements OnInit {

    @ViewChild('fileInput') fileInput: ElementRef;

    private model: ArticleDto;
    private tags: TagDto[];
    private selectedTags: TagDto[];
    private patternNoSpace = /^\S*$/;

    formErrors: any;
    createArticleForm: FormGroup;

    readonly validationMessages = {
        'name': {
            'required': 'Required',
            'minlength': 'Min 2 chars',
            'maxlength': 'Max 128 chars',
        },
        'content': {
            'required': 'Required',
        }
    };

    constructor(private appArticleService: AppArticleService,
                private appTagsService: AppTagService,
                private fb: FormBuilder,
                private router: Router,
                private meta: Meta) {
        this.meta.addTag({name: 'robots', content: 'noindex'});
        this.model = new ArticleDto();
        this.tags = [];
        this.selectedTags = [];
    }

    public ngOnInit() {
        this.getAllTags();
        this.buildForm();
    }

    private buildForm(): void {
        this.formErrors = {
            'name': '',
            'content': '',
        };

        this.createArticleForm = this.fb.group({
            'name': [this.model.name,
                [
                    Validators.required,
                    Validators.minLength(2),
                    Validators.maxLength(128)
                ]
            ],
            'content': [this.model.content, [Validators.required,]],
            'image': null,
        });

        this.createArticleForm.valueChanges
            .subscribe(data => this.onValueChanged(data));

        this.onValueChanged();
    }

    public onFileChange(event) {
        let reader = new FileReader();
        if(event.target.files && event.target.files.length > 0) {
            let file = event.target.files[0];
            reader.readAsDataURL(file);
            reader.onload = () => {
                this.createArticleForm.get('image').setValue({
                    filename: file.name,
                    filetype: file.type,
                    value: reader.result.split(',')[1]
                })
            };
        }
    }

    private onValueChanged(data?: any) {
        if (!this.createArticleForm) {
            return;
        }
        const form = this.createArticleForm;

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

    public onSubmit() {
        this.model.tags = this.selectedTags;

        this.appArticleService.saveArticle(this.model)
            .subscribe((res: any) => {
             //   this.router.navigate(['/']);
            }, CommonUtil.handleError)
    }

    private getAllTags() {
        this.appTagsService.getAllTags()
            .subscribe((res: any) => {
                let jsonArray = JSON.parse(res._body);
                this.tags = [];
                jsonArray.map(tag => {
                    let t = new TagDto();
                    t.id = tag.id;
                    t.name = tag.name;
                    this.tags.push(t);
                });

            }, CommonUtil.handleError)
    }

    clearFile() {
        this.createArticleForm.get('image').setValue(null);
        this.fileInput.nativeElement.value = '';
    }

    onChange(e) {

    }

    onReady(e) {

    }

    onFocus(e) {

    }

    onBlur(e) {

    }
}
