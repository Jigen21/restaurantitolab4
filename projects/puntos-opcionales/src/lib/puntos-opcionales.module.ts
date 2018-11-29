import { NgModule } from '@angular/core';
import { PuntosOpcionalesComponent } from './puntos-opcionales.component';
import { CaptchaComponent } from './captcha/captcha.component';
import { RecaptchaModule } from 'ng-recaptcha';
import { MapaComponent } from './mapa/mapa.component';

@NgModule({
  imports: [
    RecaptchaModule
  ],
  declarations: [
    PuntosOpcionalesComponent,
    CaptchaComponent,
    MapaComponent
  ],
  exports: [
    PuntosOpcionalesComponent,
    RecaptchaModule
  ]
})
export class PuntosOpcionalesModule { }
