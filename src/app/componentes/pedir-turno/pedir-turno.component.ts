import { Component, OnInit } from '@angular/core';

import { Turno } from '../../clases/turno';

import { JwtHelperService } from "@auth0/angular-jwt";
import { ConexionService } from "../../servicios/conexion.service";

@Component({
  selector: 'app-pedir-turno',
  templateUrl: './pedir-turno.component.html',
  styleUrls: ['./pedir-turno.component.css']
})
export class PedirTurnoComponent implements OnInit {

  public mes = 1;
  public dia = 1;
  public hora = 0;
  public minutos = 0;
  private autos = [];
  private autosDelUsuario = [];
  private estado = 0;
  private token;

  constructor(private conexion: ConexionService) {

    let JWTHelper = new JwtHelperService();

    try {

      this.token = JWTHelper.decodeToken(localStorage.getItem("token"));

      this.conexion.ObtenerAutos().subscribe(
        exito => {

          console.log((exito as any).rta);
          this.autos = (exito as any).rta;

          for (let item of this.autos) {

            if (item.correo == this.token.correo)
              this.autosDelUsuario.push(item);

          }
        },

        error => alert("Error: " + JSON.stringify(error))
      );
    } catch (error) { }

  }

  ngOnInit() { }

  test() {

    let fecha = "";
    fecha = `${this.dia}/${this.mes} ${this.hora}:${this.minutos}`;

    if (!this.estado) {
      alert("Selecciona el auto al cual le queiras hacer service.");
      return;
    }

    this.conexion.PedirTurno(new Turno(this.token.user, fecha, this.estado)).subscribe(
      exito => alert("Exito: " + JSON.stringify(exito)),
      error => alert("Error: " + JSON.stringify(error))
    );
  }
}
