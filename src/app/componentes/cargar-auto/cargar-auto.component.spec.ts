import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CargarAutoComponent } from './cargar-auto.component';

describe('CargarAutoComponent', () => {
  let component: CargarAutoComponent;
  let fixture: ComponentFixture<CargarAutoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CargarAutoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CargarAutoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
