import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InputerinoComponent } from './inputerino.component';

describe('InputerinoComponent', () => {
  let component: InputerinoComponent;
  let fixture: ComponentFixture<InputerinoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InputerinoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InputerinoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
