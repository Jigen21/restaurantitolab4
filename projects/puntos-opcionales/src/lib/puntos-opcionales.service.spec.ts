import { TestBed } from '@angular/core/testing';

import { PuntosOpcionalesService } from './puntos-opcionales.service';

describe('PuntosOpcionalesService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: PuntosOpcionalesService = TestBed.get(PuntosOpcionalesService);
    expect(service).toBeTruthy();
  });
});
