import { Component, OnInit } from '@angular/core';

import { ConexionService } from "../../servicios/conexion.service";
import { JwtHelperService } from "@auth0/angular-jwt";

@Component({
  selector: 'app-todos-los-turnos',
  templateUrl: './todos-los-turnos.component.html',
  styleUrls: ['./todos-los-turnos.component.css']
})
export class TodosLosTurnosComponent implements OnInit {

  public displayedColumns: string[] = ['_id', 'name', 'fecha', 'estado'];
  public turnos = [];
  public dataSource;

  constructor(private conexion: ConexionService) {

    let JWTHelper = new JwtHelperService();
    let token;

    try {
      token = JWTHelper.decodeToken(localStorage.getItem("token"));
    } catch (error) { }

    this.conexion.ObtenerTurnos().subscribe(
      exito => {

        this.turnos = (exito as any).rta;
        console.log(this.turnos)
        this.dataSource = this.turnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );

    this.conexion.ObtenerAutos().subscribe(
      exito => {

        console.log(exito);

      },
      error => alert("Error: " + JSON.stringify(error))
    );

  }

  ngOnInit() {
  }

}
