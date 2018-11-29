import { Component, OnInit } from '@angular/core';

import { ConexionService } from "../../servicios/conexion.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  public correo;
  public password;

  constructor(private conexion: ConexionService) { }

  Cliente()
  {
    this.correo="asdfds";
    this.password="123";
    this.Logear()
  }

  Mozo()
  {
    this.correo="mozo";
    this.password="111";
    this.Logear()

  }

  Cocinero()
  {
    this.correo="cocinero";
    this.password="111";
    this.Logear()

  }

  Bartender()
  {
    this.correo="bartender";
    this.password="111";
    this.Logear()

  }

  Candybar()
  {
    this.correo="candybar";
    this.password="111";
    this.Logear()

  }

  Cervezero()
  {
    this.correo="cervezero";
    this.password="111";
    this.Logear()

  }

  Supervisor()
  {
    this.correo="supervisor";
    this.password="111";
    this.Logear()

  }

  ngOnInit() { }

  Logear() {

    if(!this.correo || !this.password) {
      alert("Todos los campos deben ser completados...");
      return;
    }

    this.conexion.Logear(this.correo, this.password).subscribe(
      exito => {

        if((exito as any).error != undefined) {

          alert("Ups... Parece que las credenciales no son validas.");
          console.log((exito as any).error);
        } else {

          //localStorage.setItem("token", (exito as any).token);
          localStorage.setItem("token",JSON.stringify(exito));
          //location.href = "./principal/auto";
          location.href = "./principal/";
        }
        
      },
      error => alert("error" + JSON.stringify(error))
    );
  }
}
