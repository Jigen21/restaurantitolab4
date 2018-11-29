import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-inputerino',
  templateUrl: './inputerino.component.html',
  styleUrls: ['./inputerino.component.css']
})
export class InputerinoComponent implements OnInit {
@Input()public indicator;
  constructor() { }

  ngOnInit() {
  }

}
