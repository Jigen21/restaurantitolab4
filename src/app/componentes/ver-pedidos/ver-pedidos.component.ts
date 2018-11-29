import { Component, OnInit } from '@angular/core';
import { ConexionService } from "../../servicios/conexion.service";
import { JwtHelperService } from "@auth0/angular-jwt";

@Component({
  selector: 'app-ver-pedidos',
  templateUrl: './ver-pedidos.component.html',
  styleUrls: ['./ver-pedidos.component.css']
})
export class VerPedidosComponent implements OnInit {

  public displayedColumns: string[] = ['nombre', 'estado','cantidad'];
  public turnos = [];
  public misTurnos;
  public mesaUno;
  public mesaDos;
  public correo;
  public tipo;

  constructor(private conexion: ConexionService) 
  { 
    let JWTHelper = new JwtHelperService();
    let token;
    token = JWTHelper.decodeToken(localStorage.getItem("token"));
    
    this.tipo = token.tipo;


    this.conexion.verPedidos(this.tipo).subscribe(
      exito => {

        //this.turnos = (exito as any).rta;
        this.turnos = (exito as any);
        this.misTurnos = this.turnos.filter((value)=> {
          return value.id == 1 && value.estado=="tomado"; 
         // return value.correo == token.user;
        });

        this.mesaDos = this.turnos.filter((value)=> {
          return value.id == 2 && value.estado=="tomado"; 
         // return value.correo == token.user;
        });

        this.mesaUno = this.misTurnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );







  }

  ngOnInit() {
  }

  terminarPedido(numeroMesa)
  {


    this.conexion.terminarPedido(numeroMesa,this.tipo).subscribe(
      exito => {

        //this.turnos = (exito as any).rta;
        this.turnos = (exito as any);
       // this.misTurnos = this.turnos.filter((value)=> {
       //   return value.id == 1; 
         // return value.correo == token.user;
        //});

        //this.mesaUno = this.misTurnos;
      },
      error => alert("Error: " + JSON.stringify(error))
    );

    alert("Pedidos de la mesa uno terminada");



  }

}
