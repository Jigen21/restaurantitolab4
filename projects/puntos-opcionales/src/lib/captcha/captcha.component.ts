import { Component, OnInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'lib-captcha',
  templateUrl: './captcha.component.html',
  styleUrls: ['./captcha.component.css']
})
export class CaptchaComponent implements OnInit {

  @Output() public valido = new EventEmitter();
  public validoAux: boolean;

  constructor() {
    this.validoAux = false;
  }

  ngOnInit() {
  }

  resolved(evento) {
    this.validoAux = !this.validoAux;
    this.valido.emit({valido: this.validoAux});
  }

}
