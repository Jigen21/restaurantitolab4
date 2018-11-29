import { Component, OnInit } from '@angular/core';

import { ConexionService } from "../../servicios/conexion.service";
import { JwtHelperService } from "@auth0/angular-jwt";

@Component({
  selector: 'app-mostrar-turnos',
  templateUrl: './mostrar-turnos.component.html',
  styleUrls: ['./mostrar-turnos.component.css']
})
export class MostrarTurnosComponent implements OnInit {

  public displayedColumns: string[] = ['_id', 'fecha'];
  public turnos = [];
  public misTurnos;
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
        this.misTurnos = this.turnos.filter((value)=> {
          //return value.correo == token.correo; 
          return value.correo == token.user;
        });

        this.dataSource = this.misTurnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );
   }

  ngOnInit() { }
}
