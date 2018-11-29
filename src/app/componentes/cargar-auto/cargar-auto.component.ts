import { Component, OnInit } from '@angular/core';

import { Auto } from "../../clases/auto";

import { ConexionService } from "../../servicios/conexion.service";
import { JwtHelperService } from "@auth0/angular-jwt";

@Component({
  selector: 'app-cargar-auto',
  templateUrl: './cargar-auto.component.html',
  styleUrls: ['./cargar-auto.component.css']
})
export class CargarAutoComponent implements OnInit {

  public patente;
  public marca;
  public color;
  public kilometros;
  public tipo = "auto";
  public test = 5005;

  constructor(private conexion: ConexionService) { }

  ngOnInit() {

    this.conexion.ObtenerClientes().subscribe(
      exito => console.log("exito" + JSON.stringify(exito)),
      error => alert("error" + JSON.stringify(error))
    );
  }

  CargarAuto() {

    if(!this.patente || !this.marca || !this.color || !this.kilometros) {
      
      alert("Todos los campos deben ser completados...");
      return;
    }

    let JWTHelper = new JwtHelperService();
    let token;

    try {
      token = JWTHelper.decodeToken(localStorage.getItem("token"));

      this.conexion.AltaAuto(new Auto(this.patente, this.marca, this.color, this.kilometros, this.tipo, token.correo)).subscribe(
        exito => alert("exito" + JSON.stringify(exito)),
        error => alert("ups...")
      );
    } catch (error) { }

  }
}
