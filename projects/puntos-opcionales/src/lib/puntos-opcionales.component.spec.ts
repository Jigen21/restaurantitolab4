import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PuntosOpcionalesComponent } from './puntos-opcionales.component';

describe('PuntosOpcionalesComponent', () => {
  let component: PuntosOpcionalesComponent;
  let fixture: ComponentFixture<PuntosOpcionalesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PuntosOpcionalesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PuntosOpcionalesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
