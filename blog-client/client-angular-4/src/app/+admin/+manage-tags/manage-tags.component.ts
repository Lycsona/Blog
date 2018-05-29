import {Component, OnInit} from '@angular/core';
import {AppTagService} from '../../service/app.tag.service';
import {TagDto} from '../../dto/TagDto';
import {CommonUtil} from '../../util/common.util';
import {Meta} from "@angular/platform-browser";

@Component({
  selector: 'manage-tags',
  templateUrl: './manage-tags.component.html',
})
export class ManageTagsComponent implements OnInit {
  private tags: TagDto[];
  private name: string;
  private cssSelector: string;

  constructor(public appTagsService: AppTagService, private meta: Meta) {
    this.meta.addTag({name: 'robots', content: 'noindex'});
    this.tags = [];
    this.name = '';
  }

  public ngOnInit() {
    this.getAllTags();
  }

  public onCreate() {
    this.appTagsService.createTag(this.name)
      .subscribe((res: any) => {
        this.getAllTags();
      }, CommonUtil.handleError)
  }

  public onDelete(id: string) {
    this.appTagsService.deleteTag(id)
      .subscribe((res: any) => {
        this.getAllTags();
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
          t.createdAt = tag.createdAt;
          t.updatedAt = tag.updatedAt;
          t.name = tag.name;
          this.tags.push(t);
        });

      }, CommonUtil.handleError)
  }

}
