import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ImportPageStatus } from './import-page-status';

describe('ImportPageStatus', () => {
  let component: ImportPageStatus;
  let fixture: ComponentFixture<ImportPageStatus>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ImportPageStatus],
    }).compileComponents();

    fixture = TestBed.createComponent(ImportPageStatus);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
