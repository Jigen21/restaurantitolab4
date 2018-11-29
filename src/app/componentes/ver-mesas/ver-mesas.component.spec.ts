import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { VerMesasComponent } from './ver-mesas.component';

describe('VerMesasComponent', () => {
  let component: VerMesasComponent;
  let fixture: ComponentFixture<VerMesasComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ VerMesasComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(VerMesasComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
